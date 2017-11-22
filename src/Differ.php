<?php
namespace Differ\Differ;

use Illuminate\Support\Collection;
use function Differ\growAST;

function genDiff($format, $pathToFile1, $pathToFile2)
{
    $inputFormat = pathinfo($pathToFile1, PATHINFO_EXTENSION);

    $parser = \Differ\Parser::getParser($inputFormat);

    $tree1 = $parser::parse(file_get_contents($pathToFile1));
    $tree2 = $parser::parse(file_get_contents($pathToFile2));

    $ast = growAST($tree1, $tree2);

    $renderer = \Differ\Renderer::getRenderer($format);

    $diff = $renderer::render($ast);

    return $diff;
}
