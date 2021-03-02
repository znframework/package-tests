<?php namespace ZN\Validation;

class QuestionTest extends \ZN\Test\GlobalExtends
{
    public function testAnswer()
    {
        $this->assertFalse(Validator::answer(''));

        $_SESSION[md5('answerToQuestion')] = 100;

        $this->assertTrue(Validator::answer('100'));
    }  

    public function testQuestion()
    {
        $this->assertIsString(Validator::question());
        $this->assertIsString(Validator::question(['one' => 1, 'two' => 2]));
    }
}