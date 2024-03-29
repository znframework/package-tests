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
}