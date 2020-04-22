<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/6/19
 * Time: 16:26
 */

namespace app\im\action;


use think\facade\Session;

class AdminAction extends Action
{
    public static function logout()
    {
        Session::delete('user');
        return self::success();
    }
}