<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/6/18
 * Time: 17:33
 */

namespace app\admin\controller;


use function admin\error;
use function admin\success;
use app\admin\action\LoginAction;
use app\admin\middleware\PathAuth;

class Login extends Base
{
    protected $middleware = [
        PathAuth::class ,
    ];

    public function loginView()
    {
        return $this->fetch('login');
    }

    public function login()
    {
        $param = $this->request->post();
        $param['username'] = $param['username'] ?? '';
        $param['password'] = $param['password'] ?? '';
        $res = LoginAction::login($param);
        if ($res['code'] != 200) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }
}