<?php namespace ZN\Payment;

class PayPalRequestTest extends \PHPUnit\Framework\TestCase
{
    public function testCommand()
    {
        $this->assertIsObject(Gateway::request('PayPal')->command('donate'));

        try
        {
            Gateway::request('PayPal')->command('invalid');
        }
        catch( Exception\InvalidCommandException $e )
        {
            $this->assertStringContainsString('[invalid]', $e->getMessage());
        }
    }

    public function testCurrency()
    {
        $this->assertIsObject(Gateway::request('PayPal')->currency('USD'));
    }

    public function testReturnUrl()
    {
        $this->assertIsObject(Gateway::request('PayPal')->returnUrl('notify', 'success', 'cancel'));
    }

    public function testReturnItem()
    {
        $this->assertIsObject(Gateway::request('PayPal')->item('a', '1', '1', '1'));

        $this->assertIsObject(Gateway::request('PayPal')->item('a', 'a1', '1', '1')->item('b', 'b1', '1', '1'));
    }

    public function testOrderId()
    {
        $this->assertIsObject(Gateway::request('PayPal')->orderId('a'));
    }

    public function testName()
    {
        $this->assertIsObject(Gateway::request('PayPal')->name('first', 'last'));
    }

    public function testBuyer()
    {
        $this->assertIsObject(Gateway::request('PayPal')->buyer('buyer@example.com', 'buyerId'));
    }
    
    public function testSeller()
    {
        $this->assertIsObject(Gateway::request('PayPal')->seller('seller@example.com', 'sellerId'));
    }

    public function testClientId()
    {
        $this->assertIsObject(Gateway::request('PayPal')->clientId('client@example.com'));
    }

    public function testLocale()
    {
        $this->assertIsObject(Gateway::request('PayPal')->locale('UK'));
    }

    public function testSend()
    {
        $this->assertNull(Gateway::request('PayPal')->send('test'));

        try
        {
            Gateway::request('PayPal')->send('invalidtype');
        }
        catch( Exception\InvalidSendTypeException $e )
        {
            $this->assertStringContainsString('[invalidtype]', $e->getMessage());
        }
    }
}