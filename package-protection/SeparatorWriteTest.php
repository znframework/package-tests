<?php namespace ZN\Protection;

use Separator;

class SeparatorWriteTest extends ProtectionExtends
{
    public function testWrite()
    {
        Separator::write(self::dir . 'separator', ['foo' => 'Foo', 'bar' => 'Bar']);

        $this->assertFileExists(self::dir . 'separator');
    }
}