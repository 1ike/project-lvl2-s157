<?php
// namespace Differ\Tests;

use \PHPUnit\Framework\TestCase;
use \Differ\Differ;

class DifferTest extends TestCase
{
    public function testTest()
    {
        $name = 'john';
        $user ='john';
        $this->assertEquals($name, $user);
    }
}
