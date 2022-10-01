<?php

namespace Tests\QuoteRender\Strategy;

use App\QuoteRender\QuoteDto;
use App\QuoteRender\QuoteValue;
use App\QuoteRender\Strategy\SummaryStrategy;
use PHPUnit\Framework\TestCase;

class SummaryStrategyTest extends TestCase
{
    /**
     * @dataProvider provideSummaryStrategy
     */
    public function testSummaryStrategy(string $text, QuoteDto $data, string $textExpected): void
    {
        $strategy = new SummaryStrategy();
        $text = $strategy->replaceQuote($text, $data);
        self::assertEquals($textExpected, $text);
    }

    public function provideSummaryStrategy(): array
    {
        $quoteValid = StrategyTestData::getQuoteValid();
        $dataValid = new QuoteDto(quote: $quoteValid);
        $templateFake = 'before [quote::fake] after';
        $templateValid = 'before '.QuoteValue::SUMMARY.' after';

        return [
            // Data ok but without quote summary, return the origin text.
            [$templateFake, $dataValid, $templateFake],
            // Quote ok but data empty -> replace default,
            [$templateValid, new QuoteDto(), 'before  after'],
            // valid
            [
                $templateValid,
                $dataValid,
                'before '.$quoteValid->getId().' after',
            ]
        ];
    }
}