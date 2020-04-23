<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2020/4/22
 * Time: 14:44
 */

namespace app\admin\controller;


use function admin\success;
use app\admin\action\ShopGoodsAction;
use app\admin\model\ShopCategoryOneModel;
use app\admin\model\ShopCategoryTwoModel;
use app\admin\model\ShopGoodsModel;
use function admin\error;

class ShopGoods extends Auth
{
    public function listView()
    {
        return $this->fetch('list');
    }

    public function addView()
    {
        $category_one = ShopCategoryOneModel::getAll();
        $category_two = ShopCategoryTwoModel::getAll();
        $this->assign([
            'mode' => 'add' ,
            'status' => config('business.shop_goods_status') ,
            'bool' => config('business.bool') ,
            'category_one' => $category_one ,
            'category_two' => $category_two ,
        ]);
        return $this->fetch('thing');
    }

    public function editView()
    {
        $param = $this->request->get();
        $param['id'] = $param['id'] ?? '';
        $m = ShopGoodsModel::findById($param['id']);
        if (empty($m)) {
            return error('未找到id对应记录' , 404);
        }
        $category_one = ShopCategoryOneModel::getAll();
        $category_two = ShopCategoryTwoModel::getAll();
        $this->assign([
            'mode' => 'edit' ,
            'status' => config('business.shop_goods_status') ,
            'bool' => config('business.bool') ,
            'category_one' => $category_one ,
            'category_two' => $category_two ,
            'thing' => $m
        ]);
        return $this->fetch('thing');
    }

    public function list()
    {
        $param = $this->request->post();
        $param['order'] = $param['order'] ?? '';
        $param['limit'] = $param['limit'] ?? '';
        $res = ShopGoodsAction::list($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

    public function add()
    {
        $param = $this->request->post();
        $param['cate_one_id'] = $param['cate_one_id'] ?? '';
        $param['cate_two_id'] = $param['cate_two_id'] ?? '';
        $param['freight'] = $param['freight'] ?? '';
        $param['into'] = $param['into'] ?? '';
        $param['is_hot'] = $param['is_hot'] ?? '';
        $param['status'] = $param['status'] ?? '';
        $param['shop_param'] = $param['shop_param'] ?? '';
        $param['shop_rule'] = $param['shop_rule'] ?? '';
        $param['shop_image'] = $param['shop_image'] ?? '';
        $param['my_introduction'] = $param['my_introduction'] ?? '';
        $res = ShopGoodsAction::add($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

    public function edit()
    {
        $param = $this->request->post();
        $param['id'] = $param['id'] ?? '';
        $param['cate_one_id'] = $param['cate_one_id'] ?? '';
        $param['cate_two_id'] = $param['cate_two_id'] ?? '';
        $param['freight'] = $param['freight'] ?? '';
        $param['into'] = $param['into'] ?? '';
        $param['is_hot'] = $param['is_hot'] ?? '';
        $param['status'] = $param['status'] ?? '';
        $param['shop_param'] = $param['shop_param'] ?? '';
        $param['shop_rule'] = $param['shop_rule'] ?? '';
        $param['shop_image'] = $param['shop_image'] ?? '';
        $param['my_introduction'] = $param['my_introduction'] ?? '';
        $res = ShopGoodsAction::edit($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

    public function del()
    {
        $param = $this->request->post();
        $param['id_list'] = $param['id_list'] ?? '';
        $res = ShopGoodsAction::del($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }
}