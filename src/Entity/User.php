<?php

namespace App\Entity;

class User
{
    public function __construct(
        private readonly int $id,
        private readonly string $firstname,
        private readonly string $lastname,
        private readonly string $email
    )
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
