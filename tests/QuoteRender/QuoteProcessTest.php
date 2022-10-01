<?php

namespace Tests\QuoteRender;

use App\QuoteRender\QuoteProcess;
use App\QuoteRender\QuoteRenderException;
use App\QuoteRender\QuoteValue;
use App\QuoteRender\Strategy\DestinationLinkStrategy;
use App\QuoteRender\Strategy\SummaryHtmlStrategy;
use App\QuoteRender\Strategy\SummaryStrategy;
use PHPUnit\Framework\TestCase;
use Tests\QuoteRender\Strategy\StrategyTestData;

class QuoteProcessTest extends TestCase
{
    /**
     * @throws QuoteRenderException
     */
    public function testProcessorValid(): void
    {
        $quoteProcess = new QuoteProcess([
            new DestinationLinkStrategy(),
            new SummaryHtmlStrategy(),
            new SummaryStrategy(),
        ]);
        $text = "before ".QuoteValue::DESTINATION_LINK." second ".QuoteValue::SUMMARY_HTML." third ".QuoteValue::SUMMARY." after";
        $quote = StrategyTestData::getQuoteValid();
        $data = ['quote' => $quote];
        $text = $quoteProcess->replaceQuote($text, $data);
        self::assertStringContainsString('http', $text);
        self::assertStringContainsString('<p>'.$quote->id.'</p>', $text);
        self::assertStringContainsString('third '.$quote->id, $text);
    }

    public function testProcessorException(): void
    {
        // Inject not valid strategy.
        self::expectException(QuoteRenderException::class);
        new QuoteProcess([new QuoteRenderException()]);
    }
}