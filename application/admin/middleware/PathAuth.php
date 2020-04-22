<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/6/18
 * Time: 17:34
 */

namespace app\admin\middleware;


use Closure;
use function admin\user;

class PathAuth
{
    protected $request;

    public function handle($request , Closure $next)
    {
        if (!empty(user())) {
            // 如果已经登录，跳转到后他首页
            return redirect('/admin/index/indexView');
        }
        return $next($request);
    }
}