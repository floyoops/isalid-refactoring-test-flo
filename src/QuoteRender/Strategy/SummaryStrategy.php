<?php

namespace App\QuoteRender\Strategy;

use App\Entity\Quote;
use App\QuoteRender\QuoteValue;

class SummaryStrategy extends QuoteStrategyAbstract
{
    public function replaceQuote(string $text, array $data): string
    {
        // Return as soon as possible if require not valid.
        if (!str_contains($text, QuoteValue::SUMMARY)) return $text;
        $quote = $this->getQuote($data);
        if (!$quote?->id) return $this->replaceDefault($text, QuoteValue::SUMMARY);

        return str_replace(QuoteValue::SUMMARY, $quote->id, $text);
    }
}
