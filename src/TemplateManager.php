<?php

namespace App;

use App\Context\ApplicationContext;
use App\Entity\Quote;
use App\Entity\Template;
use App\Entity\User;
use App\QuoteRender\QuoteDto;
use App\QuoteRender\QuoteInterface;
use App\QuoteRender\QuoteProcess;
use App\QuoteRender\Strategy\DestinationLinkStrategy;
use App\QuoteRender\Strategy\DestinationNameStrategy;
use App\QuoteRender\Strategy\SummaryHtmlStrategy;
use App\QuoteRender\Strategy\SummaryStrategy;
use App\QuoteRender\Strategy\UserFirstNameStrategy;

class TemplateManager
{
    private readonly QuoteInterface $quoteProcessor;

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
        if (!$tpl) {
            throw new \RuntimeException('no tpl given');
        }

        $APPLICATION_CONTEXT = ApplicationContext::getInstance();
        $quote = (isset($data['quote']) and $data['quote'] instanceof Quote) ? $data['quote'] : null;
        $user = (isset($data['user'])  and ($data['user']  instanceof User)) ? $data['user']  : $APPLICATION_CONTEXT->getCurrentUser();
        $quoteDto = new QuoteDto($quote, $user);

        $replaced = clone($tpl);
        $replaced->setSubject($this->quoteProcessor->replaceQuote($replaced->getSubject(), $quoteDto));
        $replaced->setContent($this->quoteProcessor->replaceQuote($replaced->getContent(), $quoteDto));

        return $replaced;
    }
}
