<?php namespace ZN\Authentication;

use DB;
use User;

class BannedTest extends AuthenticationExtends
{
    public function testBanned()
    {
        \Config::set('Auth', 
        [
            'matching'  =>
            [
                'table'   => 'users',
                'columns' =>
                [
                    'username'     => 'username',
                    'password'     => 'password', 
                    'email'        => '',              
                    'active'       => '',      
                    'banned'       => 'banned',       
                    'activation'   => '',     
                    'verification' => '',   
                    'otherLogin'   => []         
                ]
            ]
        ]);

        DB::where('username', 'znframeworktest@yandex.com')->delete('users');

        (new Register)->do
        ([
            'username' => 'znframeworktest@yandex.com',
            'password' => '1234'
        ], true);

        DB::where('username', 'znframeworktest@yandex.com')->update('users', ['banned' => 1]);

        Properties::$redirectExit = false;

        (new Login)->is();

        (new Login)->do('znframeworktest@yandex.com','1234');

        $this->assertEquals('You can not login because you have been banned from the system!', User::error());

        Properties::$redirectExit = true;
    }
}