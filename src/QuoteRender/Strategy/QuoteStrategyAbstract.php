<?php

namespace App\QuoteRender\Strategy;

use App\Entity\Quote;
use App\QuoteRender\QuoteInterface;

abstract class QuoteStrategyAbstract implements QuoteInterface
{
    protected function replaceDefault(string $text, string $tagQuote): string
    {
        return str_replace($tagQuote, '', $text);
    }

    protected function getQuote(array $data): ?Quote
    {
        return (isset($data['quote']) and $data['quote'] instanceof Quote) ? $data['quote'] : null;
    }
}
