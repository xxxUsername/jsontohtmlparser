<?php

namespace App\Parser;

use App\HtmlFormatter\HtmlFormat;
use App\HtmlTags\HtmlTag;
use App\HtmlTags\P;
use App\JsonData\TextHtmlElementPayloadData;

class TextHtmlTagParser extends HtmlTagParser
{
    private const HTML_ELEMENT_TYPE_TEXT = 'text';


    public function getType(): string
    {
        return self::HTML_ELEMENT_TYPE_TEXT;
    }

    /**
     * @param TextHtmlElementPayloadData $payload
     * @return string
     */
    protected function getTagValue($payload): string
    {
        return $payload->text;
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
        return new P(
            $htmlTagValue,
            $htmlTagAttributes,
            $htmlTagStyles,
            $childrenHtmlTags,
            $defaultFormat,
            $depth
        );
    }
}