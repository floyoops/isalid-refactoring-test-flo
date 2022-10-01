<?php

namespace App\QuoteRender\Strategy;

use App\QuoteRender\QuoteDto;
use App\QuoteRender\QuoteValue;

class SummaryStrategy extends QuoteStrategyAbstract
{
    public function replaceQuote(string $text, QuoteDto $quoteDto): string
    {
        // Return as soon as possible if require not valid.
        if (!str_contains($text, QuoteValue::SUMMARY)) return $text;
        $quote = $quoteDto->getQuote();
        if (!$quote?->id) return $this->replaceDefault($text, QuoteValue::SUMMARY);

        return str_replace(QuoteValue::SUMMARY, $quote->id, $text);
    }
}
