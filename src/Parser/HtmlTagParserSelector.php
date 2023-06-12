<?php

namespace App\Parser;

use DomainException;

class HtmlTagParserSelector
{
    /**
     * @var HtmlTagParser[]
     */
    private array $htmlTagParsers = [];

    public function __construct(array $htmlTagParsers)
    {
        foreach ($htmlTagParsers as $htmlTagParser) {
            $this->htmlTagParsers[$htmlTagParser->getType()] = $htmlTagParser;
        }
    }

    public function selectParser(string $htmlElementType): HtmlTagParser
    {
        if (false === array_key_exists($htmlElementType, $this->htmlTagParsers)) {
            throw new DomainException('Html element type not found: ' . $htmlElementType);
        }

        return $this->htmlTagParsers[$htmlElementType];
    }
}