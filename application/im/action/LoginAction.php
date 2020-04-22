<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/6/19
 * Time: 10:57
 */

namespace app\im\action;


use app\im\model\AdministratorModel;
use function im\array_unit;
use think\facade\Session;
use think\Validate;

class LoginAction extends Action
{
    public static function login(array $param)
    {
        $validator = Validate::make([
            'username'         => 'require' ,
            'password'      => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        $user = AdministratorModel::findByUsername($param['username']);
        if (empty($user)) {
            return self::error('用户名错误');
        }
        // 检查用户名是否已经存在
        if (!password_verify($param['password'] , $user->password)) {
            return self::error('密码错误');
        }
        $param['last_ip'] = request()->ip();
        $param['last_time'] = date('Y-m-d H:i:s' , time());
        $param['number'] = $user->number + 1;
        Session::set('user' , $user);
        AdministratorModel::updateById($user->id , array_unit($param , [
            'last_ip' ,
            'last_time' ,
            'number' ,
        ]));
        return self::success('登录成功');
    }
}