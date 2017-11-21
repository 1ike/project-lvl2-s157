<?php
namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

class ParserAdapterYAML implements ParserAdapterInterface
{
    public static function parse($path)
    {
        return Yaml::parse(file_get_contents($path));
        // return Yaml::parse(file_get_contents($path), Yaml::PARSE_OBJECT_FOR_MAP);
    }
}
