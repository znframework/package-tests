<?php namespace ZN\Services;

use XML;
use Restful;

class GetTest extends \PHPUnit\Framework\TestCase
{
    private const JSON_URL = 'https://raw.githubusercontent.com/znframework/package-services/develop/composer.json';

    public function testGet()
    {
        $this->assertIsObject(Restful::get(self::JSON_URL));
    }

    public function testGetCallOptions()
    {
        $this->assertIsObject(Restful::returntransfer(1)->get(self::JSON_URL));
    }

    public function testGetWithUrl()
    {
        $this->assertIsObject(Restful::url(self::JSON_URL)->get());
    }

    public function testGetWithSSLVerifyPeer()
    {
        $this->assertIsObject(Restful::sslVerifypeer(false)->url(self::JSON_URL)->get());
    }

    public function testGetXMLResponse()
    {
        $this->assertIsObject(Restful::get('https://doc.storage.googleapis.com/'));
    }
}
