<?php
namespace Differ;

use Illuminate\Support\Collection;

function getUniqueKeys($arr1, $arr2)
{
    $keys1 = new Collection(array_keys($arr1));
    return $keys1->merge(array_keys($arr2))->unique();
}

function growAST($tree1, $tree2)
{
    $keys = getUniqueKeys($tree1, $tree2);

    $diff = $keys->reduce(function ($acc, $key) use ($tree1, $tree2) {
        if (!array_key_exists($key, $tree1)) {
            $newItem = array(
                'type' => 'added',
                'key' => $key,
                'newValue' => $tree2[$key]
            );
            return array_merge($acc, array($newItem));
        }

        if (!array_key_exists($key, $tree2)) {
            $newItem = array(
                'type' => 'removed',
                'key' => $key,
                'oldValue' => $tree1[$key]
            );
            return array_merge($acc, array($newItem));
        }

        if ($tree1[$key] === $tree2[$key]) {
            $newItem = array(
                'type' => 'actual',
                'key' => $key,
                'oldValue' => $tree1[$key]
            );
            return array_merge($acc, array($newItem));
        }

        if (is_array($tree1[$key]) && is_array($tree2[$key])) {
            $newItem = array(
                'type' => 'nested',
                'key' => $key,
                'newValue' => growAST($tree1[$key], $tree2[$key])
            );
            return array_merge($acc, array($newItem));
        }

        $newItem = array(
            'type' => 'updated',
            'key' => $key,
            'newValue' => $tree2[$key],
            'oldValue' => $tree1[$key]
        );
        return array_merge($acc, array($newItem));
    }, []);

    return $diff;
}
