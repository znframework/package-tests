<?php namespace ZN\Authentication;

use DB;
use User;
use Config;
use DBForge;

class RegisterTest extends AuthenticationExtends
{
    public function testStandart()
    {
        DB::where('username', 'znframeworktest@yandex.com')->delete('users');

        User::register
        ([
            'username' => 'znframeworktest@yandex.com',
            'password' => '1234'
        ]);

        $row = DB::where('username', 'znframeworktest@yandex.com')->users()->row();

        $this->assertEquals('znframeworktest@yandex.com', $row->username);
    }

    public function testStandartWithAutoLogin()
    {
        DB::where('username', 'znframeworktest@yandex.com')->delete('users');

        User::register
        ([
            'username' => 'znframeworktest@yandex.com',
            'password' => '1234'

        ], true);

        $this->assertEquals('znframeworktest@yandex.com', User::data()->username);
    }

    public function testStandartWithAutoLoginRedirect()
    {
        Properties::$redirectExit = false;
        
        DB::where('username', 'znframeworktest@yandex.com')->delete('users');

        User::register
        ([
            'username' => 'znframeworktest@yandex.com',
            'password' => '1234'

        ], 'redirect/link');

        Properties::$redirectExit = true;
    }

    public function testStandartWithWithOptionalMethodAutoLogin()
    {
        DB::where('username', 'znframeworktest@yandex.com')->delete('users');

        User::autoLogin()->register
        ([
            'username' => 'znframeworktest@yandex.com',
            'password' => '1234'

        ]);

        $this->assertEquals('znframeworktest@yandex.com', User::data()->username);
    }

    public function testJoinColumn()
    {
        DB::where('username', 'robotx@znframework.com')->delete('users');

        DBForge::createTable('addresses',
        [
            'username' => [DB::varchar(255)],
            'address'  => [DB::varchar(255)]
        ]);

        Config::set('Auth', 
        [
            'joining' =>
            [
                'column' => 'username',
                'tables' => ['addresses' => 'username']
            ]
        ]);

        (new Register)->do
        ([
            'users' => 
            [
                'username' => 'robotx@znframework.com',
                'password' => '1234'
            ],
            'addresses' => 
            [
                'address' => 'London'
            ]
        ]);

        (new Login)->do('robotx@znframework.com', '1234');

        $data = (new Data)->get('addresses');

        $this->assertEquals('London', $data->address);

        DBForge::dropTable('addresses');

        Config::set('Auth', 
        [
            'joining' =>
            [
                'column' => '',
                'tables' => []
            ]
        ]);
    }

    public function testUnknownUserInformation()
    {
        DB::where('username', 'znframeworktest@yandex.com')->delete('users');
        
        User::register
        ([
            'username' => 'znframeworktest@yandex.com',
            'password' => '1234',
            'unknown'  => 'value'
        ]);

        $this->assertEquals('Unknown error!', User::error());
    }

    public function testUsernameError()
    {
        DB::where('username', 'znframeworktest@yandex.com')->delete('users');
        
        User::register
        ([
            'password' => '1234'
        ]);

        $this->assertEquals('The data should include the user name and password!', User::error());
    }

    public function testActivationColumnActivationReturnLinkNotFoundException()
    {
        DB::where('username', 'robot')->delete('accounts');

        DBForge::dropTable('accounts');

        DBForge::createTable('accounts',
        [
            'username'      => [DB::varchar(255)],
            'password'      => [DB::varchar(255)],
            'email'         => [DB::varchar(255)],
            'activation'    => [DB::varchar(255)]
        ]);

        Config::set('Auth', 
        [
            'matching'  =>
            [
                'table'   => 'accounts',
                'columns' =>
                [
                    'username'     => 'username',
                    'password'     => 'password', 
                    'email'        => 'email',              
                    'active'       => 'active',      
                    'banned'       => 'banned',       
                    'activation'   => 'activation',     
                    'verification' => '',   
                    'otherLogin'   => ['phone']         
                ]
            ]
        ]);
            
        try
        {
            User::register
            ([
                'username' => 'robot',
                'password' => '1234',
                'email'    => 'znframeworktest@yandex.com'
            ]);
        }
        catch( Exception\ActivationReturnLinkNotFoundException $e )
        {
            $this->assertEquals('The return link must be specified for the activation process!', $e->getMessage());
        }

        Config::set('Auth', 
        [
            'matching'  =>
            [
                'table'   => 'users',
                'columns' =>
                [
                    'username'     => 'username',
                    'password'     => 'password', 
                    'email'        => '',              
                    'active'       => 'active',      
                    'banned'       => 'banned',       
                    'activation'   => '',     
                    'verification' => '',   
                    'otherLogin'   => ['phone']         
                ]
            ]
        ]);
    }

    public function testActivationColumn()
    {
        DB::where('username', 'znframeworktest@yandex.com')->delete('accounts');

        DBForge::dropTable('accounts');

        DBForge::createTable('accounts',
        [
            'username'      => [DB::varchar(255)],
            'password'      => [DB::varchar(255)],
            'activation'    => [DB::varchar(255)]
        ]);

        Config::set('Auth', 
        [
            'matching'  =>
            [
                'table'   => 'accounts',
                'columns' =>
                [
                    'username'     => 'username',
                    'password'     => 'password', 
                    'email'        => '',              
                    'active'       => 'active',      
                    'banned'       => 'banned',       
                    'activation'   => 'activation',     
                    'verification' => '',   
                    'otherLogin'   => ['phone']         
                ]
            ]
        ]);
            
        try
        {
            User::register
            ([
                'username' => 'znframeworktest@yandex.com',
                'password' => '1234'
            ], false, 'return/link');
        }
        catch( \Exception $e )
        {
            $this->assertStringContainsString('is an invalid email address!', $e->getMessage());
        }

        Config::set('Auth', 
        [
            'matching'  =>
            [
                'table'   => 'users',
                'columns' =>
                [
                    'username'     => 'username',
                    'password'     => 'password', 
                    'email'        => '',              
                    'active'       => 'active',      
                    'banned'       => 'banned',       
                    'activation'   => '',     
                    'verification' => '',   
                    'otherLogin'   => ['phone']         
                ]
            ]
        ]);
    }
}