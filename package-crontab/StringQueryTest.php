<?php namespace ZN\Crontab;

class StringQueryTest extends \PHPUnit\Framework\TestCase
{    
    public function testRunStringQuery()
    {
        $job = new Job;

        $job->daily()->script('example command');

        $this->assertStringContainsString('example command', $job->stringQuery());

        $job->remove('example command');
    }
}