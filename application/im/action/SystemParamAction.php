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
use app\im\model\SystemParamModel;
use think\Validate;

use Exception;

class SystemParamAction extends Action
{
    public static function list(array $param)
    {
        $param['limit'] = empty($param['limit']) ? config('app.limit') : $param['limit'];
        $order = parse_order($param['order']);
        $res = SystemParamModel::list($param , $order , $param['limit']);
        return self::success($res);
    }

    public static function edit(array $param)
    {
        $validator=  Validate::make([
            'id' => 'require' ,
            'name' => 'require' ,
            'key' => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        $m = SystemParamModel::findById($param['id']);
        if (empty($m)) {
            return self::error('未找到 id 对应项' , 404);
        }
        SystemParamModel::updateById($m->id , array_unit($param , [
            'name' ,
            'key' ,
            'value' ,
            'desc' ,
        ]));
        return self::success('操作成功');
    }

    public static function add(array $param)
    {
        $validator=  Validate::make([
            'name' => 'require' ,
            'key' => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        SystemParamModel::insertGetId(array_unit($param , [
            'name' ,
            'key' ,
            'value' ,
            'desc' ,
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
        SystemParamModel::delByIds($id_list);
        return self::success('操作成功');
    }

}