<?php namespace ZN\Helpers;

use Cleaner;

class CleanerTest extends \PHPUnit\Framework\TestCase
{
    public function testData()
    {
        $this->assertSame('@yandex.com', Cleaner::data('znframeworktest@yandex.com', 'znframeworktest'));
        $this->assertSame('@yandex', Cleaner::data('znframeworktest@yandex.com', ['znframeworktest', '.com']));
        $this->assertSame([0 => 'a', 2 => 'c'], Cleaner::data(['a', 'b', 'c'], 'b'));
        $this->assertSame([0 => 'a'], Cleaner::data(['a', 'b', 'c'], ['b', 'c']));
    }

    public function testDataException()
    {
        try
        {
            Cleaner::data('znframeworktest@yandex.com', 'xxxxxznframeworktest@yandex.com');
        }
        catch( Exception\LogicException $e )
        {
            $this->assertIsString($e->getMessage());
        }
    }
}

