<?php

namespace Tests\QuoteRender;

use App\Entity\Quote;
use App\QuoteRender\QuoteProcess;
use App\QuoteRender\QuoteRenderException;
use App\QuoteRender\QuoteValue;
use App\QuoteRender\Strategy\DestinationLinkStrategy;
use PHPUnit\Framework\TestCase;
use Faker\Factory as FakerFactory;

class QuoteProcessTest extends TestCase
{
    /**
     * @throws QuoteRenderException
     */
    public function testProcessorValid(): void
    {
        $faker = FakerFactory::create();
        $process = new QuoteProcess([new DestinationLinkStrategy()]);
        $text = "before ".QuoteValue::DESTINATION_LINK." after";
        $data = [
            'quote' => new Quote($faker->randomNumber(), $faker->randomNumber(), $faker->randomNumber(), $faker->dateTime()),
        ];
        $text = $process->replaceQuote($text, $data);
        self::assertStringContainsString('http', $text);
    }

    public function testProcessorException(): void
    {
        // Inject not valid strategy.
        self::expectException(QuoteRenderException::class);
        $process = new QuoteProcess([new QuoteRenderException()]);

    }
}