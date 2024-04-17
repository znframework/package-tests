<?php namespace ZN\DataTypes;

use Arrays;

class ArraysTest extends \PHPUnit\Framework\TestCase
{
    public function testValueExists()
    {
        $this->assertTrue(Arrays::valueExists(['a'], 'a'));
    }

    public function testValueExistsInsensitive()
    {
        $this->assertTrue(Arrays::valueExistsInsensitive(['a'], 'A'));
    }

    public function testKeyExists()
    {
        $this->assertTrue(Arrays::keyExists(['a' => 'A'], 'a'));
    }

    public function testKeyExistsInsensitive()
    {
        $this->assertTrue(Arrays::keyEsistsInsensitive(['a' => 'A'], 'A'));
    }

    public function testSearch()
    {
        $this->assertEquals(1, Arrays::search(['a', 'b'], 'b'));
    }

    public function testCountSameValues()
    {
        $this->assertEquals(3, Arrays::countSameValues(['a', 'b', 'b', 'b'], 'b'));
        $this->assertEquals(['a' => 1, 'b' => 3], Arrays::countSameValues(['a', 'b', 'b', 'b']));
    }

    public function testCombine()
    {
        $combine = Arrays::combine(['a', 'b']);

        $this->assertEquals(['a' => 'a', 'b' => 'b'], $combine);
    }

    public function testForceRecursive()
    {
        $array = Arrays::forceRecursive(['a', 'b'], function($value)
        {
            return $value . '1';
        });

        $this->assertEquals(['a1', 'b1'], $array);
    }

    public function testFillKeysRange()
    {
        $data = [1 => 'A', 5 => 'B'];

        $this->assertTrue([1 => 'A', 2 => 'X', 3 => 'X', 4 => 'X', 5 => 'B'], Arrays::fillKeysRange($data, 'X'));
    }

    public function testFillKeysRangeEmpty()
    {
        $this->assertTrue([], Arrays::fillKeysRange([]));
    }
}