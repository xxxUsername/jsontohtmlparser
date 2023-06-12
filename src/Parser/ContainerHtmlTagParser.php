<?php

namespace App\Parser;

use App\HtmlFormatter\HtmlFormat;
use App\HtmlTags\Div;
use App\HtmlTags\HtmlTag;

class ContainerHtmlTagParser extends HtmlTagParser
{
    private const HTML_ELEMENT_TYPE_CONTAINER = 'container';

    protected function getTagValue($payload): string
    {
        return '';
    }

    protected function getTagAttributes($payload): array
    {
        return [];
    }

    protected function createHtmlTagObject(
        string $htmlTagValue,
        array $htmlTagAttributes,
        array $htmlTagStyles,
        array $childrenHtmlTags,
        HtmlFormat $defaultFormat,
        int $depth
    ): HtmlTag {
        return new Div(
            $htmlTagValue,
            $htmlTagAttributes,
            $htmlTagStyles,
            $childrenHtmlTags,
            $defaultFormat,
            $depth
        );
    }

    public function getType(): string
    {
        return self::HTML_ELEMENT_TYPE_CONTAINER;
    }
}