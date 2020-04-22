<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/6/19
 * Time: 11:11
 */

namespace admin;

use Exception;
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
//
//    if (empty($path)) {
//        return $path;
//    }
////    $res = config('app.image_oss');
//    $image_host = config('app.image_host');
//    $path = format_path($path);
//    $image_host = format_path($image_host);
//    $image_host = rtrim($image_host , '/');
//    $path = ltrim($path , '/');
//    return sprintf('%s/%s' , $image_host , $path);
}

function get_image_url($path = '')
{
    $oss = config('app.oss');
    $oss = rtrim($oss , '/');
    $path = ltrim($path , '/');
    return "{$oss}/{$path}";
}

function res_url($path = '')
{
    return $path;
//
//    if (empty($path)) {
//        return $path;
//    }
////    $res = config('app.image_oss');
//    $image_host = config('app.image_host');
//    $path = format_path($path);
//    $image_host = format_path($image_host);
//    $image_host = rtrim($image_host , '/');
//    $path = ltrim($path , '/');
//    return sprintf('%s/%s' , $image_host , $path);
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

/**
 * ***************
 * 工具函数
 * ***************
 */
// 字符串长度验证
function check_len($str , $len , $sign = 'eq'){
    $range = ['gt' , 'gte' , 'lt' , 'lte' , 'eq'];
    $sign = in_array($sign , $range) ? $sign : 'eq';
    $str_len = mb_strlen($str);

    switch ($sign)
    {
        case 'gt':
            return $str_len > $len;
        case 'gte':
            return $str_len >= $len;
        case 'lt':
            return $str_len < $len;
        case 'lte':
            return $str_len <= $len;
        case 'eq':
            return $str_len = $len;
        default:
            throw new Exception('不支持的比较符类型');
    }
}

// 检查手机号码
function check_phone($phone){
    return (bool) (preg_match('/^[1][3-8]\d{9}$/u' , $phone) || preg_match('/^\d+\-\d+$/' , $phone));
}

// 检查价格
function check_price($price){
    return (bool) preg_match('/^[1-9]?\d*(\.\d{0,2})?$/' , $price);
}

// 检查年份
function check_year($year){
    $reg = '/^\d{4}$/';

    return (bool) preg_match($reg , $year);
}

// 检查日期格式
function check_date($date){
    $reg = '/^\d{4}\-(0[1-9]|1[0-2])\-(0[1-9]|[1-2]\d|3[0-1])$/';

    return (bool) preg_match($reg , $date);
}

// 检查数字
function check_num($num , $len = 0){
    $reg = "/^\d+(\.\d{0,{$len}})?$/";
    return (bool) preg_match($reg , $num);
}

// 检查密码
function check_password($password){
    $reg = "/^.{6,}$/";
    return (bool) preg_match($reg , $password);
}

// 检查电子邮箱
function check_email($mail){
    $reg = "/^\.+@\.+$/";

    return (bool) preg_match($reg , $mail);
}

// 正则验证
function regexp_check(string $reg = '' , string $str = '')
{
    $reg = addslashes($reg);
    $reg = addcslashes($reg , '/[]()-');
    return (bool) preg_match("/{$reg}/" , $str);
}

function check_num_len($num , $len)
{
    return is_numeric($num) && mb_strlen($num) == $len;
}

function is_http($str = '')
{
    $reg = '/^https?:\/\//';
    return (bool) preg_match($reg , $str);
}

function has_cn($str = '')
{
    $reg = '/[\x{4e00}-\x{9fa5}]/u';
    return (bool) preg_match($reg , $str);
}

function has_en($str = '')
{
    $reg = '/[A-z]+/';
    return (bool) preg_match($reg , $str);
}

// 是否全部中文
function all_cn($str = '')
{
    return (bool) preg_match('/^[\x{4e00}-\x{9fa5}]+$/u', $str);
}

/***
 * **************************
 * 工具类函数库
 * **************************
 */
/*
 * 简单的随机数生成函数
 * 按要求返回随机数
 * @param  Integer    $len        随机码长度
 * @param  String     $type       随机码类型  letter | number | mixed
 * @return Array
 */
function random(int $len = 4 , string $type = 'mixed' , bool $is_return_str = true){
    $type_range = array('letter','number','mixed');

    if (!in_array($type , $type_range)){
        throw new Exception('参数 2 类型错误');
    }

    if (!is_int($len) || $len < 1) {
        $len = 1;
    }

    $result = [];
    $letter = array('a' , 'b' , 'c' , 'd' , 'e' , 'f' , 'g' , 'h' , 'i' , 'j' , 'k' , 'l' , 'm' , 'n' , 'o' , 'p' , 'q' , 'r' , 's' , 't' , 'u' , 'v' , 'w' , 'x' , 'y' , 'z');

    for ($i = 0; $i < count($letter) - $i; ++$i)
    {
        $letter[] = strtoupper($letter[$i]);
    }

    if ($type === 'letter'){
        for ($i = 0; $i < $len; ++$i)
        {
            $rand = mt_rand(0 , count($letter) - 1);

            shuffle($letter);

            $result[] = $letter[$rand];
        }
    }

    if ($type === 'number') {
        for ($i = 0; $i < $len; ++$i)
        {
            $result[] = mt_rand(0 , 9);
        }
    }

    if ($type === 'mixed'){
        for ($i = 0; $i < $len; ++$i)
        {
            $mixed = [];
            $rand  = mt_rand(0 , count($letter) - 1);

            shuffle($letter);

            $mixed[] = $letter[$rand];
            $mixed[] = mt_rand(0,9);

            $rand = mt_rand(0 , count($mixed) - 1);

            shuffle($mixed);

            $result[] = $mixed[$rand];
        }
    }

    return $is_return_str ? join('' , $result) : $result;
}