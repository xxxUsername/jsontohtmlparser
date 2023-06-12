<?php

namespace App\Parser;

class HtmlTagStyleParser
{
    private const STYLE_PROPERTY_TITLE_TEXT_COLOR = 'textColor';
    private const STYLE_PROPERTY_TITLE_COLOR = 'color';

    private const TRUE_AS_STRING = 'true';
    private const FALSE_AS_STRING = 'false';

    public function parseStyles(array $styles): array
    {
        $parsedStyles = [];

        foreach ($styles as $stylePropertyTitle => $stylePropertyValue) {
            if (is_bool($stylePropertyValue)) {
                $stylePropertyValue = $this->booleanStylePropertyValueToString($stylePropertyValue);
            }
            $parsedStyles[$this->parseStylePropertyTitle($stylePropertyTitle)] = $stylePropertyValue;
        }

        return $parsedStyles;
    }

    private function booleanStylePropertyValueToString(bool $property): string
    {
        if ($property) {
            return self::TRUE_AS_STRING;
        }

        return self::FALSE_AS_STRING;
    }

    private function parseStylePropertyTitle(string $property): string
    {
        if ($property === self::STYLE_PROPERTY_TITLE_TEXT_COLOR) {
            return self::STYLE_PROPERTY_TITLE_COLOR;
        }

        return $this->stylePropertyFromCamelCaseToCssCase($property);
    }

    private function stylePropertyFromCamelCaseToCssCase($string): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $string));
    }
}