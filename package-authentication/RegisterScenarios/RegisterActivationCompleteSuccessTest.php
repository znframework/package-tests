<?php namespace ZN\Authentication;

use DB;
use User;
use Config;
use DBForge;

class RegisterActivationCompleteSuccessTest extends AuthenticationExtends
{
    public function testMake()
    {
        $this->activationConfig();

        DB::where('username', 'znframeworktest@yandex.com')->delete('accounts');

        DBForge::createTable('accounts',
        [
            'username'   => [DB::varchar(255)],
            'password'   => [DB::varchar(255)],
            'activation' => [DB::int(1)]
        ]);

        (new Register)->do
        ([
            'username' => 'znframeworktest@yandex.com',
            'password' => '1234'

        ], false, 'return/link');
        
        $row =  DB::where('username', 'znframeworktest@yandex.com')->accounts()->row();

        $this->assertEquals('For the completion of your registration, please click on the activation link sent to your e-mail address.', User::success());

        $_SERVER['REQUEST_URI'] = 'user/znframeworktest@yandex.com';

        (new Register)->activationComplete('user', function() use($row)
        {
            return $row->password;
        });

        $this->assertEquals('The activation process is completed with success.', User::success());
  
        DBForge::dropTable('accounts');

        $this->defaultConfig();
    }
}