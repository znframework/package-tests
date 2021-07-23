<?php namespace ZN\Payment;

class PayPalResponseTest extends \PHPUnit\Framework\TestCase
{
    public function testIsValidHash()
    {
        $this->assertFalse(Gateway::response('PayPal')->isValidHash());

        $_POST['custom'] = 'a,';

        $this->assertFalse(Gateway::response('PayPal')->isValidHash());
    }

    public function testIsApproved()
    {
        $_POST["payment_status"] = 'Completed';

        $this->assertTrue(Gateway::response('PayPal')->isApproved());

        unset($_POST["payment_status"]);
    }

    public function testError()
    {
        $_POST["payment_status"] = 'Completed';

        $this->assertFalse(Gateway::response('PayPal')->error());

        $_POST["payment_status"] = 'Not Completed';

        $this->assertEquals('Not Completed', Gateway::response('PayPal')->error());

        unset($_POST["payment_status"]);
    }
}