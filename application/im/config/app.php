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
    'version' => '1.0.5' ,
    // 路径
    'host' => $host ,
    'image_host' => 'http://adm.lifestation.cn:93/upload' ,
    'api_image_host' => 'http://api.lifestation.cn:93/upload' ,
    // logo
    'logo' => sprintf('%s%s' , $host , '/static/image/logo.jpg') ,
    // 操作系统
    'os' => [
        'name' => '通迅系统' ,
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
    // 视频地址
    'video_oss1' => 'http://outin-7060e9b1933511e994b900163e1c8dba.oss-cn-shanghai.aliyuncs.com' ,
    // 视频地址2（目前使用这个视频地址）
    'video_oss' => 'http://video-oss.gaowanvip.com' ,
    'image_oss' => 'http://gaowanvideo.oss-cn-hangzhou.aliyuncs.com' ,

    // 上传目录
    'upload_dir' => realpath(__DIR__ . '/../../../public/upload') ,
];