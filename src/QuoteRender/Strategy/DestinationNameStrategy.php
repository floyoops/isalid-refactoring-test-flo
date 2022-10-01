<?php

namespace App\QuoteRender\Strategy;

use App\QuoteRender\QuoteDto;
use App\QuoteRender\QuoteValue;
use App\Repository\DestinationRepository;

class DestinationNameStrategy extends QuoteStrategyAbstract
{
    public function replaceQuote(string $text, QuoteDto $quoteDto): string
    {
        // Return as soon as possible if require not valid.
        if (!str_contains($text, QuoteValue::DESTINATION_NAME)) return $text;
        $quote = $quoteDto->getQuote();
        if (!$quote?->getDestinationId()) return $this->replaceDefault($text, QuoteValue::DESTINATION_NAME);

        // fetch
        $destinationOfQuote = DestinationRepository::getInstance()->getById($quote->getDestinationId());

        return str_replace(QuoteValue::DESTINATION_NAME, $destinationOfQuote->getCountryName(), $text);
    }
}
