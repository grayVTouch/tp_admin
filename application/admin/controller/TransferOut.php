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
use app\admin\action\TransferOutAction;
use app\admin\model\CoinModel;

class TransferOut extends Auth
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
        $res = TransferOutAction::list($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

    public function updateStatusSpecial()
    {
        $param = $this->request->post();
        $param['id_list'] = $param['id_list'] ?? '';
        $param['status'] = $param['status'] ?? '';
        $res = TransferOutAction::updateStatusSpecial($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

    public function updateCompleteStatus()
    {
        $param = $this->request->post();
        $param['id_list'] = $param['id_list'] ?? '';
        $param['complete'] = $param['complete'] ?? '';
        $res = TransferOutAction::updateCompleteStatus($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }
}