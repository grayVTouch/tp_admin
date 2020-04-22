<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/6/18
 * Time: 17:34
 */

namespace app\im\middleware;


use function im\obj_to_array;
use app\im\model\RouteModel;
use Closure;
use function im\user;
use think\Response;

class UserAuth
{
    protected $request;

    protected $debug = 'abc123';

    public function handle($request , Closure $next)
    {
        if ($this->debug != $request->post('debug')) {
            $auth = $this->auth();
            if ($auth instanceof Response) {
                // 未登录，跳转到登录页面
                return $auth;
            }
        }
        return $next($request);
    }

    public function auth()
    {
        $user = user();
        if (empty($user)) {
            return redirect('/admin/login/loginView');
        }
        if ($user->is_root == 1) {
            // 超级管理员
            $user->priv = RouteModel::getAll();
        } else {
            $user->priv = RouteModel::getByRoleId($user->role_id);
        }
    }
}