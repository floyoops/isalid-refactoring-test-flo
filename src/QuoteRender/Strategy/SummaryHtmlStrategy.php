<?php

namespace App\QuoteRender\Strategy;

use App\QuoteRender\QuoteDto;
use App\QuoteRender\QuoteValue;

class SummaryHtmlStrategy extends QuoteStrategyAbstract
{
    public function replaceQuote(string $text, QuoteDto $quoteDto): string
    {
        // Return as soon as possible if require not valid.
        if (!str_contains($text, QuoteValue::SUMMARY_HTML)) return $text;
        $quote = $quoteDto->getQuote();
        if (!$quote?->getId()) return $this->replaceDefault($text, QuoteValue::SUMMARY_HTML);

        return str_replace(QuoteValue::SUMMARY_HTML, '<p>'.$quote->getId().'</p>', $text);
    }
}
