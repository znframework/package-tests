<?php namespace ZN\Database;

use DB;

class QueryTest extends DatabaseExtends
{
    public function testSelectPersonWithQuery()
    {
        $person = DB::query('select * from persons where name = "Ahri"');

        $this->assertEquals('select * from persons where name = "Ahri"', $person->stringQuery());
    }

    public function testQueryWithSecure()
    {
        $person = DB::secure(['x:' => 'Ahri'])->query('select * from persons where name = x:');

        $this->assertEquals("select * from persons where name = 'Ahri'", $person->stringQuery());
    }

    public function testQueryWithOrderSecure()
    {
        $person = DB::secure(['Ahri', null])->query('select * from persons where name = ? and last ?');

        $this->assertEquals("select * from persons where name = 'Ahri' and last null", $person->stringQuery());
    }

    public function testBasicQuery()
    {
        DB::basicQuery('select * from persons');

        $this->assertEquals("select * from persons", DB::stringQuery());
    }
}