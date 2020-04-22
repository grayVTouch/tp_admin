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
use app\admin\action\UserAction;
use app\admin\model\UserInfoModel;
use app\admin\model\UserModel;

class Shop extends Auth
{
    public function shopView()
    {
        $shop_goods_auth = config('business.shop_goods_auth');
        $this->assign([
            'shop_goods_auth' => $shop_goods_auth
        ]);
        return $this->fetch('shop');
    }

    public function relationView()
    {
        return $this->fetch('relation');
    }

    public function editView()
    {
        $param = $this->request->get();
        $param['id'] = $param['id'] ?? '';
        $m = UserModel::findById($param['id']);
        if (empty($m)) {
            return error('未找到id对应记录' , 404);
        }
        if (empty($m->info)) {
            UserInfoModel::insertGetId([
                'uid' => $m->id
            ]);
            $m = UserModel::findById($m->id);
        }
        $this->assign([
            'mode' => 'edit' ,
            'is_verify' => config('business.user_is_verify') ,
            'thing' => $m
        ]);
        return $this->fetch('thing');
    }

    public function realNameVerifiedView()
    {
        $param = $this->request->get();
        $param['id'] = $param['id'] ?? '';
        $m = UserModel::findById($param['id']);
        if (empty($m)) {
            return error('未找到id对应记录' , 404);
        }
        if (empty($m->info)) {
            UserInfoModel::insertGetId([
                'uid' => $m->id
            ]);
            $m = UserModel::findById($m->id);
        }
        $this->assign([
            'is_verify' => config('business.user_is_verify') ,
            'thing' => $m
        ]);
        return $this->fetch('real_name_verified');
    }

    public function list()
    {
        $param = $this->request->post();
        $param['id'] = $param['id'] ?? '';
        $param['order'] = $param['order'] ?? '';
        $param['limit'] = $param['limit'] ?? '';
        $res = UserAction::list($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

    // 更新用户数据
    public function update()
    {
        $param = $this->request->post();
        $param['id'] = $param['id'] ?? '';
        $res = UserAction::update($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

    public function edit()
    {
        $param = $this->request->post();
        $param['username'] = $param['username'] ?? '';
        $param['password'] = $param['password'] ?? '';
        $param['pay_pass'] = $param['pay_pass'] ?? '';
        $param['phone'] = $param['phone'] ?? '';
        $res = UserAction::edit($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

    // 关系图
    public function relation()
    {
        $param = $this->request->post();
        $param['id'] = $param['id'] ?? '';
        $res = UserAction::relation($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

    // 电子表格
    public function exportExcel()
    {
        $res = UserAction::exportExcel();
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        $res = $res['data'];
        header("Content-type:application/vnd.ms-excel");
        header("Content-Disposition:filename={$res['filename']}.xlsx");
        echo $res['content'];
        exit;
    }
}