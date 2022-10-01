<?php

namespace Tests\QuoteRender\Strategy;

use App\Entity\Quote;
use App\QuoteRender\QuoteValue;
use App\QuoteRender\Strategy\DestinationLinkStrategy;
use App\Repository\DestinationRepository;
use App\Repository\SiteRepository;
use PHPUnit\Framework\TestCase;
use Faker\Factory as FakerFactory;

class DestinationLinkStrategyTest extends TestCase
{
    /**
     * @dataProvider provideDestinationLinkStrategy
     */
    public function testDestinationLinkStrategy(string $text, array $data, string $textExpected): void
    {
        $strategy = new DestinationLinkStrategy();
        $text = $strategy->replaceQuote($text, $data);
        self::assertEquals($text, $textExpected);
    }

    public function provideDestinationLinkStrategy(): array
    {
        $quoteValid = StrategyTestData::getQuoteValid();
        $dataValid = ['quote' => $quoteValid];
        $templateValid = 'before '.QuoteValue::DESTINATION_LINK.' after';
        $templateFake = 'before [quote::fake] after';
        $expectedDestination = DestinationRepository::getInstance()->getById($quoteValid->destinationId);
        $expectedSite = SiteRepository::getInstance()->getById($quoteValid->siteId);

        return [
            // Data ok but without quote destination_link, return the origin text.
            [$templateFake, $dataValid, $templateFake],
            // Quote ok but data empty. -> replace default.
            [$templateValid, [], 'before  after',],
            // valid.
            [
                $templateValid,
                $dataValid,
                'before '.$expectedSite->url.'/'.$expectedDestination->countryName.'/quote/'.$quoteValid->id.' after'
            ],
        ];
    }
}
