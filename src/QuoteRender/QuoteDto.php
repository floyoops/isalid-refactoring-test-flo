<?php

namespace App\QuoteRender;

use App\Entity\Quote;
use App\Entity\User;

class QuoteDto
{
    private ?Quote $quote;
    private ?User $user;

    public function __construct(?Quote $quote = null, ?User $user = null)
    {
        $this->quote = $quote;
        $this->user = $user;
    }

    public function getQuote(): ?Quote
    {
        return $this->quote;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }
}
