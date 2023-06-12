<?php

namespace App\HtmlTags;

class Div extends HtmlTag
{
    private const TAG_NAME = 'div';

    protected function getTagName(): string
    {
        return self::TAG_NAME;
    }
}