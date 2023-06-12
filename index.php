<?php

require __DIR__.'./vendor/autoload.php';

use App\Parser\BlockHtmlTagParser;
use App\Parser\ButtonHtmlTagParser;
use App\Parser\ContainerHtmlTagParser;
use App\HtmlFormatter\HtmlFormatter;
use App\Parser\HtmlTagParserSelector;
use App\Parser\HtmlTagStyleParser;
use App\Parser\ImageHtmlTagParser;
use App\JsonHtmlTagParser;
use App\Parser\TextHtmlTagParser;

$data = file_get_contents('data.json');

$htmlTagStyleParser = new HtmlTagStyleParser();
$htmlFormatter = new HtmlFormatter();

$htmlTagParsers = [
    new BlockHtmlTagParser($htmlTagStyleParser, $htmlFormatter),
    new ButtonHtmlTagParser($htmlTagStyleParser, $htmlFormatter),
    new ContainerHtmlTagParser($htmlTagStyleParser, $htmlFormatter),
    new ImageHtmlTagParser($htmlTagStyleParser, $htmlFormatter),
    new TextHtmlTagParser($htmlTagStyleParser, $htmlFormatter)
];

$parserSelector = new HtmlTagParserSelector($htmlTagParsers);

$htmlTag = (new JsonHtmlTagParser($parserSelector))($data);

echo $htmlTag->getHtml(new HtmlFormatter());
