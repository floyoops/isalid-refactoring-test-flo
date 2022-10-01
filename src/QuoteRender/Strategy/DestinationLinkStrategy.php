<?php

namespace App\QuoteRender\Strategy;

use App\Entity\Destination;
use App\Entity\Site;
use App\QuoteRender\QuoteDto;
use App\QuoteRender\QuoteValue;
use App\Repository\DestinationRepository;
use App\Repository\SiteRepository;

class DestinationLinkStrategy extends QuoteStrategyAbstract
{
    public function replaceQuote(string $text, QuoteDto $quoteDto): string
    {
        // Return as soon as possible if require not valid.
        if (!str_contains($text, QuoteValue::DESTINATION_LINK)) return $text;
        $quote = $quoteDto->getQuote();
        if (!$quote?->getDestinationId() && !$quote?->getSiteId()) return $this->replaceDefault($text, QuoteValue::DESTINATION_LINK);

        // fetch data.
        $site = SiteRepository::getInstance()->getById($quote->getSiteId());
        $destination = DestinationRepository::getInstance()->getById($quote->getDestinationId());

        // Replace the quote by the link.
        return str_replace(
            QuoteValue::DESTINATION_LINK,
            $this->generateDestinationLink($site, $destination, $quote->getId()),
            $text
        );
    }

    private function generateDestinationLink(Site $site, Destination $destination, int $quoteId): string
    {
        return $site->getUrl().'/'.$destination->getCountryName().'/quote/'.$quoteId;
    }
}
