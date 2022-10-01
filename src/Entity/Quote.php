<?php

namespace App\Entity;

use DateTime;

class Quote
{
    public function __construct(
        private readonly int $id,
        private readonly int $siteId,
        private readonly int $destinationId,
        private readonly DateTime $dateQuoted)
    {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getSiteId(): int
    {
        return $this->siteId;
    }

    public function getDestinationId(): int
    {
        return $this->destinationId;
    }

    public function getDateQuoted(): DateTime
    {
        return $this->dateQuoted;
    }
}
