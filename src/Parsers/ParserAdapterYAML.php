<?php
namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

class ParserAdapterYAML implements ParserAdapterInterface
{
    private function castNumToString($tree)
    {
        $newTree = array_map(function ($value) {

            if (is_array($value)) {
                return $this->castNumToString($value);
            }

            if (is_numeric($value)) {
                return (string) $value;
            }

            return $value;
        }, $tree);

        return $newTree;
    }

    public function parse($file)
    {
        return $this->castNumToString(Yaml::parse($file));
    }
}
