<?php
namespace Differ\Differ;

function getUniqueKeys($arr1, $arr2)
{
    $keys1 = array_keys($arr1);
    $keys2 = array_keys($arr2);
    return array_unique(array_merge($keys1, $keys2));
}

function genDiff($format, $pathToFile1, $pathToFile2)
{
    $inputFormat = pathinfo($pathToFile1, PATHINFO_EXTENSION);

    $parser = \Differ\Parser::getParser($inputFormat);

    $tree1 = $parser::parse($pathToFile1);
    $tree2 = $parser::parse($pathToFile2);

    $keys = getUniqueKeys($tree1, $tree2);

    $diff = array_reduce($keys, function ($acc, $key) use ($tree1, $tree2) {
        $hasOldValue = array_key_exists($key, $tree1);
        if ($hasOldValue) {
            $oldValue = $tree1[$key] === true ? 'true' : $tree1[$key];
            $lineMinus = '  - '.$key.': '.$oldValue;
        }
        $hasNewValue = array_key_exists($key, $tree2);
        if ($hasNewValue) {
            $newValue = $tree2[$key] === true ? 'true' : $tree2[$key];
            $linePlus = '  + '.$key.': '.$newValue;
        }

        if (!$hasOldValue) {
            $linePlus = '  + '.$key.': '.$newValue;
            return array_merge($acc, array($linePlus));
        }

        if (!$hasNewValue) {
            $lineMinus = '  - '.$key.': '.$oldValue;
            return array_merge($acc, array($lineMinus));
        }

        if ($oldValue === $newValue) {
            $line = '    '.$key.': '.$oldValue;
            return array_merge($acc, array($line));
        }

        return array_merge($acc, array($linePlus), array($lineMinus));
    }, []);

    return '{'.PHP_EOL.implode(PHP_EOL, $diff).PHP_EOL.'}';
}
