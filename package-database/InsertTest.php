<?php namespace ZN\Database;

use DB;
use Get;
use Post;
use File;
use Json;
use Request;

class InsertTest extends DatabaseExtends
{
    public function testInsertData()
    {
        $status = DB::duplicateCheck('name')->insert('persons', 
        [
            'name' => 'Ozan'
        ]);

        $this->assertIsBool($status);
    }

    public function testMultiInsertData()
    {
        $status = DB::insert('persons', 
        [
            ['name' => 'Hamza'],
            ['name' => 'Salih']
        ]);

        $this->assertIsBool($status);

        DB::where('name', 'Hamza', 'or')->where('name', 'Salih')->delete('persons');
    }

    public function testInsertDuplicateCheck()
    {
        $status = DB::duplicateCheck('name')->insert('persons', 
        [
            'name'    => 'Ozan',
            'surname' => 'Uykun'
        ]);

        $this->assertIsBool($status);
    }

    public function testInsertDuplicateCheckUpdate()
    {
        DB::duplicateCheckUpdate('name')->insert('persons', 
        [
            'name'    => 'Ozan',
            'surname' => 'Uykun'
        ]);

        $person = DB::where('name', 'Ozan')->persons()->row();

        $this->assertSame('Uykun', $person->surname);
    }

    public function testInsertWithOptionalMethods()
    {
        DB::duplicateCheck('name')
          ->column('name', 'Haluk')
          ->insert('persons');

        $person = DB::where('name', 'Haluk')->persons()->row();

        $this->assertSame('Haluk', $person->name);
    }

    public function testInsertIgnoreMatch()
    {
        $data = 
        [
            'id'      => 5,
            'name'    => 'Susan',
            'address' => 'Paris' # unknown column
        ];

        # In this use, the id key in the incoming array is eliminated.
        DB::duplicateCheck('name')->insert('ignore:persons', $data);

        $person = DB::where('name', 'Susan')->persons()->row();

        $this->assertSame('Susan', $person->name);
    }

    public function testInsertPostMatch()
    {
        Post::name('Marlon');
        Post::surname('Brando');

        DB::duplicateCheck('name')->insert('post:persons');

        $person = DB::where('name', 'Marlon')->persons()->row();

        $this->assertSame('Marlon', $person->name);
    }

    public function testInsertGetMatch()
    {
        Get::name('Jessie');

        DB::duplicateCheck('name')->insert('get:persons');

        $person = DB::where('name', 'Jessie')->persons()->row();

        $this->assertSame('Jessie', $person->name);
    }

    public function testInsertRequestMatch()
    {
        Request::name('Hulk');
        Request::surname('Hogan');

        DB::duplicateCheck('name')->insert('request:persons');

        $person = DB::where('name', 'Hulk')->persons()->row();

        $this->assertSame('Hulk', $person->name);
    }

    public function testInsertArrayToJson()
    {
        DB::duplicateCheck('name')->insert('persons', 
        [
            'name'  => 'Jonnie',
            'phone' => ['4433', '3322'] # to Json
        ]);

        $person = DB::where('name', 'Jonnie')->persons()->row();

        $this->assertTrue(Json::check($person->phone));
    }

    public function testInsertTableName()
    {
        DB::duplicateCheck('name')->personsInsert
        ([
            'name'  => 'Elon'
        ]);

        $person = DB::where('name', 'Elon')->persons()->row();

        $this->assertSame('Elon', $person->name);
    }

    public function testGetInsertId()
    {
        DB::duplicateCheck('name')->personsInsert
        ([
            'name'  => 'James'
        ]);

        $this->assertIsInt(DB::insertId());
    }

    public function testGetAffectedRows()
    {
        DB::where('name', 'James')->update('persons',
        [
            'name'  => 'James2'
        ]);

        if( $affectedRows = DB::affectedRows() )
        {
            $this->assertSame(1, $affectedRows);
        }
    }

    public function testInsertCSVFile()
    {
        DB::insertCSV('persons', self::default . 'package-database/resources/test.csv');

        $person = DB::where('name', 'Darius')->persons()->row();

        $this->assertSame('Darius', $person->name);
    }

    public function testDelayed()
    {
        DB::delayed()->insert('table', ['id' => 1]);

        $this->assertEquals("INSERT  DELAYED  INTO table (id) VALUES ('1')", DB::stringQuery());
    }

    public function testIgnore()
    {
        DB::ignore()->insert('table', ['id' => 1]);

        $this->assertEquals("INSERT  IGNORE  INTO table (id) VALUES ('1')", DB::stringQuery());
    }

    public function testLowPriority()
    {
        DB::lowPriority()->insert('table', ['id' => 1]);

        $this->assertEquals("INSERT  LOW_PRIORITY  INTO table (id) VALUES ('1')", DB::stringQuery());
    }

    public function testExp()
    {
        DB::insert('table', ['exp:name' => 'date']);

        $this->assertEquals("INSERT  INTO table (name) VALUES (date)", DB::stringQuery());
    }
}