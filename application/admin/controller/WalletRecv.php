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
use app\admin\action\WalletRecvAction;
use app\admin\model\BalanceRecordTypeModel;
use app\admin\model\CoinModel;

class WalletRecv extends Auth
{
    public function listView()
    {
        $coin = CoinModel::getAll();
        $this->assign([
            'coin' => $coin ,
        ]);
        return $this->fetch('list');
    }

    public function list()
    {
        $param = $this->request->post();
        $param['id'] = $param['id'] ?? '';
        $param['date'] = $param['date'] ?? '';
        $param['coin_id'] = $param['coin_id'] ?? '';
        $param['uid'] = $param['uid'] ?? '';
        $param['username'] = $param['username'] ?? '';
        $param['phone'] = $param['phone'] ?? '';
        $param['order'] = $param['order'] ?? '';
        $param['limit'] = $param['limit'] ?? '';
        $res = WalletRecvAction::list($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }
}