<?php namespace ZN\Security;

use Security;

class TimeOnStayTest extends \PHPUnit\Framework\TestCase
{
    public function testCreateTimeOnStay()
    {
        $this->assertNull(Security::timeOnStay());
    }

    public function testValidTimeOnStayReturnFalse()
    {
        $_SESSION['timeOnStay'] = NULL;

        $this->assertFalse(Security::validTimeOnStay());
    }

    public function testInvalidTimeOnStay()
    {
        Security::timeOnStay();

        $this->assertFalse(Security::validTimeOnStay());
    }

    public function testValidTimeOnStay()
    {
        Security::timeOnStay();

        sleep(2);

        $this->assertTrue(Security::validTimeOnStay(2));
    }
}