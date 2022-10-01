<?php

namespace App\Entity;

class Site
{
    public function __construct(
        private readonly int $id,
        private readonly string $url
    )
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}
