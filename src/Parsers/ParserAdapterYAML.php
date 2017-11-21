<?php
namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

class ParserAdapterYAML implements ParserAdapterInterface
{
    public static function parse($file)
    {
        return Yaml::parse($file);
        // return Yaml::parse($file, Yaml::PARSE_OBJECT_FOR_MAP);
    }
}
