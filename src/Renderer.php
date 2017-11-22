<?php
namespace Differ;

class Renderer
{
    public static function getRenderer($format)
    {
        $head = strtoupper(substr($format, 0, 1));
        $tail = strtolower(substr($format, 1));
        $classname = 'Differ\\Renderers\\Render' . $head . $tail;
        return $classname;
    }
}
