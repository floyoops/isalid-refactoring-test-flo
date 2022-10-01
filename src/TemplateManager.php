<?php

namespace App;

use App\Context\ApplicationContext;
use App\Entity\Quote;
use App\Entity\Template;
use App\Entity\User;
use App\QuoteRender\QuoteDto;
use App\QuoteRender\QuoteInterface;
use App\QuoteRender\QuoteProcess;
use App\QuoteRender\QuoteRenderException;
use App\QuoteRender\Strategy\DestinationLinkStrategy;
use App\QuoteRender\Strategy\DestinationNameStrategy;
use App\QuoteRender\Strategy\SummaryHtmlStrategy;
use App\QuoteRender\Strategy\SummaryStrategy;
use App\QuoteRender\Strategy\UserFirstNameStrategy;

class TemplateManager
{
    public const K_QUOTE = 'quote';
    public const K_USER = 'user';

    private readonly QuoteInterface $quoteProcessor;

    /**
     * @throws QuoteRenderException
     */
    public function __construct()
    {
        $this->quoteProcessor = new QuoteProcess([
            new DestinationLinkStrategy(),
            new SummaryHtmlStrategy(),
            new SummaryStrategy(),
            new DestinationNameStrategy(),
            new UserFirstNameStrategy(),
        ]);
    }

    public function getTemplateComputed(Template $tpl, array $data): Template
    {
        $APPLICATION_CONTEXT = ApplicationContext::getInstance();
        $quote = (isset($data[self::K_QUOTE]) and $data[self::K_QUOTE] instanceof Quote) ? $data[self::K_QUOTE] : null;
        $user = (isset($data[self::K_USER])  and ($data[self::K_USER]  instanceof User)) ? $data[self::K_USER] : $APPLICATION_CONTEXT->getCurrentUser();
        $quoteDto = new QuoteDto($quote, $user);

        $replaced = clone($tpl);
        $replaced->setSubject($this->quoteProcessor->replaceQuote($replaced->getSubject(), $quoteDto));
        $replaced->setContent($this->quoteProcessor->replaceQuote($replaced->getContent(), $quoteDto));

        return $replaced;
    }
}
