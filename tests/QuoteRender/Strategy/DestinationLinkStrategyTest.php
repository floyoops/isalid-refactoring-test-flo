<?php

namespace Tests\QuoteRender\Strategy;

use App\QuoteRender\QuoteDto;
use App\QuoteRender\QuoteValue;
use App\QuoteRender\Strategy\DestinationLinkStrategy;
use App\Repository\DestinationRepository;
use App\Repository\SiteRepository;
use PHPUnit\Framework\TestCase;

class DestinationLinkStrategyTest extends TestCase
{
    /**
     * @dataProvider provideDestinationLinkStrategy
     */
    public function testDestinationLinkStrategy(string $text, QuoteDto $data, string $textExpected): void
    {
        $strategy = new DestinationLinkStrategy();
        $text = $strategy->replaceQuote($text, $data);
        self::assertEquals($text, $textExpected);
    }

    public function provideDestinationLinkStrategy(): array
    {
        $quoteValid = StrategyTestData::getQuoteValid();
        $dataValid = new QuoteDto(quote: $quoteValid);
        $templateValid = 'before '.QuoteValue::DESTINATION_LINK.' after';
        $templateFake = 'before [quote::fake] after';
        $expectedDestination = DestinationRepository::getInstance()->getById($quoteValid->destinationId);
        $expectedSite = SiteRepository::getInstance()->getById($quoteValid->siteId);

        return [
            // Data ok but without quote destination_link, return the origin text.
            [$templateFake, $dataValid, $templateFake],
            // Quote ok but data empty. -> replace default.
            [$templateValid, new QuoteDto(), 'before  after',],
            // valid.
            [
                $templateValid,
                $dataValid,
                'before '.$expectedSite->url.'/'.$expectedDestination->countryName.'/quote/'.$quoteValid->id.' after'
            ],
        ];
    }
}
