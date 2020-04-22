<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/6/20
 * Time: 10:57
 */

return [
    // 用户状态
    'user_status' => [
        1 => '正常' ,
        2 => '锁定' ,
    ] ,
    // 布尔
    'bool' => [
        0 => '否' ,
        1 => '是' ,
    ] ,
    // 布尔
    'bool_str' => [
        'n' => '否' ,
        'y' => '是' ,
    ] ,
    // 性别
    'sex' => [
        0 => '未知' ,
        1 => '男' ,
        2 => '女' ,
        3 => '两性' ,
    ] ,
    // 图片位置
    'image_pos' => [
        'news' => '资讯-轮播图' ,
        'app' => '应用-轮播图' ,
    ] ,
    // 公告位置
    'announcement_pos' => [
        'app' => 'app-公告' ,
    ] ,

    // 朋友圈开放程度
    'open_level' => [
        // 公开
        'public' => '公开' ,
        // 仅自己可见
        'self' => '仅自己可见' ,
        // 指定用户可见
        'assign' => '指定用户可见' ,
    ] ,
];