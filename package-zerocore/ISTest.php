<?php namespace ZN;

class ISTest extends ZerocoreExtends
{
    public function testCall()
    {
        $this->assertTrue(\IS::alpha('abc'));
        $this->assertFalse(\IS::post('abc'));
        $this->assertFalse(\IS::file('abc'));
        try
        {
            \IS::unknown('abc');
        }
        catch( Exception $e )
        {
            $this->assertEquals('Error: Call to undefined function `IS::unknown()`!', $e->getMessage());
        }
    }

    public function testSoftware()
    {
        $this->assertIsString(IS::software());
    }

    public function testDeclaredClass()
    {
        $this->assertTrue(IS::declaredClass('ZN\Database\DB'));
    }

    public function testSlug()
    {
        $this->assertTrue(IS::slug('a-b'));
        $this->assertFalse(IS::slug('a b'));
    }

    public function testClosure()
    {
        $this->assertFalse(IS::closure('is_callable'));
    }
}