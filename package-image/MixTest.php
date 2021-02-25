<?php namespace ZN\Image;

use GD;

class MixTest extends Test\GDExtends
{
    public function testMix()
    {
        GD::canvas(self::img)
          ->target(50, 50)
          ->source(300, 450)
          ->width(200)
          ->height(200)
          ->percent(50)
          ->mix(self::dir . 'image-convolution.png')
          ->generate('png', $generateFile = self::dir . 'image-mix.png');

        $this->assertFileExists($generateFile);
    }

    public function testMixGray()
    {
        GD::canvas(self::img)
          ->target(50, 50)
          ->source(300, 450)
          ->width(200)
          ->height(200)
          ->percent(50)
          ->mixGray(self::dir . 'image-convolution.png')
          ->generate('png', $generateFile = self::dir . 'image-mix.png');

        $this->assertFileExists($generateFile);
    }

    public function testMixInvalidArgumentException()
    {   
        try
        {
          GD::canvas(self::img)
          ->target(50, 50)
          ->source(300, 450)
          ->width(200)
          ->height(200)
          ->percent(50)
          ->mixGray(self::dir . 'image-convolution.png')
          ->generate('png', $generateFile = self::dir . 'image-mix.png2');
        }
        catch( Exception\InvalidArgumentException $e )
        {
            $this->assertStringContainsString($generateFile, $e->getMessage());
        }
    }
}