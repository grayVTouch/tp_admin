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
use app\admin\action\GameProfitRecordAction;
use app\admin\action\GameRecordAction;
use app\admin\model\CoinModel;

class GameRecord extends Auth
{
    public function listView()
    {
        $uid = $this->request->get('uid') ?? '';
        $this->assign([
            'status' => config('business.game_status') ,
            'uid' => $uid
        ]);
        return $this->fetch('list');
    }

    public function list()
    {
        $param = $this->request->post();
        $param['id'] = $param['id'] ?? '';
        $param['uid'] = $param['uid'] ?? '';
        $param['username'] = $param['username'] ?? '';
        $param['phone'] = $param['phone'] ?? '';
        $param['status'] = $param['status'] ?? '';
        $param['order'] = $param['order'] ?? '';
        $param['limit'] = $param['limit'] ?? '';
        $res = GameRecordAction::list($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }
}