<?php

namespace App\HtmlFormatter;

class HtmlFormatter
{
    protected const DEFAULT_TAG_INTENT = "    ";

    private const DEFAULT_START_OPEN_TAG_INTENT = '';
    private const DEFAULT_ATTRIBUTE_INTENT = ' ';
    private const DEFAULT_OPEN_TAG_INTENT = '';
    private const DEFAULT_VALUE_INTENT = '';
    private const DEFAULT_CLOSING_TAG_INTENT = '';

    public function getDefaultFormat(): HtmlFormat
    {
        return new HtmlFormat(
            self::DEFAULT_START_OPEN_TAG_INTENT,
            self::DEFAULT_ATTRIBUTE_INTENT,
            self::DEFAULT_OPEN_TAG_INTENT,
            self::DEFAULT_VALUE_INTENT,
            self::DEFAULT_CLOSING_TAG_INTENT,
        );
    }

    private function getDefaultIntent(int $depth): string
    {
        return str_repeat(self::DEFAULT_TAG_INTENT, $depth);
    }

    private function getStartOpenTagIntent(int $depth): string
    {
        return (0 < $depth) ? "\n" . $this->getDefaultIntent($depth) : '';
    }

    private function getAttributeIntent(int $attributesCount, int $depth): string
    {
        return (1 < $attributesCount) ? "\n" . self::DEFAULT_TAG_INTENT . $this->getDefaultIntent($depth) : ' ';
    }

    private function getEndOpenTagIntent(int $attributesCount, int $depth): string
    {
        return (1 < $attributesCount) ? "\n" . $this->getDefaultIntent($depth) : '';
    }

    private function getValueIntent(bool $haveValue, int $attributesCount, int $depth): string
    {
        return ($haveValue &&  1 < $attributesCount) ? "\n" . self::DEFAULT_TAG_INTENT . $this->getDefaultIntent($depth) : '';
    }

    private function getClosingTagIntent(int $attributesCount,  bool $haveChildren, int $depth): string
    {
        return (1 < $attributesCount || true === $haveChildren) ? "\n" . $this->getDefaultIntent($depth) : '';
    }

    public function getFormat(int $depth, int $attributesCount, bool $haveChildren, bool $haveValue): HtmlFormat
    {
        return new HtmlFormat(
            $this->getStartOpenTagIntent($depth),
            $this->getAttributeIntent($attributesCount, $depth),
            $this->getEndOpenTagIntent($attributesCount, $depth),
            $this->getValueIntent($haveValue, $attributesCount, $depth),
            $this->getClosingTagIntent($attributesCount, $haveChildren, $depth),
        );
    }
}