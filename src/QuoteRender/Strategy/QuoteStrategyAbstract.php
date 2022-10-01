<?php

namespace App\QuoteRender\Strategy;

use App\Context\ApplicationContext;
use App\Entity\Quote;
use App\Entity\User;
use App\QuoteRender\QuoteInterface;

abstract class QuoteStrategyAbstract implements QuoteInterface
{
    protected function replaceDefault(string $text, string $tagQuote): string
    {
        return str_replace($tagQuote, '', $text);
    }

    protected function getQuote(array $data): ?Quote
    {
        return (isset($data['quote']) and $data['quote'] instanceof Quote) ? $data['quote'] : null;
    }

    protected function getUser(array $data): User
    {
        $APPLICATION_CONTEXT = ApplicationContext::getInstance();
        return (isset($data['user'])  and ($data['user']  instanceof User))  ? $data['user']  : $APPLICATION_CONTEXT->getCurrentUser();
    }
}
