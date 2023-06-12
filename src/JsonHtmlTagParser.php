<?php

namespace App;

use App\HtmlTags\HtmlTag;
use App\Parser\HtmlTagParserSelector;
use DomainException;
use JsonException;

class JsonHtmlTagParser
{
    private const HTML_ELEMENT_PROPERTY_TYPE = 'type';

    private HtmlTagParserSelector $htmlTagParserSelector;

    public function __construct(HtmlTagParserSelector $htmlTagParserSelector)
    {
        $this->htmlTagParserSelector = $htmlTagParserSelector;
    }

    /**
     * @param string $jsonData
     * @return HtmlTag
     * @throws JsonException|DomainException
     */
    public function __invoke(string $jsonData): HtmlTag
    {
        $htmlData = json_decode($jsonData, false, 512, JSON_THROW_ON_ERROR);

        if (false === property_exists($htmlData, self::HTML_ELEMENT_PROPERTY_TYPE)) {
            throw new DomainException('Html element property type not exist');
        }

        return $this->htmlTagParserSelector
            ->selectParser($htmlData->type)
            ->parseHtmlTagObject($htmlData, $this->htmlTagParserSelector);
    }
}