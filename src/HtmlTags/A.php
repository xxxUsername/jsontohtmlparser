<?php

namespace App\HtmlTags;

class A extends HtmlTag
{
    private const TAG_NAME = 'a';

    protected function getTagName(): string
    {
        return self::TAG_NAME;
    }
}