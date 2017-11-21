<?php
namespace Differ\Parsers;

class ParserAdapterJSON implements ParserAdapterInterface
{
    public static function parse($file)
    {
        return json_decode($file, true);
    }
}
