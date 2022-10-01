<?php

namespace App\QuoteRender\Strategy;

use App\QuoteRender\QuoteInterface;
use App\QuoteRender\QuoteValue;

class SummaryHtmlStrategy extends QuoteStrategyAbstract
{
    public function replaceQuote(string $text, array $data): string
    {
        // Return as soon as possible if require not valid.
        if (!str_contains($text, QuoteValue::SUMMARY_HTML)) return $text;
        $quote = $this->getQuote($data);
        if (!$quote?->id) return $this->replaceDefault($text, QuoteValue::SUMMARY_HTML);

        return str_replace(QuoteValue::SUMMARY_HTML, '<p>'.$quote->id.'</p>', $text);
    }
}
