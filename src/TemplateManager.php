<?php

namespace App;

use App\Entity\Template;
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

        $replaced = clone($tpl);

        $replaced->subject = $this->quoteProcessor->replaceQuote($replaced->subject, $data);
        $replaced->content = $this->quoteProcessor->replaceQuote($replaced->content, $data);

        return $replaced;
    }
}
