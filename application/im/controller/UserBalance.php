<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/7/29
 * Time: 15:31
 */

namespace app\im\controller;


use function im\error;
use function im\success;
use app\im\action\UserBalanceAction;

class UserBalance extends Auth
{
    public function allocateCF()
    {
        $param = $this->request->post();
        $param['user_id'] = $param['user_id'] ?? '';
//        $param['coin_id'] = $param['coin_id'] ?? '';
        $param['amount'] = $param['amount'] ?? '';
        $res = UserBalanceAction::allocateCF($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }
}