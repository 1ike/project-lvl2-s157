<?php
namespace Differ\Tests;

use \PHPUnit\Framework\TestCase;
use function \Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    private $expected;

    public function setUp()
    {
        $this->expected = file_get_contents('tests/fixtures/expected-flat.txt');
    }

    public function testPrettyJsonFlat()
    {
        $diff = genDiff(
            'pretty',
            'tests/fixtures/before-flat.json',
            'tests/fixtures/after-flat.json'
        );
        $expected = str_replace(
            array("\n\r", "\n"),
            PHP_EOL,
            $this->expected
        );
        $this->assertEquals($expected, $diff);
    }

    public function testPrettyYamlFlat()
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
    }
}
