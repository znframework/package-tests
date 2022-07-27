<?php namespace ZN\DataTypes\Strings;

use Strings;

class SubstitutionTest extends \PHPUnit\Framework\TestCase
{
    public function testRepeateComplete()
    {
        $this->assertSame('00a', Strings::repeatComplete('a', 3));
    }

    public function testRepeateCompleteRight()
    {
        $this->assertSame('a00', Strings::repeatComplete('a', 3), '0', 'right');
    }

    public function testRepeateCompleteDifferenceNotGreaterThanZero()
    {
        $this->assertSame('abcd', Strings::repeatComplete('abcd', 3));
    }
}