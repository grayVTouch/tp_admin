<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/6/19
 * Time: 11:11
 */

namespace im;

use think\facade\Session;

function user()
{
    return Session::get('user');
}

/**
 * 获取给定数组中给定键名对应单元
 *
 * @param array $arr
 * @param array $keys
 * @return array
 */
function array_unit(array $arr = [] , array $keys = [])
{
    $res = [];
    foreach ($keys as $v)
    {
        if (!isset($arr[$v])) {
            continue ;
        }
        $res[$v] = $arr[$v];
    }
    return $res;
}

/**
 * 错误响应
 *
 * @param string $data
 * @param int $code
 * @return \think\response\Json
 */
function error($data = '' , int $code = 400)
{
    return response($data , $code);
}

/**
 * 正确响应
 *
 * @param string $data
 * @param int $code
 * @return \think\response\Json
 */
function success($data = '' , int $code = 0)
{
    return response($data , $code);
}

/**
 * 响应
 *
 * @param string $data
 * @param int $code
 * @return \think\response\Json
 */
function response($data , $code = 0)
{
    return json()->data([
        'code' => $code ,
        'data' => $data
    ]);
}

function array_to_obj(array $arr){
    return json_decode(json_encode($arr));
}

function obj_to_array($obj){
    return json_decode(json_encode($obj) , true);
}

function convert_obj($value)
{
    return json_decode(json_encode($value));
}

function get_value($key , $value = '')
{
    $range = config($key);
    if (empty($range)) {
        return null;
    }
    foreach ($range as $k => $v)
    {
        if ($k == $value) {
            return $v;
        }
    }
    return null;
}

// 获取扩展名（URL || Local Path 都可）
function get_extension($path = ''){
    $path = format_path($path);
    $s_idx = mb_strrpos($path , '.');
    if ($s_idx !== false) {
        $s_idx += 1;
        return mb_substr($path , $s_idx);
    }
    return false;
}

/**
 * 格式化路径
 *
 * @param string $path
 * @return mixed|string
 */
function format_path($path = ''){
    if (empty($path)) {
        return $path;
    }
    $path = rtrim($path , '/');
    $path = str_replace('\\'  , '/' , $path);
    return $path;
}

/**
 * 图片 url
 *
 * @param string $path
 * @return string
 */
function image_url($path = '')
{
    return $path;
}

/**
 * 解析排序
 *
 * @param string $order
 * @return array
 */
function parse_order(string $order = '')
{
    if (empty($order)) {
        return [];
    }
    $order = explode('|' , $order);
    if (count($order) != 2) {
        return [];
    }
    return [
        'field' => $order[0] ,
        'value' => $order[1] ,
    ];
}