<?php namespace ZN\Payment;

class NestpayResponseTest extends \PHPUnit\Framework\TestCase
{
    public function testIsValidHash()
    {
        $this->assertFalse(Gateway::response('Nestpay')->isValidHash());

        $_POST['HASHPARAMS'] = 'a:b:c';
        $_POST['a'] = true;

        $this->assertFalse(Gateway::response('Nestpay')->isValidHash());

        unset($_POST['HASHPARAMS']);
        unset($_POST['a']);
    }

    public function testIs3D()
    {
        $this->assertFalse(Gateway::response('Nestpay')->is3d());
    }

    public function testIsApproved()
    {
        $_POST["Response"] = 'Approved';

        $this->assertTrue(Gateway::response('Nestpay')->isApproved());

        unset($_POST['Response']);
    }

    public function testError()
    {
        $_POST["ErrMsg"] = 'Error!';

        $this->assertEquals('Error!', Gateway::response('Nestpay')->error());

        unset($_POST['ErrMsg']);

        $this->assertFalse(Gateway::response('Nestpay')->error());
    }
}