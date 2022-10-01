<?php

namespace App\Entity;

class Destination
{
    public int $id;
    public string $countryName;
    public string $conjunction;
    public string $name;
    public string $computerName;

    public function __construct(int $id, string $countryName, string $conjunction, string $computerName)
    {
        $this->id = $id;
        $this->countryName = $countryName;
        $this->conjunction = $conjunction;
        $this->computerName = $computerName;
    }
}
