<?php
namespace Differ\Renderers;

use Illuminate\Support\Collection;

class RenderPlain implements RenderInterface
{
    private function renderKeyPart($key, $path)
    {
        $pathPrefix = implode('.', $path);
        $pathString = empty($pathPrefix) ? $key : "$pathPrefix.$key";

        return "Property '$pathString' was";
    }

    private function renderValue($value)
    {
        if (is_array($value)) {
            return "'complex value'";
        }

        $newValue = $value === true ? 'true' : $value;
        return "'$newValue'";
    }

    public function render($ast, $path = array())
    {

        $levelDiff = array_map(function ($item) use ($path) {

            if ($item['type'] == 'actual') {
                return '';
            }

            if ($item['type'] == 'added') {
                $keyPart = $this->renderKeyPart($item['key'], $path);
                $value = $this->renderValue($item['newValue']);
                return "$keyPart added with value: $value";
            }

            if ($item['type'] == 'removed') {
                $keyPart = $this->renderKeyPart($item['key'], $path);
                return "$keyPart removed";
            }

            if ($item['type'] == 'nested') {
                return $this->render(
                    $item['newValue'],
                    array_merge($path, array($item['key']))
                );
            }

            $keyPart = $this->renderKeyPart($item['key'], $path);
            $oldValue = $this->renderValue($item['oldValue']);
            $newValue = $this->renderValue($item['newValue']);
            return "$keyPart changed. From $oldValue to $newValue";
        }, $ast);

        $collection = new Collection($levelDiff);
        $flattened = $collection->flatten();
        $filtered = $flattened->reject(function ($item) {
            return empty($item);
        });

        return implode(PHP_EOL, $filtered->toArray());
    }
}
