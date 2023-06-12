<?php

namespace App\HtmlTags;

use App\HtmlFormatter\HtmlFormat;
use App\HtmlFormatter\HtmlFormatter;

abstract class HtmlTag
{
    protected const STYLE_ATTRIBUTE_TITLE = 'style';

    protected $value;
    protected array $attributes = [];
    protected array $styles = [];
    protected HtmlFormat $defaultFormat;
    protected int $depth = 0;

    /**
     * @var HtmlTag[]
     */
    protected array $children = [];

    /**
     * HtmlTag constructor.
     * @param mixed $value
     * @param array $attributes
     * @param array $styles
     * @param HtmlTag[] $children
     * @param HtmlFormat $defaultFormat
     * @param int $depth
     */
    public function __construct(
        $value,
        array $attributes,
        array $styles,
        array $children,
        HtmlFormat $defaultFormat,
        int $depth = 0
    ) {
        $this->value = $value;
        $this->attributes = $attributes;
        $this->styles = $styles;
        $this->children = $children;
        $this->defaultFormat = $defaultFormat;
        $this->depth = $depth;
    }

    abstract protected function getTagName(): string;

    protected function getAllAttributes(): array
    {
        $attributes = $this->attributes;

        if (count($this->styles)) {
            $attributes[self::STYLE_ATTRIBUTE_TITLE] = $this->getStylesHtml();
        }

        return $attributes;
    }

    protected function haveChildren(): bool
    {
        return (bool)count($this->children);
    }

    protected function haveValue(): bool
    {
        return ('' !== (string)$this->value);
    }

    protected function getChildrenHtml(HtmlFormatter $formatter): string
    {
        $childrenHtml = [];

        foreach ($this->children as $child) {
            $childrenHtml[] .= $child->getHtml($formatter);
        }

        return implode('', $childrenHtml);
    }

    protected function getAttributesCount(): int
    {
        return count($this->getAllAttributes());
    }

    protected function getAttributesHtml(string $attributeIntent): string
    {
        $attributesHtml = [];
        $allAttributes = $this->getAllAttributes();

        if (count($allAttributes) === 0) {
            return '';
        }

        foreach ($allAttributes as $attributeTittle => $attributeValue) {
            $attributesHtml[] = $attributeIntent . $attributeTittle . '="' . $attributeValue . '"';
        }

        return implode('', $attributesHtml);
    }

    protected function getStylesHtml(): string
    {
        $stylesHtml = [];

        foreach ($this->styles as $styleTitle => $styleValue) {
            $stylesHtml[] = $styleTitle . ': ' . $styleValue;
        }

        return implode('; ', $stylesHtml);
    }

    public function getHtml(HtmlFormatter $formatter = null): string
    {
        $format = is_null($formatter) ? $this->defaultFormat : $formatter->getFormat(
            $this->depth,
            $this->getAttributesCount(),
            $this->haveChildren(),
            $this->haveValue(),
        );

        $html = $format->startOpenTagIntent . '<' . $this->getTagName();
        $html .= $this->getAttributesHtml($format->attributeIntent);
        $html .= $format->endOpenTagIntent . '>';
        $html .= $this->getChildrenHtml($formatter);
        $html .= $format->valueIntent . $this->value;
        $html .= $format->closingTagIntent . '</' . $this->getTagName() . '>';

        return $html;
    }


}
