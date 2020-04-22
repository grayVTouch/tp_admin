<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/9/6
 * Time: 10:59
 */

namespace app\admin\util;


use app\admin\model\BalanceRecordModel;
use app\admin\model\UserBalanceModel;
use Exception;
use think\Db;

class BalanceUtil extends Util
{
    public static function update($uid, $coin_id, $order_id, $type, $balance, $remark) {
        $last_record = BalanceRecordModel::findByUidAndCoinId($uid, $coin_id);
        $user_balance = UserBalanceModel::findByUidAndCoinId($uid, $coin_id);
        if (abs($balance) > 100000000) {
            return self::error('数据超限' , 403);
        }
        if (!$last_record) {
            $last_record = new class {};
            $last_record->after_balance = 0;
        }
        $after_balance = Calc::add($user_balance->balance, $balance);
        //计算log表里面的余额是否足够
        if ($after_balance < 0) {
            return self::error('金额有误，导致最低金额小于 0 ！请重新输入' , 400);
        }
        //计算用户余额表中的余额是否足够
        if (Calc::add($user_balance->balance, $balance) < 0) {
            return self::error('金额输入有误！导致更改后金额小于 0！请重新输入' , 400);
        }
        try {
            Db::startTrans();
            BalanceRecordModel::insertGetId([
                'uid' => $uid,
                'cid' => $coin_id,
                'order_id' => $order_id,
                'type' => $type,
                'before_balance' => $last_record->after_balance ,
                'balance' => $balance,
                'after_balance' => $after_balance,
                'remark' => $remark,
            ]);
            UserBalanceModel::api_auto($uid, $coin_id, $balance);
            Db::commit();
            return self::success('支付成功');
        } catch(Exception $e) {
            Db::rollback();
//            return self::error('资金记录插入失败');
            throw $e;
        }
    }
}