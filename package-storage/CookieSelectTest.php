<?php namespace ZN\Storage;

use Cookie;

class CookieSelectTest extends StorageExtends
{
    public function testSelect()
    {
        $this->insert('example', 'Example');

        # Could not set the cookie!
        $this->assertEquals(false, Cookie::select('example'));
    }
}