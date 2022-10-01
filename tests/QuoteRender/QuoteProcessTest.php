<?php

namespace Tests\QuoteRender;

use App\QuoteRender\QuoteDto;
use App\QuoteRender\QuoteProcess;
use App\QuoteRender\QuoteRenderException;
use App\QuoteRender\QuoteValue;
use App\QuoteRender\Strategy\DestinationLinkStrategy;
use App\QuoteRender\Strategy\DestinationNameStrategy;
use App\QuoteRender\Strategy\SummaryHtmlStrategy;
use App\QuoteRender\Strategy\SummaryStrategy;
use App\QuoteRender\Strategy\UserFirstNameStrategy;
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
            new DestinationNameStrategy(),
            new UserFirstNameStrategy(),
        ]);
        $text = "
            before ".QuoteValue::DESTINATION_LINK."
            second ".QuoteValue::SUMMARY_HTML." 
            third ".QuoteValue::SUMMARY." 
            fourth ".QuoteValue::DESTINATION_NAME."
            fifth ".QuoteValue::USER_FIRST_NAME."
            after
        ";
        $quote = StrategyTestData::getQuoteValid();
        $user = StrategyTestData::getUserValid();

        $text = $quoteProcess->replaceQuote($text, new QuoteDto($quote, $user));
        self::assertStringContainsString('http', $text);
        self::assertStringContainsString('<p>'.$quote->id.'</p>', $text);
        self::assertStringContainsString('third '.$quote->id, $text);
        self::assertStringContainsString('fifth '.$user->firstname, $text);

        self::assertStringNotContainsString('third '.QuoteValue::SUMMARY, $text);
        self::assertStringNotContainsString('fourth '.QuoteValue::DESTINATION_NAME, $text);
    }

    public function testProcessorException(): void
    {
        // Inject not valid strategy.
        self::expectException(QuoteRenderException::class);
        new QuoteProcess([new QuoteRenderException()]);
    }
}