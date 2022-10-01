<?php

namespace Tests;

use App\Context\ApplicationContext;
use App\Entity\Quote;
use App\Entity\Template;
use App\Repository\DestinationRepository;
use App\Repository\SiteRepository;
use App\TemplateManager;
use PHPUnit\Framework\TestCase;
use Faker\Factory as FakerFactory;

class TemplateManagerTest extends TestCase
{
    /**
     * @test
     */
    public function test()
    {
        $faker = FakerFactory::create();

        $destinationId                  = $faker->randomNumber();
        $expectedDestination = DestinationRepository::getInstance()->getById($destinationId);
        $expectedUser        = ApplicationContext::getInstance()->getCurrentUser();

        $quote = new Quote($faker->randomNumber(), $faker->randomNumber(), $destinationId, $faker->date());

        $template = new Template(
            1,
            'Votre livraison à [quote:destination_name]',
            "
Bonjour [user:first_name],

Merci de nous avoir contacté pour votre livraison à [quote:destination_name].

Bien cordialement,

L'équipe de Shipper
");
        $templateManager = new TemplateManager();

        $message = $templateManager->getTemplateComputed(
            $template,
            [
                'quote' => $quote
            ]
        );

        $this->assertEquals('Votre livraison à ' . $expectedDestination->countryName, $message->subject);
        $this->assertEquals("
Bonjour " . $expectedUser->firstname . ",

Merci de nous avoir contacté pour votre livraison à " . $expectedDestination->countryName . ".

Bien cordialement,

L'équipe de Shipper
", $message->content);
    }

    public function testWithDestinationLink(): void
    {
        $faker = FakerFactory::create();

        $siteId = $faker->randomNumber();
        $expectedSite = SiteRepository::getInstance()->getById($siteId);

        $quote = new Quote($faker->randomNumber(), $siteId, $faker->randomNumber(), $faker->date());

        $template = new Template(
            1,
            'Votre livraison à [quote:destination_name]',
            "
Bonjour [user:first_name],

Merci de nous avoir contacté pour votre livraison à [quote:destination_name].

Plus d'infos sur la destination: [quote:destination_link]

Bien cordialement,

L'équipe de Shipper
");
        $templateManager = new TemplateManager();

        $message = $templateManager->getTemplateComputed(
            $template,
            [
                'quote' => $quote
            ]
        );

        $this->assertStringContainsString("Plus d'infos sur la destination: ". $expectedSite->url, $message->content);
    }

    public function testWithFakeQuote(): void
    {
        $faker = FakerFactory::create();
        $quote = new Quote($faker->randomNumber(), $faker->randomNumber(), $faker->randomNumber(), $faker->date());

        $template = new Template(
            1,
            'Votre livraison à [quote:destination_name]',
            "
Bonjour [user:first_name],

Merci de nous avoir contacté pour votre livraison à [quote:destination_name].

quote fake: [quote:fake].

Bien cordialement,

L'équipe de Shipper
");
        $templateManager = new TemplateManager();
        $message = $templateManager->getTemplateComputed($template, ['quote' => $quote]);
        $this->assertIsString('quote fake: [quote:fake].', $message->content);
    }
}
