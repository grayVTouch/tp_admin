<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/7/19
 * Time: 15:46
 */

namespace app\admin\action;


use function admin\format_path;
use function admin\image_url;

class ImageAction extends Action
{
    public static function layui_image($image)
    {
        $upload_dir = config('app.upload_dir');
        $info = $image->validate([
            // 单位: byte
            'size' => 50 * 1024 * 1024 ,
            // 后缀
//            'ext' => 'jpg,jpeg,png,gif' ,
        ])->move($upload_dir);
        if (empty($info)) {
            return self::error($info->getError() , 400);
        }
        $path = $info->getSaveName();
        $path = format_path($path);
        return self::success([
            'url' => image_url($path) ,
            'path' => $path
        ]);
    }

    public static function iview_image($image)
    {
        $upload_dir = config('app.upload_dir');
        $info = $image->validate([
            // 单位: byte
            'size' => 50 * 1024 * 1024 ,
            // 后缀
            'ext' => 'jpg,jpeg,png,gif' ,
        ])->move($upload_dir);
        if (empty($info)) {
            return self::error($info->getError() , 400);
        }
        $path = $info->getSaveName();
        $path = format_path($path);
        return self::success([
            'url' => image_url($path) ,
            'path' => $path
        ]);
    }
}