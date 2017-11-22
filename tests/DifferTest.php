<?php
namespace Differ\Tests;

use \PHPUnit\Framework\TestCase;
use function \Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    private $expected;

    public function setUp()
    {
        $this->expected = file_get_contents('tests/fixtures/expected.txt');
    }

    public function testPrettyJson()
    {
        $diff = genDiff(
            'pretty',
            'tests/fixtures/before.json',
            'tests/fixtures/after.json'
        );
        $expected = str_replace(
            array("\n\r", "\n"),
            PHP_EOL,
            $this->expected
        );
        $this->assertEquals($expected, $diff);
    }

/*     public function testPrettyYamlFlat()
    {
        $diff = genDiff(
            'pretty',
            'tests/fixtures/before-flat.yml',
            'tests/fixtures/after-flat.yml'
        );
        $expected = str_replace(
            array("\n\r", "\n"),
            PHP_EOL,
            $this->expected
        );
        $this->assertEquals($expected, $diff);
    } */
}
