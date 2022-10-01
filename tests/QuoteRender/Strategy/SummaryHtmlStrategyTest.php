<?php

namespace Tests\QuoteRender\Strategy;

use App\QuoteRender\QuoteValue;
use App\QuoteRender\Strategy\SummaryHtmlStrategy;
use PHPUnit\Framework\TestCase;

class SummaryHtmlStrategyTest extends TestCase
{
    /**
     * @dataProvider provideSummaryHtml
     */
    public function testSummaryHtml(string $text, array $data, string $textExpected): void
    {
        $strategy = new SummaryHtmlStrategy();
        $text = $strategy->replaceQuote($text, $data);
        self::assertEquals($text, $textExpected);
    }

    public function provideSummaryHtml(): array
    {
        $quoteValid = StrategyTestData::getQuoteValid();
        $dataValid = ['quote' => $quoteValid];
        $templateFake = 'before [quote::fake] after';
        $templateValid = 'before '.QuoteValue::SUMMARY_HTML.' after';
        return [
            // Data ok but without quote destination_link, return the origin text.
            [$templateFake, $dataValid, $templateFake],
            // Quote ok but data empty -> replace default,
            [$templateValid, [], 'before  after'],
            // valid
            [
                $templateValid,
                $dataValid,
                'before <p>'.$quoteValid->id.'</p> after',
            ]
        ];
    }
}
