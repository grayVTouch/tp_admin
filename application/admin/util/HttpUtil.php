<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/8/28
 * Time: 9:54
 */

namespace app\admin\util;


use admin\lib\Http;

class HttpUtil
{
    public static function post(string $url = '' , array $data = [] , $timeout = 60)
    {
        $req = Http::post($url , [
            'data' => $data ,
            'timeout' => $timeout ,
        ]);
        if (empty($req)) {
            return self::response('发送请求失败' , 500);
        }
        if ($req['code'] == 0) {
            return self::response($req['data'] , 0);
        }
        return self::response('远程接口返回错误信息：' . json_encode($req) , 500);
    }

    public static function get(string $url = '' , array $data = [] , $timeout = 60)
    {
        $req = Http::get($url , [
            'data' => $data ,
            'timeout' => $timeout ,
        ]);
        if (empty($req)) {
            return self::response('发送请求失败' , 500);
        }
        if ($req['code'] == 0) {
            return self::response($req['data'] , 0);
        }
        return self::response('远程接口返回错误信息：' . json_encode($req) , 500);
    }

    private static function response($data , $code = 0)
    {
        return json_encode([
            'code' => $code ,
            'data' => $data
        ]);
    }
}