<?php

namespace App\Parser;

use App\HtmlFormatter\HtmlFormat;
use App\HtmlTags\A;
use App\HtmlTags\HtmlTag;
use App\JsonData\ButtonHtmlElementPayloadData;

class ButtonHtmlTagParser extends HtmlTagParser
{
    private const HTML_ELEMENT_TYPE_BUTTON = 'button';

    private const BUTTON_TAG_PROPERTY_HREF = 'href';

    public function getType(): string
    {
        return self::HTML_ELEMENT_TYPE_BUTTON;
    }

    /**
     * @param ButtonHtmlElementPayloadData $payload
     * @return string
     */
    protected function getTagValue($payload): string
    {
        return $payload->text;
    }

    /**
     * @param ButtonHtmlElementPayloadData $payload
     * @return string[]
     */
    protected function getTagAttributes($payload): array
    {
        $attributes = [];

        $attributes[self::BUTTON_TAG_PROPERTY_HREF] = $payload->link->payload;

        return $attributes;
    }

    protected function createHtmlTagObject(
        string $htmlTagValue,
        array $htmlTagAttributes,
        array $htmlTagStyles,
        array $childrenHtmlTags,
        HtmlFormat $defaultFormat,
        int $depth
    ): HtmlTag {
        return new A(
            $htmlTagValue,
            $htmlTagAttributes,
            $htmlTagStyles,
            $childrenHtmlTags,
            $defaultFormat,
            $depth
        );
    }
}