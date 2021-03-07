<?php namespace ZN\Validation;

class AddErrorTest extends \ZN\Test\GlobalExtends
{
    public function testMake()
    {
        $data = new Data;

        $data->addError('My error!');
    
        $this->assertEquals('My error!<br>', $data->error('string'));
    }  
}