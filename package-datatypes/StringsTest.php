<?php namespace ZN\DataTypes;

use Strings;

class StringsTest extends \PHPUnit\Framework\TestCase
{
    public function testToArray()
    {
        $this->assertEquals(['a', 'b', 'c'], Strings::toArray('a b c'));
    }

    public function testPad()
    {
        $this->assertEquals('a b c', Strings::pad('a b c', 1));
    }

    public function testUnserialize()
    {
        $this->assertEquals(['a' => '1', 'b' => '2'], Strings::unserialize('a=1&b=2'));
    }

    public function testSerialize()
    {
        $this->assertEquals('a=1&b=2', Strings::serialize(['a' => '1', 'b' => '2']));
    }
}