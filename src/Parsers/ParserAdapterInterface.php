<?php
namespace Differ\parsers;

interface ParserAdapterInterface
{
    public static function parse($path);
}
