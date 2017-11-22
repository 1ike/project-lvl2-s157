<?php
namespace Differ;

class Renderer
{
    public function getRenderer($format)
    {
        $head = strtoupper(substr($format, 0, 1));
        $tail = strtolower(substr($format, 1));
        $classname = 'Differ\\Renderers\\Render' . $head . $tail;
        return new $classname;
    }
}
