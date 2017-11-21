<?php
namespace Differ\parsers;

class ParserAdapterJSON implements ParserAdapterInterface
{
    public static function parse($path)
    {
        return json_decode(file_get_contents($path), true);
    }
}
