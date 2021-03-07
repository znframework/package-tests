<?php namespace ZN\Pagination;

use URL;
use Pagination;

class LinkNamesTest extends \PHPUnit\Framework\TestCase
{
    public function testLinkNames()
    {
        $this->assertStringContainsString
        (
            '<a href="' . URL::site('Home/main/20') . '" class="page-link">[ next ]</a>', 
            Pagination::limit(20)->totalRows(45)->linkNames('[ prev ]', '[ next ]', '[+ first +]', '[+ last +]')->create()
        );
    }
}