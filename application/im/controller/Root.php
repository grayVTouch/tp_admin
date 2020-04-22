<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/7/17
 * Time: 18:03
 */

namespace app\im\controller;


use app\im\model\AdministratorModel;

class Root extends Base
{
    public function createUser()
    {
        $password = '123456';
        $password = password_hash($password , PASSWORD_DEFAULT);
        AdministratorModel::insertGetId([
            'username' => 'admin' ,
            'password' => $password
        ]);
    }

    public function test()
    {
        var_dump('hello boys and girls');
    }
}