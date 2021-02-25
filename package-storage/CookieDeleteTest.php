<?php namespace ZN\Storage;

use Cookie;

class CookieDeleteTest extends StorageExtends
{
    public function testDelete()
    {
        $this->insert('example', 'Example');

        unset($_COOKIE[md5('example')]);

        $this->assertEmpty(Cookie::select('example'));
    }

    public function testDeleteReturnTrue()
    {
        $_COOKIE[md5('example')] = 'Example';

        Cookie::delete('example');
    }
}