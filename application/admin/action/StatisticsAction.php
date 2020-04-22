<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/9/6
 * Time: 14:52
 */

namespace app\admin\action;


use function admin\convert_obj;
use app\admin\model\BalanceRecordModel;
use app\admin\model\CoinModel;
use app\admin\model\GameProfitRecordModel;
use app\admin\model\GameRecordModel;
use app\admin\model\GameTqRecordModel;
use app\admin\model\TransferOutModel;
use app\admin\model\UserModel;
use app\admin\model\WalletRecvModel;

class StatisticsAction extends Action
{
    // 游戏转入
    public static function inSumForGame()
    {
        return GameRecordModel::sumAmount();
    }

    // 游戏转出
    public static function outSumForGame()
    {
        return GameTqRecordModel::sumAmount();
    }

    // 用户注册数量统计
    public static function userCount()
    {
        return UserModel::userCount();
    }

    // 今日：用户注册数量统计
    public static function userCountForToday()
    {
        $date = date('Y-m-d' , time());
        return UserModel::userCountForDate($date);
    }

    // 划转-转入
    public static function transfer()
    {
        return WalletRecvModel::sumByGroup();
    }

    // 划转-总划转（tk_balance_record code = 31）
    public static function sumForTransfer()
    {
        return BalanceRecordModel::sumByRecordType(31);
    }

    // 划转-实际划转(列出 code = 31 中)

    // 后台拨币统计
    public static function sumForAdmin()
    {
        return BalanceRecordModel::sumByRecordType(203);
    }

    // 划转-转出
    public static function transferOut()
    {
        return TransferOutModel::sumByGroup();
    }

    public static function transferRecord()
    {
        $coin_ids = [1 , 2];
        $coins = CoinModel::getByIds($coin_ids);
        $coins = convert_obj($coins);
        foreach ($coins as $v)
        {
            $v->sumForIn = WalletRecvModel::sumByCoinId($v->id);
            $v->sumForOut = TransferOutModel::sumByCoinId($v->id);
        }
        return $coins;
    }

    public static function transferOutForTotal()
    {
        return TransferOutModel::outSum();
    }

    public static function transferInForTotal()
    {
        return WalletRecvModel::inSum();
    }

    public static function totalGameProfit()
    {
        return GameProfitRecordModel::sumProfit();
    }

    public static function totalGameInvestment()
    {
        return GameRecordModel::sumInvestment();
    }

    public static function totalGameTqInvestment()
    {
        return GameTqRecordModel::sumTqInvestment();
    }

    public static function outSumForThirdGame()
    {
        return BalanceRecordModel::sumByRecordType(200);
    }

    public static function inSumForThirdGame()
    {
        return BalanceRecordModel::sumByRecordType(201);
    }
}