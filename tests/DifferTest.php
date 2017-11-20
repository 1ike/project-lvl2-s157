<?php
namespace Differ\Tests;

use \PHPUnit\Framework\TestCase;
use function \Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    public function testPrettyFlat()
    {
        $diff = genDiff(
            'pretty',
            'tests/fixtures/before-flat.json',
            'tests/fixtures/after-flat.json'
        );
        $expected = str_replace(
            array("\n\r", "\n"),
            PHP_EOL,
            PRETTY_FLAT
        );
        $this->assertEquals($expected, $diff);
    }
}
