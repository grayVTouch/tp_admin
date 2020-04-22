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
use app\admin\action\GameProfitAction;

class GameProfit extends Auth
{
    public function listView()
    {
        return $this->fetch('list');
    }

    public function list()
    {
        $param = $this->request->post();
        $param['id'] = $param['id'] ?? '';
        $param['uid'] = $param['uid'] ?? '';
        $param['phone'] = $param['phone'] ?? '';
        $param['username'] = $param['username'] ?? '';
        $param['order'] = $param['order'] ?? '';
        $param['limit'] = $param['limit'] ?? '';
        $res = GameProfitAction::list($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }
}