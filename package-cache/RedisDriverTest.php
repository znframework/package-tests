<?php namespace ZN\Cache;

class RedisDriverTest extends CacheExtends
{
    public function testInsert()
    {
        try
        {
            $this->redis()->insert('example', 1);
    
            $this->assertEquals(1, $this->redis()->select('example'));

            $this->redis()->insert('example', 2);

            $this->redis()->insert('example', ['a']);
        }
        catch( \Exception $e )
        {
           $this->assertIsString($e->getMessage());
        }      
    }

    public function testDelete()
    {
        try
        {
            $this->redis()->insert('example', 1);

            $this->redis()->delete('example');
    
            $this->assertEmpty($this->redis()->select('example'));

            $this->redis()->delete('unknown');
        }
        catch( \Exception $e )
        {
            $this->assertIsString($e->getMessage());
        }      
    }

    public function testDecrement()
    {
        try
        {
            $this->redis()->insert('a', 2);

            $this->redis()->decrement('a');
    
            $this->assertEquals(1, $this->redis()->select('a'));
        }
        catch( \Exception $e )
        {
            $this->assertIsString($e->getMessage());
        }   
    }

    public function testIncrement()
    {
        try
        {
            $this->redis()->insert('a', 1);

            $this->redis()->increment('a');
    
            $this->assertEquals(2, $this->redis()->select('a'));
        }
        catch( \Exception $e )
        {
            $this->assertIsString($e->getMessage());
        }   
    }

    public function testInfo()
    {
        try
        {
            $this->redis()->insert('a', 1);
    
            $this->redis()->info();
        }
        catch( \Exception $e )
        {
            $this->assertIsString($e->getMessage());
        } 
    }

    public function testClean()
    {
        try
        {
            $this->redis()->insert('a', 1);
    
            $this->redis()->clean();

            $this->assertEmpty($this->redis()->select('a'));
        }
        catch( \Exception $e )
        {
            $this->assertIsString($e->getMessage());
        } 
    }

    public function testConnectionException()
    {
        try
        {
            new Drivers\RedisDriver
            ([
                'port' => 1234
            ]);
        }
        catch( \Exception $e )
        {
            $this->assertIsString($e->getMessage());
        }
    }
}