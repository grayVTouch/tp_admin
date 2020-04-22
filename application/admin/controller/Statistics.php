<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/7/18
 * Time: 11:20
 */

namespace app\admin\controller;


use function admin\error;
use function admin\success;
use app\admin\action\StatisticsAction;
use app\admin\action\WalletRecvAction;
use app\admin\model\BalanceRecordTypeModel;
use app\admin\model\CoinModel;
use think\Db;

class Statistics extends Auth
{
    public function indexView()
    {
        $in_sum_for_game = StatisticsAction::inSumForGame();
        $out_sum_for_game = StatisticsAction::outSumForGame();
        $user_count = StatisticsAction::userCount();
        $user_count_for_today = StatisticsAction::userCountForToday();
        $sum_for_transfer = StatisticsAction::sumForTransfer();
        $transfer = StatisticsAction::transfer();
        $transfer_out = StatisticsAction::transferOut();
        $transfer_record = StatisticsAction::transferRecord();
        $sum_for_admin = StatisticsAction::sumForAdmin();
        $transfer_in_sum = StatisticsAction::transferInForTotal();
        $transfer_out_sum = StatisticsAction::transferOutForTotal();
        $total_game_profit = StatisticsAction::totalGameProfit();
//        $total_game_investment = StatisticsAction::totalGameInvestment();
//        $total_game_tq_investment = StatisticsAction::totalGameTqInvestment();

        // 游戏转出到第三方游戏
        // 第三方游戏转入到币币账号
        $out_sum_for_third_game = StatisticsAction::outSumForThirdGame();
        $in_sum_for_third_game = StatisticsAction::inSumForThirdGame();
        $time = strtotime(date("Y-m-d"),time());
        //外网转游戏
        $game_into = Db::table('tk_wallet_recv')
                ->alias('b')
                ->where('b.coin_id','in','1,2')
                ->group('b.coin_id')
                ->join('tk_coin c','c.id = b.coin_id','LEFT')
                ->field('b.coin_id,c.cname,sum(amount) total')
                ->select();
        foreach ($game_into as $key => $val) {
            $game_into[$key]['today'] = Db::table('tk_wallet_recv')
                                    ->where('coin_id',$val['coin_id'])
                                    ->whereTime('date','>',date('Y-m-d'))
                                    ->sum('amount');
        }
        //外网转出游戏
        $game_out = Db::table('tk_transfer_out')
                ->alias('b')
                ->where('b.type',1)
                ->where('b.compelete',1)
                ->where('b.status','>',0)
                ->group('b.cid')
                ->join('tk_coin c','c.id = b.cid','LEFT')
                ->field('b.cid,c.cname,sum(amount) total')
                ->select();
        foreach ($game_out as $key => $val) {
            $game_out[$key]['today'] = Db::table('tk_transfer_out')
                                    ->where('cid',$val['cid'])
                                    ->where('type',1)
                                    ->where('compelete',1)
                                    ->where('status','>',0)
                                    ->where('date','>',$time)
                                    ->sum('amount');
        }
        //外网转币币账户
        $hz_into = Db::table('tk_wallet_recv')
                ->alias('b')
                ->where('b.coin_id','in','3,4')
                ->group('b.coin_id')
                ->join('tk_coin c','c.id = b.coin_id','LEFT')
                ->field('b.coin_id,c.cname,sum(amount) total')
                ->select();
        foreach ($hz_into as $key => $val) {
            $hz_into[$key]['today'] = Db::table('tk_wallet_recv')
                                    ->where('coin_id',$val['coin_id'])
                                    ->whereTime('date','>',date('Y-m-d'))
                                    ->sum('amount');
        }
        //币币账户转外网
        $hz_out = Db::table('tk_transfer_out')
                ->alias('b')
                ->where('b.type',0)
                ->where('b.compelete',1)
                ->where('b.status','>',0)
                ->group('b.cid')
                ->join('tk_coin c','c.id = b.cid','LEFT')
                ->field('b.cid,c.cname,sum(amount) total')
                ->select();
        foreach ($hz_out as $key => $val) {
            $hz_out[$key]['today'] = Db::table('tk_transfer_out')
                                    ->where('cid',$val['cid'])
                                    ->where('type',0)
                                    ->where('compelete',1)
                                    ->where('status','>',0)
                                    ->where('date','>',$time)
                                    ->sum('amount');
        }
        //总计转入
        $total_into = [];
        $eth_into = Db::table('tk_wallet_recv')
                ->alias('b')
                ->where('b.coin_id','in','1,3')
                ->join('tk_coin c','c.id = 1','LEFT')
                ->field('b.coin_id,c.cname,sum(amount) total')
                ->find();
        $eth_into['today'] = Db::table('tk_wallet_recv')
                                    ->where('coin_id','in','1,3')
                                    ->whereTime('date','>',date('Y-m-d'))
                                    ->sum('amount');
        $lucky_into = Db::table('tk_wallet_recv')
                ->alias('b')
                ->where('b.coin_id','in','2,4')
                ->join('tk_coin c','c.id = 2','LEFT')
                ->field('b.coin_id,c.cname,sum(amount) total')
                ->find();
         $lucky_into['today'] = Db::table('tk_wallet_recv')
                                    ->where('coin_id','in','2,4')
                                    ->whereTime('date','>',date('Y-m-d'))
                                    ->sum('amount');
        $total_into[] = $eth_into;
        $total_into[] = $lucky_into;

        //总计转出
        $total_out = Db::table('tk_transfer_out')
                ->alias('b')
                ->where('b.compelete',1)
                ->where('b.status','>',0)
                ->group('b.cid')
                ->join('tk_coin c','c.id = b.cid','LEFT')
                ->field('b.cid,c.cname,sum(amount) total')
                ->select();
        foreach ($total_out as $key => $val) {
            $total_out[$key]['today'] = Db::table('tk_transfer_out')
                                    ->where('cid',$val['cid'])
                                    ->where('compelete',1)
                                    ->where('status','>',0)
                                    ->where('date','>',$time)
                                    ->sum('amount');
        }


        $this->assign([
            'game_into'=>$game_into,
            'game_out'=>$game_out,
            'hz_into'=>$hz_into,
            'hz_out'=>$hz_out,
            'total_into'=>$total_into,
            'total_out'=>$total_out,
            // 游戏转入
            'in_sum_for_game' => $in_sum_for_game ,
            // 游戏转出
            'out_sum_for_game' => $out_sum_for_game ,
            // 用户注册总数
            'user_count' => $user_count ,
            // 今日用户注册数
            'user_count_for_today' => $user_count_for_today ,
            // 后台拨币转出
            'sum_for_admin' => $sum_for_admin ,

            // 游戏总收益
            'total_game_profit' => $total_game_profit ,
            // 游戏账号转出到第三方平台
            'out_sum_for_third_game' => $out_sum_for_third_game ,
            // 第三方平台转出到游戏账号
            'in_sum_for_third_game' => $in_sum_for_third_game ,
            // 游戏-总投资
//            'total_game_investment' => $total_game_profit ,
            // 游戏-总提取
//            'total_game_tq_investment' => $total_game_tq_investment ,
        ]);
        return $this->fetch('index');
    }
}