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
use app\admin\action\BbOrderAction;
use app\admin\model\BbOrderModel;
use app\admin\model\RouteModel;
use app\admin\util\CategoryUtil;

class BbOrder extends Auth
{
    public function listView()
    {
        $this->assign([
            'type' => config('business.bb_order_type') ,
            'status' => config('business.bb_order_status') ,
        ]);
        return $this->fetch('list');
    }

    public function addView()
    {
        $this->assign([
            'mode' => 'add' ,
            'bool' => config('business.bool')
        ]);
        return $this->fetch('thing');
    }

    public function editView()
    {
        $param = $this->request->get();
        $param['id'] = $param['id'] ?? '';
        $m = BbOrderModel::findById($param['id']);
        if (empty($m)) {
            return error('未找到id对应记录' , 404);
        }
        $this->assign([
            'mode' => 'edit' ,
            'bool' => config('business.bool') ,
            'thing' => $m
        ]);
        return $this->fetch('thing');
    }

    public function list()
    {
        $param = $this->request->post();
        $param['id'] = $param['id'] ?? '';
        $param['uid'] = $param['uid'] ?? '';
        $param['type'] = $param['type'] ?? '';
        $param['status'] = $param['status'] ?? '';
        $param['phone'] = $param['phone'] ?? '';
        $param['order'] = $param['order'] ?? '';
        $param['limit'] = $param['limit'] ?? '';
        $res = BbOrderAction::list($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

    public function add()
    {
        $param = $this->request->post();
        $param['param'] = $param['param'] ?? '';
        $param['val'] = $param['val'] ?? '';
        $param['discription'] = $param['discription'] ?? '';
        $param['is_show'] = $param['is_show'] ?? '';
        $res = BbOrderAction::add($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

    public function edit()
    {
        $param = $this->request->post();
        $param['id'] = $param['id'] ?? '';
        $param['param'] = $param['param'] ?? '';
        $param['val'] = $param['val'] ?? '';
        $param['discription'] = $param['discription'] ?? '';
        $param['is_show'] = $param['is_show'] ?? '';
        $res = BbOrderAction::edit($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

    public function del()
    {
        $param = $this->request->post();
        $param['id_list'] = $param['id_list'] ?? '';
        $res = BbOrderAction::del($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

    public function update()
    {
        $param = $this->request->post();
        $param['id'] = $param['id'] ?? '';
        $res = BbOrderAction::update($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

}