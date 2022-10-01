<?php

namespace App\Entity;

class Destination
{
    public function __construct(
        private readonly int $id,
        private readonly string $countryName,
        private readonly string $conjunction,
        private readonly string $computerName
    )
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCountryName(): string
    {
        return $this->countryName;
    }

    public function getConjunction(): string
    {
        return $this->conjunction;
    }

    public function getComputerName(): string
    {
        return $this->computerName;
    }
}
