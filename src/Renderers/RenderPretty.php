<?php
namespace Differ\Renderers;

class RenderPretty implements RenderInterface
{
    private static function renderValue($value, $level)
    {
        $newValue = json_encode($value, JSON_PRETTY_PRINT);
        if (!is_array($value)) {
            return $newValue;
        }
        $leveled = str_replace("\n", PHP_EOL . str_repeat('    ', $level), $newValue);
        return $leveled;
    }

    public static function render($ast, $level = 0)
    {
        $newLevel = $level + 1;
        $margin = str_repeat('    ', $level);

        $levelDiff = array_reduce($ast, function ($acc, $item) use ($newLevel, $margin) {

            if ($item['type'] == 'actual') {
                $oldValue = self::renderValue($item['oldValue'], $newLevel);
                $line = $margin . '    "' . $item['key'] . '": ' . $oldValue;
                return array_merge($acc, array($line));
            }
    
            if ($item['type'] == 'added') {
                $newValue = self::renderValue($item['newValue'], $newLevel);
                $linePlus = $margin . '  + "' . $item['key'] . '": ' . $newValue;
                return array_merge($acc, array($linePlus));
            }

            if ($item['type'] == 'removed') {
                $oldValue = self::renderValue($item['oldValue'], $newLevel);
                $lineMinus = $margin . '  - "' . $item['key'] . '": ' . $oldValue;
                return array_merge($acc, array($lineMinus));
            }

            if ($item['type'] == 'nested') {
                $newValue = self::render($item['newValue'], $newLevel);
                $line = $margin . '    "' . $item['key'] . '": ' . $newValue;
                return array_merge($acc, array($line));
            }

            $oldValue = self::renderValue($item['oldValue'], $newLevel);
            $lineMinus = $margin . '  - "' . $item['key'] . '": ' . $oldValue;
            $newValue = self::renderValue($item['newValue'], $newLevel);
            $linePlus = $margin . '  + "' . $item['key'] . '": ' . $newValue;
            return array_merge($acc, array($lineMinus), array($linePlus));
        }, []);
    
        return '{' . PHP_EOL . implode(PHP_EOL, $levelDiff) . PHP_EOL . $margin . '}';
    }
}
