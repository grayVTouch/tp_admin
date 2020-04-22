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
use app\admin\action\UserBalanceAction;
use app\admin\model\CoinModel;

class UserBalance extends Auth
{
    public function listView()
    {
//        var_dump($query);
        $mode = $this->request->get('mode');
        $mode = $mode ?? '';
        $coin = CoinModel::getAll();
        $this->assign([
            'coin' => $coin ,
            'mode' => $mode
        ]);
        return $this->fetch('list');
    }

    public function list()
    {
        $param = $this->request->post();
        $param['id'] = $param['id'] ?? '';
        $param['uid'] = $param['uid'] ?? '';
        $param['coin_id'] = $param['coin_id'] ?? '';
        $param['wallet_name'] = $param['wallet_name'] ?? '';
        $param['order'] = $param['order'] ?? '';
        $param['limit'] = $param['limit'] ?? '';
        $res = UserBalanceAction::list($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

    // 拨币
    public function updateBalance()
    {
        $param = $this->request->post();
        $param['id'] = $param['id'] ?? '';
        $param['amount'] = $param['amount'] ?? '';
        $res = UserBalanceAction::updateBalance($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }
}