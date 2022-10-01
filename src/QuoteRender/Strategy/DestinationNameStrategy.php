<?php

namespace App\QuoteRender\Strategy;

use App\QuoteRender\QuoteValue;
use App\Repository\DestinationRepository;

class DestinationNameStrategy extends QuoteStrategyAbstract
{
    public function replaceQuote(string $text, array $data): string
    {
        // Return as soon as possible if require not valid.
        if (!str_contains($text, QuoteValue::DESTINATION_NAME)) return $text;
        $quote = $this->getQuote($data);
        if (!$quote?->destinationId) return $this->replaceDefault($text, QuoteValue::DESTINATION_NAME);

        // fetch
        $destinationOfQuote = DestinationRepository::getInstance()->getById($quote->destinationId);

        return str_replace(QuoteValue::DESTINATION_NAME, $destinationOfQuote->countryName, $text);
    }
}
