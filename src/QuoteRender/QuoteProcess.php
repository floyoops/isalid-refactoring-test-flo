<?php

namespace App\QuoteRender;

class QuoteProcess implements QuoteInterface
{

    /**
     * @throws QuoteRenderException
     */
    public function __construct(private readonly array $quotesStrategies)
    {
        $this->srategiesIsValidOrException($this->quotesStrategies);
    }

    public function replaceQuote(string $text, QuoteDto $quoteDto): string
    {
        /** @var QuoteInterface $quotesStrategy */
        foreach ($this->quotesStrategies as $quotesStrategy)
        {
            $text = $quotesStrategy->replaceQuote($text, $quoteDto);
        }

        return $text;
    }

    /**
     * @throws QuoteRenderException
     */
    private function srategiesIsValidOrException(array $quotesStrategies): void
    {
        $fn = fn($quoteStrategy) => (!$quoteStrategy instanceof QuoteInterface) ? throw new QuoteRenderException('QuoteStrategy does not implement QuoteInterface') : true;
        array_walk($quotesStrategies, $fn);
    }
}
