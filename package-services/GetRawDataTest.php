<?php namespace ZN\Services;

use Post;
use Restful;

class GetRawDataTest extends \PHPUnit\Framework\TestCase
{
    public function testGetRawData()
    {
        $this->assertEmpty(Restful::getRawData());
    }

    public function testGetRawDataArray()
    {
        $this->assertEmpty(Restful::getRawDataArray());
    }

    public function testGetRawDataObject()
    {
        $this->assertNull(Restful::getRawDataObject());
    }

    public function testGetRawDataFalse()
    {
        $this->assertFalse(Restful::getRawData('unknown'));
    }

    public function testGetRequestHeaders()
    {
        if( function_exists('apache_request_headers') )
        {
            $this->assertIsArray(Restful::getRequestHeaders());
        }
    }
}