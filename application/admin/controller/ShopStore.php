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
use function admin\user;
use app\admin\action\ShopAction;
use app\admin\action\UserAction;
use app\admin\model\ShopStoreModel;
use app\admin\model\UserInfoModel;
use app\admin\model\UserModel;

class ShopStore extends Auth
{
    public function shopView()
    {
        $shop = ShopStoreModel::findByUId(user()->id);
        $this->assign([
            'thing' => $shop ,
        ]);
        return $this->fetch('thing');
    }

    public function edit()
    {
        $param = $this->request->post();
        $param['id'] = $param['id'] ?? '';
        $param['pic'] = $param['pic'] ?? '';
        $param['name'] = $param['name'] ?? '';
        $param['introduction'] = $param['introduction'] ?? '';
        $param['case'] = $param['case'] ?? '';
        $param['kf_uid'] = $param['kf_uid'] ?? '';
        $res = ShopAction::edit($this , $param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }
}