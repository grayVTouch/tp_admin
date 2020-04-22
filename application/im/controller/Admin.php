<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/6/19
 * Time: 16:25
 */

namespace app\im\controller;


use function im\error;
use function im\success;
use app\im\action\AdminAction;

class Admin extends Auth
{
    public function logout()
    {
        $res = AdminAction::logout();
        if ($res['code'] != 200) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }
}