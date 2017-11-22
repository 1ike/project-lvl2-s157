<?php
namespace Differ\Tests;

use \PHPUnit\Framework\TestCase;
use function \Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    private $expectedPretty;
    private $expectedPlain;

    public function setUp()
    {
        $this->expectedPretty = file_get_contents('tests/fixtures/expected.txt');
        $this->expectedPlain = file_get_contents('tests/fixtures/expected-plain.txt');
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
            $this->expectedPretty
        );
        $this->assertEquals($expected, $diff);
    }

    public function testPrettyYaml()
    {
        $diff = genDiff(
            'pretty',
            'tests/fixtures/before.yml',
            'tests/fixtures/after.yml'
        );
        $expected = str_replace(
            array("\n\r", "\n"),
            PHP_EOL,
            $this->expectedPretty
        );
        $this->assertEquals($expected, $diff);
    }

    public function testPlainYaml()
    {
        $diff = genDiff(
            'plain',
            'tests/fixtures/before.yml',
            'tests/fixtures/after.yml'
        );
        $expected = str_replace(
            array("\n\r", "\n"),
            PHP_EOL,
            $this->expectedPlain
        );
        $this->assertEquals($expected, $diff);
    }

}
