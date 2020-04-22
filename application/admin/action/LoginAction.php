<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/6/19
 * Time: 10:57
 */

namespace app\admin\action;


use app\admin\lib\Hash;
use app\admin\model\AdministratorModel;
use function admin\array_unit;
use app\admin\model\ShopStoreModel;
use app\admin\model\UserModel;
use think\facade\Session;
use think\Validate;

class LoginAction extends Action
{
    public static function login(array $param)
    {
        $validator = Validate::make([
            'username'      => 'require' ,
            'password'      => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        $user = UserModel::findByUsername($param['username']);
        if (empty($user)) {
            return self::error('用户名错误');
        }
        if (!$user->is_root) {
//            if ($user->status == 2) {
//                return self::error('您的账户已经被锁定' , 403);
//            }
//            if ($user->status == 3) {
//                return self::error('您的账户已经被禁用' , 403);
//            }
        }

        // 检查用户名是否已经存在
//        if (!Hash::check($param['password'] , $user->password)) {
        if (md5($param['password']) != $user->password) {
            return self::error('密码错误');
        }
        // 检查是否使商家
        $shop = ShopStoreModel::findByUid($user->id);
        if (empty($shop)) {
            return self::error('你并非商家，禁止操作' , 404);
        }
        if ($shop->status != 1) {
            return self::error('你并非商家，禁止操作' , 403);
        }
        $param['last_ip'] = request()->ip();
        $param['last_time'] = date('Y-m-d H:i:s' , time());
        $param['login_count'] = $user->login_count + 1;
        Session::set('user' , $user);
        UserModel::updateById($user->id , array_unit($param , [
            'last_ip' ,
            'last_time' ,
            'login_count' ,
        ]));
        return self::success('登录成功');
    }
}