<?php

namespace Tests\QuoteRender\Strategy;

use App\QuoteRender\QuoteDto;
use App\QuoteRender\QuoteValue;
use App\QuoteRender\Strategy\DestinationNameStrategy;
use App\Repository\DestinationRepository;
use App\Repository\SiteRepository;
use PHPUnit\Framework\TestCase;

class DestinationNameStrategyTest extends TestCase
{
    /**
     * @dataProvider provideDestinationNameStrategy
     */
    public function testDestinationNameStrategy(string $text, QuoteDto $data, string $textExpected): void
    {
        $strategy = new DestinationNameStrategy();
        $text = $strategy->replaceQuote($text, $data);
        self::assertEquals($text, $textExpected);
    }

    public function provideDestinationNameStrategy(): array
    {
        $quoteValid = StrategyTestData::getQuoteValid();
        $dataValid = new QuoteDto(quote: $quoteValid);
        $templateValid = 'before '.QuoteValue::DESTINATION_NAME.' after';
        $templateFake = 'before [quote::fake] after';
        $expectedDestination = DestinationRepository::getInstance()->getById($quoteValid->destinationId);
        $expectedSite = SiteRepository::getInstance()->getById($quoteValid->siteId);

        return [
            // Data ok but without quote destination_name, return the origin text.
            [$templateFake, $dataValid, $templateFake],
            // Quote ok but data empty. -> replace default.
            [$templateValid, new QuoteDto(), 'before  after'],
            // Valid
            [
                $templateValid,
                $dataValid,
                'before '.$expectedDestination->countryName.' after',
            ]
        ];
    }
}
