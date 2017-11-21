<?php
namespace Differ\Parsers;

interface ParserAdapterInterface
{
    public static function parse($file);
}
