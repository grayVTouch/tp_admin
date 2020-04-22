<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/6/19
 * Time: 9:43
 */

$host = '';

return [
    // 静态资源缓存版本
    'version' => '1.0.42' ,
    // 路径
    'host' => $host ,
    'image_host' => '/upload' ,
    // logo
    'logo' => sprintf('%s%s' , $host , '/static/image/logo.jpg') ,
    // 操作系统
    'os' => [
        'name' => 'nems 商城' ,
    ] ,
    // 前端资源：静态资源路径（注意不要携带 /）
    'static_url' => sprintf('%s%s' , $host , '/static') ,
    // 前端资源：模块路径
    'module_url' => sprintf('%s%s' , $host , '/module/admin') ,
    // 前端路径
    'plugin_url' => sprintf('%s%s' , $host , '/plugin') ,
    // 前端视图公共静态资源文件
    'public_url' => sprintf('%s%s' , $host , '/module/admin/public') ,

    // 默认头像
    'avatar' => '' ,
    // 默认图片
    'image' => '' ,

    // 每页显示记录数
    'limit' => 20 ,
    // 上传目录
    'upload_dir' => realpath(__DIR__ . '/../../../public/upload') ,

    // 阿里云上传地址
    'oss_for_upload' => 'http://upload.moeddcoin.vip:81/upfull?token=lucky' ,

    // excel 保存目录
    'excel_dir' => realpath(__DIR__  . '/../../../public/static/admin') ,

    // oss 域名
    'oss' => 'http://combi.oss-ap-southeast-1.aliyuncs.com' ,

    // 钱包
    'wallet_name' => 'wallet' ,
];