<?php namespace ZN\Hypertext;

use Form;

class TextTest extends \PHPUnit\Framework\TestCase
{
    public function testText()
    {
        $this->assertStringStartsWith
        (
            '<input type="text" name="textBox" value="Welcome!" id="example-text" maxlength="10">', 
            (string) Form::id('example-text')->maxlength(10)->text('textBox', 'Welcome!')
        );
    }

    public function testOnKeyWait()
    {
        $this->assertStringContainsString
        (
            'onkeywaititem', 
            (string) Form::onkeywait('exampleFunction()', 100)->text('textBox', 'Welcome!')
        );
    }
}