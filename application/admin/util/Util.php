<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/9/6
 * Time: 11:03
 */

namespace app\admin\util;


class Util
{
    public static function success($data = '' , $code = 0)
    {
        return self::response($data , $code);
    }

    public static function error($data = '' , $code = 400)
    {
        return self::response($data , $code);
    }

    public static function response($data = '' , $code = 0)
    {
        return [
            'code' => $code ,
            'data' => $data
        ];
    }
}