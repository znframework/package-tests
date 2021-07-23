<?php namespace ZN\Database;

use DB;
use DBForge;

class UpdateTest extends DatabaseExtends
{
    public function testUpdate()
    {
        DB::where('name', 'Susan')->update('persons', 
        [
            'surname' => 'Orlando',
            'phone'   => 10
        ]);

        $person = DB::where('name', 'Susan')->persons()->row();

        $this->assertSame('Orlando', $person->surname);
    }

    public function testIncrement()
    {
        $first = DB::where('name', 'Susan')->persons()->row();

        DB::where('name', 'Susan')->increment('persons', 'phone', 10);

        $last = DB::where('name', 'Susan')->persons()->row();

        $this->assertSame((float) $last->phone, (float) $first->phone + 10);
    }

    public function testDecrement()
    {
        $first = DB::where('name', 'Susan')->persons()->row();

        DB::where('name', 'Susan')->decrement('persons', 'phone', 10);

        $last = DB::where('name', 'Susan')->persons()->row();

        $this->assertSame((float) $last->phone, (float) $first->phone - 10);
    }

    public function testIncrementColumns()
    {
        $first = DB::where('name', 'Susan')->persons()->row();

        DB::where('name', 'Susan')->increment('persons', ['phone'], 10);

        $last = DB::where('name', 'Susan')->persons()->row();

        $this->assertSame((float) $last->phone, (float) $first->phone + 10);
    }

    public function testDecrementColumns()
    {
        $first = DB::where('name', 'Susan')->persons()->row();

        DB::where('name', 'Susan')->decrement('persons', ['phone'], 10);

        $last = DB::where('name', 'Susan')->persons()->row();

        $this->assertSame((float) $last->phone, (float) $first->phone - 10);
    }

    public function testObject()
    {
        $this->tableContainer(function($db)
        {
            $db->insert('example', ['name' => 'object']);

            $row = $db->object()->where('id', 1)->update('example', ['name' => 'objectupdate']);
            
            $this->assertIsObject($row);
        });
    }
}