<?php namespace ZN\Pagination;

use Pagination;

class PagingTest extends \PHPUnit\Framework\TestCase
{
    public function testTotalRows()
    {
        $this->assertIsString
        (
            Pagination::paging('page')->create()
        );
    }
}