<?php
namespace Differ\Renderers;

use Illuminate\Support\Collection;

class RenderJson implements RenderInterface
{
    public function render($ast)
    {
        return json_encode($ast);
    }
}
