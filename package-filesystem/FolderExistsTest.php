<?php namespace ZN\Filesystem;

use Folder;

class FolderExistsTest extends FilesystemExtends
{
    public function testExists()
    {
        Folder::create(self::dir);

        $this->assertTrue(Folder::exists(self::dir));

        Folder::delete(self::dir);
    }

    public function testExistsFalse()
    {
        $this->assertFalse(Folder::exists(self::dir . 'unknown'));
    }
}