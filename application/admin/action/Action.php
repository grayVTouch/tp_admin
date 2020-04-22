<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/6/19
 * Time: 10:57
 */

namespace app\admin\action;


class Action
{
    public static function success($data = '' , $code = 0)
    {
        return compact('data' , 'code');
    }

    public static function error($data = '' , $code = 400)
    {
        return compact('data' , 'code');
    }
}