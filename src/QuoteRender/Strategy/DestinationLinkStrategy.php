<?php

namespace App\QuoteRender\Strategy;

use App\Entity\Destination;
use App\Entity\Quote;
use App\Entity\Site;
use App\QuoteRender\QuoteValue;
use App\Repository\DestinationRepository;
use App\Repository\SiteRepository;

class DestinationLinkStrategy extends QuoteStrategyAbstract
{
    public function replaceQuote(string $text, array $data): string
    {
        // Return as soon as possible if require not valid.
        if (!str_contains($text, QuoteValue::DESTINATION_LINK)) return $text;
        $quote = $this->getQuote($data);
        if (!$quote?->destinationId && !$quote?->siteId) return $this->replaceDefault($text, QuoteValue::DESTINATION_LINK);

        // fetch data.
        $site = SiteRepository::getInstance()->getById($quote->siteId);
        $destination = DestinationRepository::getInstance()->getById($quote->destinationId);

        // Replace the quote by the link.
        return str_replace(
            QuoteValue::DESTINATION_LINK,
            $this->generateDestinationLink($site, $destination, $quote->id),
            $text
        );
    }

    private function generateDestinationLink(Site $site, Destination $destination, int $quoteId): string
    {
        return $site->url.'/'.$destination->countryName.'/quote/'.$quoteId;
    }
}
