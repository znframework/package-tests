<?php namespace ZN\DateTime;

use Time;

class TimeTest extends \PHPUnit\Framework\TestCase
{
    public function testCheckFalse()
    {
        $this->assertIsBool(Time::check('asdfasdfasdfasdfad'));
    }
    
    public function testGetZone()
    {
        Time::zone('America/Toronto');

        $this->assertSame('America/Toronto', date_default_timezone_get());
    }

    public function testGetZoneException()
    {
        try
        {
            Time::zone('America/Torontox');
        }
        catch( Exception\InvalidTimezoneException $e )
        {
            $this->assertIsString($e->getMessage());
        } 
    }

    public function testSetLocale()
    {
        $this->assertIsObject(Time::locale(LC_ALL));
    }

    public function testNextHour()
    {
        $this->assertSame('11', Time::nextHour('10:20'));
    }

    public function testPrevHour()
    {
        $this->assertSame('09', Time::prevHour('10:20'));
    }

    public function testAddHour()
    {
        $this->assertSame('12:20:00', Time::addHour('10:20', 2));
    }

    public function testRemoveHour()
    {
        $this->assertSame('08:20:00', Time::removeHour('10:20', 2));
    }

    public function testDiffHour()
    {
        $this->assertSame(2, (int) Time::diffHour('10:20', '12:20'));
    }

    public function testIsPast()
    {
        $this->assertIsBool(Time::isPast('10:20'));
    }

    public function testCurrent()
    {
        $this->assertIsString(Time::current());
    }

    public function testDefault()
    {
        $this->assertIsString(Time::default());
    }

    public function testStandart()
    {
        $this->assertIsString(Time::standart());
    }
}