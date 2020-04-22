<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/7/18
 * Time: 11:53
 */

namespace app\admin\action;


use function admin\array_unit;
use function admin\get_value;
use function admin\obj_to_array;
use function admin\parse_order;
use function admin\user;
use app\admin\lib\Category;
use app\admin\model\OperationLogModel;
use app\admin\model\WalletToCoinModel;
use app\admin\model\RoleRouteModel;
use think\Db;
use think\Validate;

use Exception;

class WalletToCoinAction extends Action
{
    public static function list(array $param)
    {
        $param['limit'] = empty($param['limit']) ? config('app.limit') : $param['limit'];
        $order = parse_order($param['order']);
        $res = WalletToCoinModel::list($param , $order , $param['limit']);
        return self::success($res);
    }

    public static function add(array $param)
    {
        $validator=  Validate::make([
            'from_coin_id' => 'require' ,
            'to_coin_id' => 'require' ,
            'symbol' => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        $res = WalletToCoinModel::findByFromCoinIdAndToCoinIdAndSymbol($param['from_coin_id'] , $param['to_coin_id'] , $param['symbol']);
        if (!empty($res)) {
            return self::error('已经存在相同记录');
        }
        $id = WalletToCoinModel::insertGetId(array_unit($param , [
            'from_coin_id' ,
            'to_coin_id' ,
            'symbol' ,
        ]));
        return self::success($id);
    }

    public static function edit(array $param)
    {
        $validator=  Validate::make([
            'id' => 'require' ,
            'from_coin_id' => 'require' ,
            'to_coin_id' => 'require' ,
            'symbol' => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        $m = WalletToCoinModel::findById($param['id']);
        if (empty($m)) {
            return self::error('未找到 id 对应项' , 404);
        }
        $is_repeat = WalletToCoinModel::isRepeatForCoin($param['id'] , $param['from_coin_id'] , $param['to_coin_id'] , $param['symbol']);
        if ($is_repeat) {
            return self::error('已经存在重复记录');
        }
        WalletToCoinModel::updateById($m->id , array_unit($param , [
            'from_coin_id' ,
            'to_coin_id' ,
            'symbol' ,
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
        WalletToCoinModel::delByIds($id_list);
        return self::success('操作成功');
    }
}