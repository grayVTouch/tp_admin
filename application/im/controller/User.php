<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/7/18
 * Time: 11:20
 */

namespace app\im\controller;


use function im\error;
use function im\success;
use app\im\action\UserAction;

class User extends Auth
{
    public function listView()
    {
        $this->assign('sex' , config('business.sex'));
        $this->assign('user_type' , config('business.user_type'));
        return $this->fetch('list');
    }

    public function list()
    {
        $param = $this->request->post();
        $param['id'] = $param['id'] ?? '';
        $param['sex'] = $param['sex'] ?? '';
        $param['uid'] = $param['uid'] ?? '';
        $param['telephone'] = $param['telephone'] ?? '';
        $param['order'] = $param['order'] ?? '';
        $param['limit'] = $param['limit'] ?? '';
        $res = UserAction::list($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

    public function updateStatus()
    {
        $param = $this->request->post();
        $param['id_list'] = $param['id_list'] ?? '';
        $param['status'] = $param['status'] ?? '';
        $res = UserAction::updateStatus($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

    // 拨币 allocate_money
}