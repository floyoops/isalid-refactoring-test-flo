<?php

namespace App\QuoteRender;

interface QuoteInterface
{
    public function replaceQuote(string $text, array $data): string;
}