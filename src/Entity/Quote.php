<?php

namespace App\Entity;

use DateTime;

class Quote
{
    public int $id;
    public int $siteId;
    public int $destinationId;
    public DateTime $dateQuoted;

    public function __construct(int $id, int $siteId, int $destinationId, DateTime $dateQuoted)
    {
        $this->id = $id;
        $this->siteId = $siteId;
        $this->destinationId = $destinationId;
        $this->dateQuoted = $dateQuoted;
    }

    public static function renderHtml(Quote $quote): string
    {
        return '<p>' . $quote->id . '</p>';
    }

    public static function renderText(Quote $quote): string
    {
        return (string) $quote->id;
    }
}