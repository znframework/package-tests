<?php namespace ZN\Validation;

class ErrorInputsTest extends \ZN\Test\GlobalExtends
{
    public function testErrorInputs()
    {
        \Post::name('abc123');

        $data = new Data;

        $data->alpha()->rules('name');

        $this->assertContains('name', $data->errorInputs()); 
    }

    public function testAddError()
    {
        $data = new Data;

        $data->addError('Error Message', 'errorMessage');

        $this->assertContains('errorMessage', $data->errorInputs()); 
    }
}