<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/7/19
 * Time: 15:46
 */

namespace app\im\action;


use function im\array_unit;
use function im\format_path;
use function im\image_url;
use function im\parse_order;
use app\im\model\ImageModel;
use think\Validate;

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

    public static function list(array $param)
    {
        $param['limit'] = empty($param['limit']) ? config('app.limit') : $param['limit'];
        $order = parse_order($param['order']);
        $res = ImageModel::list($param , $order , $param['limit']);
        return self::success($res);
    }

    public static function edit(array $param)
    {
        $validator=  Validate::make([
            'id' => 'require' ,
            'pos' => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        $m = ImageModel::findById($param['id']);
        if (empty($m)) {
            return self::error('未找到 id 对应项' , 404);
        }
        $param['platform_id'] = 4;
        $param['path'] = empty($param['path']) ? $m->path : $param['path'];
        $param['url'] = $param['path'];
        ImageModel::updateById($m->id , array_unit($param , [
            'name' ,
            'path' ,
            'url' ,
            'pos' ,
            'size' ,
            'mime' ,
            'weight' ,
            'link' ,
            'platform_id' ,
        ]));
        return self::success('操作成功');
    }

    public static function add(array $param)
    {
        $validator=  Validate::make([
            'pos' => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        $param['platform_id'] = 4;
        $param['url'] = $param['path'];
        $param['weight'] = empty($param['weight']) ? config('app.weight') : $param['weight'];
        ImageModel::insertGetId(array_unit($param , [
            'name' ,
            'path' ,
            'url' ,
            'pos' ,
            'size' ,
            'mime' ,
            'weight' ,
            'link' ,
            'platform_id' ,
        ]));
        return self::success('操作成功');
    }

    // 删除
    public static function del(array $param)
    {
        $validator = Validate::make([
            'id_list' => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        $id_list = json_decode($param['id_list'] , true);
        if (empty($id_list)) {
            return self::error('请提供待删除的项');
        }
        ImageModel::delByIds($id_list);
        return self::success('操作成功');
    }


}