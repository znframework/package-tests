<?php namespace ZN\Authentication;

use DB;
use User;

class LoginTest extends AuthenticationExtends
{ 
    public function testStandartLogin()
    {
        DB::where('username', 'znframeworktest@yandex.com')->delete('users');

        User::register
        ([
            'username' => 'znframeworktest@yandex.com',
            'password' => '1234'
        ]);

        $this->assertTrue(User::login('znframeworktest@yandex.com', '1234'));
    }

    public function testIsLogin()
    {
        DB::where('username', 'znframeworktest@yandex.com')->delete('users');
        
        User::register
        ([
            'username' => 'znframeworktest@yandex.com',
            'password' => '1234'
        ]);

        User::login('znframeworktest@yandex.com', '1234');

        $this->assertTrue(User::isLogin());
    }

    public function testData()
    {
        User::register
        ([
            'username' => 'znframeworktest@yandex.com',
            'password' => '1234'
        ]);

        User::login('znframeworktest@yandex.com', '1234');

        $this->assertEquals('znframeworktest@yandex.com', User::data()->username);

        DB::where('username', 'znframeworktest@yandex.com')->delete('users');
    }

    public function testUsername()
    {
        User::username('example@example.com');

        $this->assertEquals('example@example.com', Properties::$parameters['username']);
    }

    public function testPassword()
    {
        User::password('1234');

        $this->assertEquals('1234', Properties::$parameters['password']);
    }

    public function testRemember()
    {
        (new Login)->remember(true);

        $this->assertEquals(true, Properties::$parameters['remember']);
    }

    public function testDoFalse()
    {
        $this->assertFalse((new Login)->do('example@example.com', '1234', []));
    }

    public function testDoLoginError()
    {
       (new Login)->do('example22@example.com', '1234', []);

        $this->assertEquals('Login failed. The user name or password is incorrect!', User::error());
    }

    public function testUserExists()
    {
        $this->assertEquals(0, $this->loginMock->mockUserExists());
    }

    public function testStartPermanentUserSessionWithCookie()
    {
        try
        {
            $this->loginMock->mockStartPermanentUserSessionWithCookie('znframeworktest@yandex.com', '1234');
        }
        catch( \Exception $e )
        {
            $this->assertIsString($e->getMessage());
        }
    }
}