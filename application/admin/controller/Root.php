<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/7/17
 * Time: 18:03
 */

namespace app\admin\controller;


use app\admin\model\AdministratorModel;

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
}