<?php namespace ZN\Payment;

class NestpayRequestTest extends \PHPUnit\Framework\TestCase
{
    public function testCard()
    {
        $this->assertIsObject(Gateway::request('Nestpay')->card
        (
            '0000000000000000',
            '10',
            '40',
            '000'
        ));
    }

    public function testCardType()
    {
        $this->assertIsObject(Gateway::request('Nestpay')->cardType('visa'));

        try
        {
            Gateway::request('Nestpay')->cardType('invalid');
        }
        catch( Exception\InvalidCardTypeException $e )
        {
            $this->assertStringContainsString('[invalid]', $e->getMessage());
        }
    }

    public function testClientId()
    {
        $this->assertIsObject(Gateway::request('Nestpay')->clientId('myclient'));
    }

    public function testOrderId()
    {
        $this->assertIsObject(Gateway::request('Nestpay')->orderId('myorder'));
    }

    public function testAmount()
    {
        $this->assertIsObject(Gateway::request('Nestpay')->amount('10'));
    }

    public function testCurrency()
    {
        $this->assertIsObject(Gateway::request('Nestpay')->currency('USD'));

        $this->assertEquals(997, Currency::get('USN'));

        $this->assertEquals(997, Currency::get(997));

        try
        {
            Currency::get(99999);
        }
        catch( Exception\InvalidCurrencyInformationException $e )
        {
            $this->assertStringContainsString('[99999]', $e->getMessage());
        }
    }

    public function testRandomKey()
    {
        $this->assertIsObject(Gateway::request('Nestpay')->randomKey('x9645'));
    }

    public function testReturnUrl()
    {
        $this->assertIsObject(Gateway::request('Nestpay')->returnUrl('ok', 'fail'));
    }

    public function testCompanyName()
    {
        $this->assertIsObject(Gateway::request('Nestpay')->companyName('corperation'));
    }

    public function testInstallment()
    {
        $this->assertIsObject(Gateway::request('Nestpay')->installment('6'));
    }

    public function testProcessType()
    {
        $this->assertIsObject(Gateway::request('Nestpay')->processType('type'));
    }

    public function testStoreKey()
    {
        $this->assertIsObject(Gateway::request('Nestpay')->storeKey('store'));
    }

    public function testSend()
    {
        $this->assertIsString(Gateway::request('Nestpay')->send('test'));

        try
        {
            Gateway::request('Nestpay')->send('invalidbank');
        }
        catch( Exception\InvalidBankException $e )
        {
            $this->assertStringContainsString('[invalidbank]', $e->getMessage());
        }

        try
        {
            $gateway = Gateway::request('Nestpay');

            $gateway->okUrl(NULL)->send('test');
        }
        catch( Exception\MissingInformationExpception $e )
        {
            $this->assertStringContainsString('[okUrl]', $e->getMessage());
        }
    }
}