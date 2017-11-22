<?php
namespace Differ;

class Parser
{
    public $parsers = array(
        'json' => 'ParserAdapterJSON',
        'yml' => 'ParserAdapterYAML',
        'yaml' => 'ParserAdapterYAML'
    );

    public function getParser($inputFormat)
    {
        $classname = 'Differ\\Parsers\\' . $this->parsers[$inputFormat];
        return new $classname;
    }
}
