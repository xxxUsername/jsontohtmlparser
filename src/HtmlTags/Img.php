<?php

namespace App\HtmlTags;

use App\HtmlFormatter\HtmlFormatter;

class Img extends HtmlTag
{
    private const TAG_NAME = 'img';

    protected function getTagName(): string
    {
        return self::TAG_NAME;
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
        $html .= $this->getChildrenHtml($formatter);
        $html .= $format->closingTagIntent . '/>';

        return $html;
    }
}