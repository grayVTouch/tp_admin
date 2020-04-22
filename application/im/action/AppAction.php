<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/7/18
 * Time: 11:53
 */

namespace app\im\action;


use function im\array_unit;
use function im\parse_order;
use app\im\model\AppModel;
use think\Validate;

use Exception;

class AppAction extends Action
{
    public static function list(array $param)
    {
        $param['limit'] = empty($param['limit']) ? config('app.limit') : $param['limit'];
        $order = parse_order($param['order']);
        $res = AppModel::list($param , $order , $param['limit']);
        return self::success($res);
    }

    public static function edit(array $param)
    {
        $validator=  Validate::make([
            'id' => 'require' ,
            'name' => 'require' ,
            'is_app' => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        $m = AppModel::findById($param['id']);
        if (empty($m)) {
            return self::error('未找到 id 对应项' , 404);
        }
        $param['thumb'] = empty($param['thumb']) ? $m->thumb : $param['thumb'];
        AppModel::updateById($m->id , array_unit($param , [
            'name' ,
            'thumb' ,
            'ios_link' ,
            'android_link' ,
            'android_wakeup_link' ,
            'ios_wakeup_link' ,
            'is_app' ,
            'link' ,
            'weight' ,
        ]));
        return self::success('操作成功');
    }

    public static function add(array $param)
    {
        $validator=  Validate::make([
            'name' => 'require' ,
            'is_app' => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        $param['weight'] = empty($param['weight']) ? config('app.weight') : $param['weight'];
        AppModel::insertGetId(array_unit($param , [
            'name' ,
            'thumb' ,
            'ios_link' ,
            'android_link' ,
            'android_wakeup_link' ,
            'ios_wakeup_link' ,
            'is_app' ,
            'link' ,
            'weight' ,
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
        AppModel::delByIds($id_list);
        return self::success('操作成功');
    }

}