<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/7/18
 * Time: 11:53
 */

namespace app\admin\action;


use function admin\array_unit;
use function admin\parse_order;
use app\admin\model\CommunitySlideshowModel;
use think\Db;
use think\Validate;

use Exception;

class CommunitySlideshowAction extends Action
{
    public static function list(array $param)
    {
        $param['limit'] = empty($param['limit']) ? config('app.limit') : $param['limit'];
        $order = parse_order($param['order']);
        $res = CommunitySlideshowModel::list($param , $order , $param['limit']);
        return self::success($res);
    }

    public static function add(array $param)
    {
        $validator=  Validate::make([
            'status' => 'require' ,
            'pic' => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        $id = CommunitySlideshowModel::insertGetId(array_unit($param , [
            'pic' ,
            'status' ,
        ]));
        return self::success($id);
    }

    public static function edit(array $param)
    {
        $validator=  Validate::make([
            'id' => 'require' ,
            'status' => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        $m = CommunitySlideshowModel::findById($param['id']);
        if (empty($m)) {
            return self::error('未找到 id 对应项' , 404);
        }
        $param['pic'] = empty($param['pic']) ? $m->pic : $param['pic'];
        CommunitySlideshowModel::updateById($m->id , array_unit($param , [
            'pic' ,
            'status' ,
        ]));
        return self::success($m->id);
    }

    public static function del(array $param)
    {
        $validator=  Validate::make([
            'id_list' => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        $id_list = json_decode($param['id_list'] , true);
        if (empty($id_list)) {
            return self::error('请提供待删除项');
        }
        CommunitySlideshowModel::delByIds($id_list);
        return self::success('操作成功');
    }
}