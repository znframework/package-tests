<?php namespace ZN\Validation;

class EmailTest extends \ZN\Test\GlobalExtends
{
    public function testValid()
    {
        $this->assertTrue(Validator::email('znframeworktest@yandex.com'));
    }  

    public function testInvalid()
    {
        $this->assertFalse(Validator::email('robot@znframework'));
    }
}