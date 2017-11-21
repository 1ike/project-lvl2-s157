<?php
namespace Differ;

class Parser
{
    public static $parsers = array(
        'json' => 'ParserAdapterJSON',
        'yml' => 'ParserAdapterYAML',
        'yaml' => 'ParserAdapterYAML'
    );

    public static function getParser($inputFormat)
    {
        $classname = 'Differ\\Parsers\\' . self::$parsers[$inputFormat];
        return $classname;
    }
}
