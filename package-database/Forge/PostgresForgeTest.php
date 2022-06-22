<?php namespace ZN\Database;

use DB, DBTool, DBForge;

class PostgresForgeTest extends DatabaseExtends
{
    public function testDatabase()
    {
        $this->assertIsBool(DBForge::new(self::postgres)->createDatabase('example'));
        $this->assertIsBool(DBForge::new(self::postgres)->dropDatabase('example'));
    }

    public function testTable()
    {
        $forge = DBForge::new(self::postgres);
        $db    = DB::new(self::postgres);

        $forge->dropTable('example');
        $forge->dropTable('example2');

        $this->assertIsBool($forge->extras(NULL)->createTable('example', 
        [
            'id'   => [$db->autoIncrement(), $db->primaryKey()],
            'name' => $db->varchar(255)
        ]));        
        $this->assertIsBool($forge->renameTable('example', 'example2'));
        $this->assertIsBool($forge->truncate('example2'));
        $this->assertIsBool($forge->dropTable('example2'));
    }

    public function testColumn()
    {
        $forge = DBForge::new(self::postgres);
        $db    = DB::new(self::postgres);

        $forge->dropTable('example');

        $forge->createTable('example', 
        [
            'id'   => [$db->autoIncrement(), $db->primaryKey()],
            'name' => $db->varchar(255)
        ]);

        $this->assertIsBool($forge->addColumn('example', 
        [
            'date' => $db->datetime()
        ]));
        
        $this->assertContains('date', $db->example()->columns());
   
        $this->assertIsBool($forge->renameColumn('example', ['date' => 'address']));

        $this->assertContains('address', $db->example()->columns());
        $this->assertIsBool($forge->modifyColumn('example', 
        [
            'address' => $db->varchar(255)
        ]));

        $this->assertContains('address', $db->example()->columns());

       
        $this->assertIsBool($forge->dropColumn('example', 'address'));
    }

    public function testKey()
    {
        $forge = DBForge::new(self::postgres);
        $db    = DB::new(self::postgres);

        $forge->dropTable('example');
        $forge->dropTable('example2');

        $forge->createTable('example', 
        [
            'id'          => $db->int(11),
            'name'        => $db->varchar(255),
            'example2_id' => $db->int(11)
        ]);

        $forge->createTable('example2', 
        [
            'id'   => $db->int(11),
            'name' => $db->varchar(255)
        ]);

        $this->assertIsBool($forge->addPrimaryKey('example', 'id', 'constraintId'));
        $this->assertIsBool($forge->dropPrimaryKey('example', 'constraintId'));

        $this->assertEquals
        (
            'ALTER TABLE example ADD  CONSTRAINT  exampleForeignKeys  FOREIGN KEY (example2_id) REFERENCES example2(id);',
            $forge->string()->addForeignKey('example', 'example2_id', 'example2', 'id', 'exampleForeignKeys')
        ); 
    
        $this->assertEquals
        (
            'ALTER TABLE example DROP  CONSTRAINT exampleForeignKeys;', 
            $forge->string()->dropForeignKey('example', 'exampleForeignKeys')
        );

        $this->assertIsBool($forge->createIndex('exampleIndex', 'example', 'name'));
        $this->assertIsBool($forge->dropIndex('exampleIndex'));  
        $this->assertIsBool($forge->createUniqueIndex('exampleIndex', 'example', 'name'));
        $forge->dropIndex('exampleIndex');
        $this->assertIsBool($forge->createSpatialIndex('geoIndex', 'example', 'geo'));
        $this->assertIsBool($forge->createFulltextIndex('exampleIndex', 'example', 'name'));
    }
}