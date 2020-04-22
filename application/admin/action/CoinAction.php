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
use app\admin\model\CoinModel;
use app\admin\model\RoleRouteModel;
use think\Db;
use think\Validate;

use Exception;

class CoinAction extends Action
{
    public static function list(array $param)
    {
        $param['limit'] = empty($param['limit']) ? config('app.limit') : $param['limit'];
        $order = parse_order($param['order']);
        $res = CoinModel::list($param , $order , $param['limit']);
        return self::success($res);
    }

    public static function add(array $param)
    {
        $validator=  Validate::make([
            'name' => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        $id = CoinModel::insertGetId(array_unit($param , [
            'name' ,
            'weight' ,
        ]));
        return self::success($id);
    }

    public static function edit(array $param)
    {
        $validator=  Validate::make([
            'id' => 'require' ,
            'name' => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        $m = CoinModel::findById($param['id']);
        if (empty($m)) {
            return self::error('未找到 id 对应项' , 404);
        }
        CoinModel::updateById($m->id , array_unit($param , [
            'name' ,
            'weight' ,
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
        CoinModel::delByIds($id_list);
        return self::success('操作成功');
    }

    public static function all(array $param)
    {
        $res = CoinModel::getAll($param);
        return self::success($res);
    }

    public static function privilege(array $param)
    {
        $validator=  Validate::make([
            'id' => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        $res = CoinModel::getRouteById($param['id']);
        if (empty($res)) {
            return self::error('未找到给定的角色相关信息' , 404);
        }
        return self::success($res);
    }

    public static function allocate(array $param)
    {
        $validator=  Validate::make([
            'role_id' => 'require' ,
            'id_list' => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        $id_list = json_decode($param['id_list'] , true);
        if (empty($id_list)) {
            return self::error('请提供角色权限');
        }
        try {
            Db::startTrans();
            RoleRouteModel::delByRoleId($param['role_id']);
            foreach ($id_list as $v)
            {
                RoleRouteModel::insert([
                    'role_id' => $param['role_id'] ,
                    'route_id' => $v
                ]);
            }
            Db::commit();
            return self::success('操作成功');
        } catch(Exception $e) {
            throw $e;
        }
    }

    public static function update(array $param)
    {
        $validator = Validate::make([
            'id' => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        try {
            Db::startTrans();
            // 价格修改限定
            // 2-Lucky 币价格
            // 5-USDT
            // 4-Lucky 币币账户
            $permit_update_coin_ids = [2];
            $relation_coin_ids = [2 , 4];
            if (!in_array($param['id'] , $permit_update_coin_ids)) {
                if (!empty($param['price'])) {
                    Db::rollback();
                    return self::error('仅允许更改 Lucky 币对USDT价格，其他币种不允许修改' , 403);
                }
            } else {
                // 允许需改的币种
                if (!empty($param['price'])) {
                    $usdt = CoinModel::findById(5);
                    $rmb = bcmul($param['price'] , $usdt->rmb , 2);
                    CoinModel::updateByIds($relation_coin_ids , [
                        'price' => $param['price'] ,
                        'rmb' => $rmb
                    ]);
                }
            }
            if (!in_array($param['id'] , $permit_update_coin_ids)) {
                if (!empty($param['rmb'])) {
                    Db::rollback();
                    return self::error('仅允许更改 Lucky 币对RMB价格，其他币种不允许修改' , 403);
                }
            } else {
                if (!empty($param['rmb'])) {
                    $usdt = CoinModel::findById(5);
                    $usdt_price = bcdiv($param['rmb'] , $usdt->rmb , 4);
                    CoinModel::updateByIds($relation_coin_ids , [
                        'price' => $usdt_price ,
                        'rmb' => $param['rmb']
                    ]);
                }
            }

            CoinModel::updateById($param['id'] , array_unit($param , [
//                'price' ,
//                'rmb' ,
                'can_show' ,
                'can_transfer' ,
                'fee_min' ,
                'fee_max' ,
                'fee_fix' ,
                'can_transfer_out' ,
                'out_fee_min' ,
                'out_fee_max' ,
                'out_fix_fee' ,
                'can_trend' ,
                'auto_price' ,
                'is_virtual' ,
                'is_real' ,
                'is_reward' ,
                'reward_number' ,
                'red_pack' ,
                'can_use_in_third_game' ,
                'auto_out_limit' ,
            ]));
            Db::commit();
            return self::success('操作成功');
        } catch(Exception $e) {
            Db::rollback();
            throw $e;
        }
    }

    public static function gameCoin()
    {
        $game_coin = CoinModel::gameCoin();
        return self::success($game_coin);
    }
}