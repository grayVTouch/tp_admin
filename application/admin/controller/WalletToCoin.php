<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/7/18
 * Time: 18:46
 */

namespace app\admin\controller;


use function admin\array_to_obj;
use function admin\error;
use function admin\success;
use function admin\user;
use app\admin\action\WalletToCoinAction;
use app\admin\model\CoinModel;
use app\admin\model\WalletToCoinModel;
use app\admin\model\RouteModel;
use app\admin\util\CategoryUtil;

class WalletToCoin extends Auth
{
    public function listView()
    {
        return $this->fetch('list');
    }

    public function addView()
    {
        $coin = CoinModel::getAll();
        $this->assign([
            'mode' => 'add' ,
            'coin' => $coin ,
        ]);
        return $this->fetch('thing');
    }

    public function editView()
    {
        $param = $this->request->get();
        $param['id'] = $param['id'] ?? '';
        $m = WalletToCoinModel::findById($param['id']);
        if (empty($m)) {
            return error('未找到id对应记录' , 404);
        }
        $coin = CoinModel::getAll();
        $this->assign([
            'mode' => 'edit' ,
            'thing' => $m ,
            'coin' => $coin
        ]);
        return $this->fetch('thing');
    }

    public function list()
    {
        $param = $this->request->post();
        $param['order'] = $param['order'] ?? '';
        $param['limit'] = $param['limit'] ?? '';
        $res = WalletToCoinAction::list($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

    public function add()
    {
        $param = $this->request->post();
        $param['from_coin_id'] = $param['from_coin_id'] ?? '';
        $param['to_coin_id'] = $param['to_coin_id'] ?? '';
        $param['symbol'] = $param['symbol'] ?? '';
        $res = WalletToCoinAction::add($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

    public function edit()
    {
        $param = $this->request->post();
        $param['id'] = $param['id'] ?? '';
        $param['from_coin_id'] = $param['from_coin_id'] ?? '';
        $param['to_coin_id'] = $param['to_coin_id'] ?? '';
        $param['symbol'] = $param['symbol'] ?? '';
        $res = WalletToCoinAction::edit($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

    public function del()
    {
        $param = $this->request->post();
        $param['id_list'] = $param['id_list'] ?? '';
        $res = WalletToCoinAction::del($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

    public function all()
    {
        $param = $this->request->post();
        $res = WalletToCoinAction::all($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

}