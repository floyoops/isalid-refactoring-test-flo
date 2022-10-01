<?php

namespace App\QuoteRender;

use App\Entity\Quote;
use App\Entity\User;

class QuoteDto
{
    public function __construct(
        private readonly ?Quote $quote = null,
        private readonly ?User $user = null
    ){}

    public function getQuote(): ?Quote
    {
        return $this->quote;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }
}
