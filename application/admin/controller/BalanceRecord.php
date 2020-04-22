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
use app\admin\action\BalanceRecordAction;
use app\admin\model\BalanceRecordTypeModel;
use app\admin\model\CoinModel;

class BalanceRecord extends Auth
{
    public function listView()
    {
        $coin = CoinModel::getAll();
        $balance_record_type = BalanceRecordTypeModel::getAll();
        $this->assign([
            'coin' => $coin ,
            'balance_record_type' => $balance_record_type ,
        ]);
        return $this->fetch('list');
    }

    public function list()
    {
        $param = $this->request->post();
        $param['id'] = $param['id'] ?? '';
        $param['type'] = $param['type'] ?? '';
        $param['wallet_name'] = $param['wallet_name'] ?? '';
        $param['coin_id'] = $param['coin_id'] ?? '';
        $param['username'] = $param['username'] ?? '';
        $param['phone'] = $param['phone'] ?? '';
        $param['order'] = $param['order'] ?? '';
        $param['limit'] = $param['limit'] ?? '';
        $res = BalanceRecordAction::list($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }
}