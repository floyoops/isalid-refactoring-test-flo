<?php

namespace App\QuoteRender\Strategy;

use App\QuoteRender\QuoteValue;

class UserFirstNameStrategy extends QuoteStrategyAbstract
{
    public function replaceQuote(string $text, array $data): string
    {
        // Return as soon as possible if require not valid.
        if (!str_contains($text, QuoteValue::USER_FIRST_NAME)) return $text;
        $user = $this->getUser($data);

        return str_replace(QuoteValue::USER_FIRST_NAME, ucfirst(mb_strtolower($user->firstname)), $text);
    }
}
