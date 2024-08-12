<?php namespace ZN\Filesystem;

use Excel;
use Buffer;

class ExcelTest extends FilesystemExtends
{
    public function testArrayToXLS()
    {
        $content = Buffer::callback(function()
        {
            Excel::arrayToXLS
            ([
                ['1', '2', '3'],
                ['1', '2', '3']
            ], 'excel', true);
        });   

        $this->assertIsString($content);
    }

    public function testArrayToCSV()
    {
        $content = Buffer::callback(function()
        {
            Excel::arrayToCSV
            ([
                ['1', '2', '3'],
                ['1', '2', '3']
            ], 'excel', true);
        });   

        $this->assertIsString($content);
    }

    public function testCSVToArray()
    {
        $this->assertIsArray(Excel::CSVToArray(self::directory . 'test'));
    }

    public function testCSVToArrayWithDelimiter()
    {
        $this->assertIsArray(Excel::delimiter('|')->CSVToArray(self::directory . 'testDelimiter'));
    }
}