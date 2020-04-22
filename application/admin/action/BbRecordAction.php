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
use app\admin\model\BbRecordModel;
use think\Validate;

use Exception;

class BbRecordAction extends Action
{
    public static function list(array $param)
    {
        $param['limit'] = empty($param['limit']) ? config('app.limit') : $param['limit'];
        $order = parse_order($param['order']);
        $res = BbRecordModel::list($param , $order , $param['limit']);
        return self::success($res);
    }

    public static function add(array $param)
    {
        $validator=  Validate::make([
            'param' => 'require' ,
            'val' => 'require' ,
            'is_show' => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        $id = BbRecordModel::insertGetId(array_unit($param , [
            'param' ,
            'val' ,
            'is_show' ,
            'discription' ,
        ]));
        return self::success($id);
    }

    public static function edit(array $param)
    {
        $validator=  Validate::make([
            'id' => 'require' ,
            'param' => 'require' ,
            'val' => 'require' ,
            'is_show' => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        $m = BbRecordModel::findById($param['id']);
        if (empty($m)) {
            return self::error('未找到 id 对应项' , 404);
        }
        BbRecordModel::updateById($m->id , array_unit($param , [
            'param' ,
            'val' ,
            'is_show' ,
            'discription' ,
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
        BbRecordModel::delByIds($id_list);
        return self::success('操作成功');
    }

    public static function update(array $param)
    {
        $validator = Validate::make([
            'id' => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        BbRecordModel::updateById($param['id'] , array_unit($param , [
            'buy_fee_rate' ,
            'sell_fee_rate' ,
        ]));
        return self::success('操作成功');
    }
}