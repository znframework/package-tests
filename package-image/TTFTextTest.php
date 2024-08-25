<?php namespace ZN\Image;

use GD;

class TTFTextTest extends Test\GDExtends
{
    public function testTFFText()
    {
      GD::canvas(300, 300, 'white')
        ->color('black')->fontSize(20)->load(self::dir . 'test.ttf')->x(250)->y(100)->angle(90)->ttftext('Ozan Uykun!')
        ->generate('png', $generateFile = self::dir . 'tff-300-300.png');

        $size = GD::size($generateFile);

        $this->assertSame([300, 300], [$size->width, $size->height]);
    }

    public function testFontNotFound()
    {   
        try
        {
          GD::canvas(300, 300, 'white')
            ->color('black')->fontSize(20)->load(self::dir . 'invli.ttf')->x(250)->y(100)->angle(90)->ttftext('Ozan Uykun!')
            ->generate('png', $generateFile = self::dir . 'tff-300-300.png');
        }
        catch( Exception\FontNotFoundException $e )
        {
            $this->assertStringContainsString('invli.ttf', $e->getMessage());
        }
    }

    public function testNotTTFExtension()
    {   
        try
        {
          GD::canvas(300, 300, 'white')
            ->color('black')->fontSize(20)->load(self::dir . 'image.jpg')->x(250)->y(100)->angle(90)->ttftext('Ozan Uykun!')
            ->generate('png', $generateFile = self::dir . 'tff-300-300.png');
        }
        catch( Exception\TTFExtensionException $e )
        {
            $this->assertStringContainsString('image.jpg', $e->getMessage());
        }
    }
}