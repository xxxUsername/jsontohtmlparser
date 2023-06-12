<?php

namespace App\HtmlFormatter;

class HtmlFormat
{
    public string $startOpenTagIntent;
    public string $attributeIntent;
    public string $endOpenTagIntent;
    public string $valueIntent;
    public string $closingTagIntent;

    public function __construct(
        string $startOpenTagIntent,
        string $attributeIntent,
        string $endOpenTagIntent,
        string $valueIntent,
        string $closingTagIntent
    ) {
        $this->startOpenTagIntent = $startOpenTagIntent;
        $this->attributeIntent = $attributeIntent;
        $this->endOpenTagIntent = $endOpenTagIntent;
        $this->valueIntent = $valueIntent;
        $this->closingTagIntent = $closingTagIntent;
    }
}