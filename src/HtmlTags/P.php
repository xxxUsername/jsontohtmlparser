<?php

namespace App\HtmlTags;

class P extends HtmlTag
{
    private const TAG_NAME = 'p';

    protected function getTagName(): string
    {
        return self::TAG_NAME;
    }
}