<?php
namespace Differ\Differ;

use function Differ\growAST;

function genDiff($format, $pathToFile1, $pathToFile2)
{

    $file1 = file_get_contents($pathToFile1);
    $file2 = file_get_contents($pathToFile2);

    if (!($file1 && $file2)) {
        $message = "Can't read  '$pathToFile1' or '$pathToFile2' file";
        echo $message;
        return $message;
    }

    $inputFormat = pathinfo($pathToFile1, PATHINFO_EXTENSION);

    $parser = (new \Differ\Parser)->getParser($inputFormat);

    $tree1 = $parser->parse($file1);
    $tree2 = $parser->parse($file2);

    $ast = growAST($tree1, $tree2);

    $renderer = (new \Differ\Renderer)->getRenderer($format);

    $diff = $renderer->render($ast);

    return $diff;
}
