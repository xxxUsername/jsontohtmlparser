<?php

namespace App\Parser;

use App\HtmlFormatter\HtmlFormat;
use App\HtmlFormatter\HtmlFormatter;
use App\HtmlTags\HtmlTag;
use App\JsonData\BlockHtmlElementData;
use App\JsonData\ButtonHtmlElementData;
use App\JsonData\ButtonHtmlElementPayloadData;
use App\JsonData\ContainerHtmlElementData;
use App\JsonData\ImageHtmlElementData;
use App\JsonData\ImageHtmlElementPayloadData;
use App\JsonData\TextHtmlElementData;
use App\JsonData\TextHtmlElementPayloadData;
use DomainException;
use stdClass;

abstract class HtmlTagParser
{
    private const HTML_PROPERTY_CHILDREN = 'children';

    protected HtmlTagStyleParser $htmlTagStyleParser;

    protected HtmlFormatter $htmlFormatter;

    public function __construct(HtmlTagStyleParser $htmlTagStyleParser, HtmlFormatter $htmlFormatter)
    {
        $this->htmlTagStyleParser = $htmlTagStyleParser;
        $this->htmlFormatter = $htmlFormatter;
    }

    /**
     * @param BlockHtmlElementData|ContainerHtmlElementData|ButtonHtmlElementData|ImageHtmlElementData|TextHtmlElementData $htmlElement
     * @param HtmlTagParserSelector $htmlTagParserSelector
     * @param int $depth
     * @return HtmlTag
     * @throws DomainException
     */
    public function parseHtmlTagObject(
        $htmlElement,
        HtmlTagParserSelector $htmlTagParserSelector,
        int $depth = 0
    ): HtmlTag {
        $childrenHtmlTags = [];

        if (property_exists($htmlElement, self::HTML_PROPERTY_CHILDREN)) {
            foreach ($htmlElement->children as $childrenHtmlElement) {
                $childrenHtmlTags[] = $htmlTagParserSelector->selectParser(
                    $childrenHtmlElement->type
                )->parseHtmlTagObject(
                    $childrenHtmlElement,
                    $htmlTagParserSelector,
                    $depth + 1
                );
            }
        }

        $htmlValue = $this->getTagValue($htmlElement->payload);
        $htmlAttributes = $this->getTagAttributes($htmlElement->payload);
        $htmlStyles = $this->getTagStyles($htmlElement);
        $parsedStyles = $this->htmlTagStyleParser->parseStyles($htmlStyles);
        $defaultFormat = $this->htmlFormatter->getDefaultFormat();

        return $this->createHtmlTagObject(
            $htmlValue,
            $htmlAttributes,
            $parsedStyles,
            $childrenHtmlTags,
            $defaultFormat,
            $depth
        );
    }

    abstract public function getType(): string;

    /**
     * @param ButtonHtmlElementPayloadData|TextHtmlElementPayloadData|ImageHtmlElementPayloadData|StdClass|null $payload
     * @return string
     */
    abstract protected function getTagValue($payload): string;

    /**
     * @param ButtonHtmlElementPayloadData|TextHtmlElementPayloadData|ImageHtmlElementPayloadData|StdClass|null $payload
     * @return string[]
     */
    abstract protected function getTagAttributes($payload): array;

    /**
     * @param BlockHtmlElementData|ContainerHtmlElementData|ButtonHtmlElementData|ImageHtmlElementData|TextHtmlElementData $htmlElement
     * @return string[]
     */
    protected function getTagStyles($htmlElement): array
    {
        return (array)$htmlElement->parameters;
    }

    /**
     * @param string $htmlTagValue
     * @param string[] $htmlTagAttributes
     * @param string[] $htmlTagStyles
     * @param HtmlTag[] $childrenHtmlTags
     * @param HtmlFormat $defaultFormat
     * @param int $depth
     * @return HtmlTag
     */
    abstract protected function createHtmlTagObject(
        string $htmlTagValue,
        array $htmlTagAttributes,
        array $htmlTagStyles,
        array $childrenHtmlTags,
        HtmlFormat $defaultFormat,
        int $depth
    ): HtmlTag;

}