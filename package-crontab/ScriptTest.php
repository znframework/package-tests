<?php namespace ZN\Crontab;

class ScriptTest extends \PHPUnit\Framework\TestCase
{
    public function testRunScript()
    {
        (new Job)->daily()->script(' example command');

        $this->assertStringContainsString('example command', (new Job)->list());

        (new Job)->remove('example command');
    }
}