<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2020/4/22
 * Time: 14:51
 */

namespace app\admin\action;


use function admin\array_unit;
use function admin\parse_order;
use function admin\user;
use app\admin\model\ShopComboModel;
use app\admin\model\ShopGoodsModel;
use app\admin\model\ShopIntroductionModel;
use app\admin\model\ShopParameterModel;
use app\admin\model\ShopPicturesModel;
use app\admin\model\ShopStoreModel;
use Exception;
use think\Db;
use think\facade\Validate;

class ShopGoodsAction extends Action
{
    public static function list(array $param)
    {
        $param['store_uid'] = user()->id;
        $param['limit'] = empty($param['limit']) ? config('app.limit') : $param['limit'];
//        $param['limit'] = 4;
        $order = parse_order($param['order']);
        $res = ShopGoodsModel::list($param , $order , $param['limit']);
        return self::success($res);
    }

    public static function add(array $param)
    {
        $validator=  Validate::make([
            'cate_one_id' => 'require' ,
            'cate_two_id' => 'require' ,
            'name'        => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        $shop_store = ShopStoreModel::findByUid(user()->id);
        $param['store_id'] = $shop_store->id;
        $param['store_uid'] = user()->id;
        $param['salas'] = 0;
//        print_r($param);
        $shop_param = empty($param['shop_param']) ? [] : json_decode($param['shop_param'] , true);
        $shop_rule = empty($param['shop_rule']) ? [] : json_decode($param['shop_rule'] , true);
        $shop_image = empty($param['shop_image']) ? [] : json_decode($param['shop_image'] , true);
        try {
            DB::startTrans();
            $goods_id = ShopGoodsModel::insertGetId(array_unit($param , [
                'name' ,
                'store_id' ,
                'store_uid' ,
                'salas' ,
                'cate_one_id' ,
                'cate_two_id' ,
                'status' ,
                'into' ,
                'freight' ,
                'is_hot' ,
                'is_recommend' ,
                'status' ,
                'pic' ,
            ]));
            foreach ($shop_param as $v)
            {
                ShopParameterModel::insertGetId([
                    'good_id' => $goods_id ,
                    'param_name' => $v['param_name'] ,
                    'param_value' => $v['param_value'] ,
                ]);
            }
            foreach ($shop_rule as $v)
            {
                ShopComboModel::insertGetId([
                    'good_id' => $goods_id ,
                    'pic' => $v['pic'] ,
                    'name' => $v['name'] ,
                    'price' => $v['price'] ,
                    'salas' => $v['salas'] ,
                    'original_price' => $v['original_price'] ,
                    'stock' => $v['stock'] ,
                ]);
            }
            foreach ($shop_image as $v)
            {
                ShopPicturesModel::insertGetId([
                    'good_id' => $goods_id ,
                    'pic' => $v['pic'] ,
                    'date' => date('Y-m-d H:i:s') ,
                ]);
            }
            ShopIntroductionModel::insertGetId([
                'good_id' => $goods_id ,
                'introduction' => $param['my_introduction'] ,
                'date' => date('Y-m-d H:i:s')
            ]);
            DB::commit();
            return self::success($goods_id);
        } catch(Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public static function edit(array $param)
    {
        $validator=  Validate::make([
            'id' => 'require' ,
            'cate_one_id' => 'require' ,
            'cate_two_id' => 'require' ,
            'name' => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        $m = ShopGoodsModel::findById($param['id']);
        if (empty($m)) {
            return self::error('未找到 id 对应项' , 404);
        }
        $param['pic'] = empty($param['pic']) ? $m->pic : $param['pic'];
        $shop_param = empty($param['shop_param']) ? [] : json_decode($param['shop_param'] , true);
        $shop_rule = empty($param['shop_rule']) ? [] : json_decode($param['shop_rule'] , true);
        $shop_image = empty($param['shop_image']) ? [] : json_decode($param['shop_image'] , true);

        try {
            DB::startTrans();
            ShopGoodsModel::updateById($m->id , array_unit($param , [
                'name' ,
                'cate_one_id' ,
                'cate_two_id' ,
                'status' ,
                'into' ,
                'freight' ,
                'is_hot' ,
                'is_recommend' ,
                'status' ,
                'pic' ,
            ]));
            ShopParameterModel::delByGoodsId($m->id);
            ShopPicturesModel::delByGoodsId($m->id);
            ShopComboModel::delByGoodsId($m->id);
            foreach ($shop_param as $v)
            {
                ShopParameterModel::insertGetId([
                    'good_id' => $m->id ,
                    'param_name' => $v['param_name'] ,
                    'param_value' => $v['param_value'] ,
                ]);
            }
            foreach ($shop_rule as $v)
            {
                ShopComboModel::insertGetId([
                    'good_id' => $m->id ,
                    'pic' => $v['pic'] ,
                    'name' => $v['name'] ,
                    'price' => $v['price'] ,
                    'salas' => $v['salas'] ,
                    'original_price' => $v['original_price'] ,
                    'stock' => $v['stock'] ,
                ]);
            }
            foreach ($shop_image as $v)
            {
                ShopPicturesModel::insertGetId([
                    'good_id' => $m->id ,
                    'pic' => $v['pic'] ,
                    'date' => date('Y-m-d H:i:s') ,
                ]);
            }
            ShopIntroductionModel::updateByGoodsId($m->id , [
                'introduction' => $param['my_introduction']
            ]);
            DB::commit();
            return self::success($m->id);
        } catch(Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public static function del(array $param)
    {
        $validator=  Validate::make([
            'id_list' => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        $id_list = json_decode($param['id_list'] , true);
        if (empty($id_list)) {
            return self::error('请提供待删除项');
        }
        ShopGoodsModel::delByIds($id_list);
        return self::success('操作成功');
    }
}