<?php

namespace App\Parser;

use App\HtmlFormatter\HtmlFormat;
use App\HtmlTags\HtmlTag;
use App\HtmlTags\Img;
use App\JsonData\ImageHtmlElementPayloadData;

class ImageHtmlTagParser extends HtmlTagParser
{
    private const HTML_ELEMENT_TYPE_IMAGE = 'image';

    private const IMAGE_TAG_PROPERTY_SRC = 'src';

    /**
     * @param ImageHtmlElementPayloadData $payload
     * @return string
     */
    protected function getTagValue($payload): string
    {
        return '';
    }

    /**
     * @param ImageHtmlElementPayloadData $payload
     * @return string[]
     */
    protected function getTagAttributes($payload): array
    {
        $attributes = [];

        $attributes[self::IMAGE_TAG_PROPERTY_SRC] = $payload->image->url;

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
        return new Img(
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
        return self::HTML_ELEMENT_TYPE_IMAGE;
    }
}