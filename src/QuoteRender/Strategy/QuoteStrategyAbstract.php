<?php

namespace App\QuoteRender\Strategy;

use App\QuoteRender\QuoteInterface;

abstract class QuoteStrategyAbstract implements QuoteInterface
{
    protected function replaceDefault(string $text, string $tagQuote): string
    {
        return str_replace($tagQuote, '', $text);
    }
}
