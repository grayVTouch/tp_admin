<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/7/18
 * Time: 11:56
 */

namespace app\admin\model;


use function admin\convert_obj;
use function admin\get_value;
use function admin\res_url;

class ShopGoodsModel extends Model
{
    protected $table = 'tp_shop_goods';

    public static function single($m = null)
    {
        if (empty($m)) {
            return ;
        }
        $m->pic_explain = res_url($m->pic);
        $m->is_hot_explain = get_value('business.bool' , $m->is_hot);
        $m->is_recommend_explain = get_value('business.bool' , $m->is_recommend);
        $m->status_explain = get_value('business.shop_goods_status' , $m->status);
    }

    public function categoryOne()
    {
        return $this->belongsTo(ShopCategoryOneModel::class , 'cate_one_id' , 'id');
    }

    public function categoryTwo()
    {
        return $this->belongsTo(ShopCategoryTwoModel::class , 'cate_two_id' , 'id');
    }

    public function shopStore()
    {
        return $this->belongsTo(ShopStoreModel::class , 'store_id' , 'id');
    }

    public function myIntroduction()
    {
        return $this->hasOne(ShopIntroductionModel::class , 'good_id' , 'id');
    }

    public function image()
    {
        return $this->hasMany(ShopPicturesModel::class , 'good_id' , 'id');
    }

    public function shopParam()
    {
        return $this->hasMany(ShopParameterModel::class , 'good_id' , 'id');
    }

    public function shopRule()
    {
        return $this->hasMany(ShopComboModel::class , 'good_id' , 'id');
    }

    public static function list(array $filter = [] , array $order = [] , int $limit = 20)
    {
        $filter['id'] = $filter['id'] ?? '';
        $filter['store_uid'] = $filter['store_uid'] ?? '';
        $order['field'] = $filter['field'] ?? 'id';
        $order['value'] = $filter['value'] ?? 'desc';
        $where = [];
        if ($filter['id'] != '') {
            $where[] = ['id' , '=' , $filter['id']];
        }
        if ($filter['store_uid'] != '') {
            $where[] = ['store_uid' , '=' , $filter['store_uid']];
        }
        $res = self::with(['categoryOne' , 'categoryTwo' , 'shopStore'])
            ->where($where)
            ->order($order['field'] , $order['value'])
            ->order('id' , 'asc')
            ->paginate($limit);
        $res = convert_obj($res);
        foreach ($res->data as $v)
        {
            self::single($v);
            ShopCategoryOneModel::single($v->category_one);
            ShopCategoryTwoModel::single($v->category_two);
            ShopStoreModel::single($v->shop_store);
        }
        return $res;
    }

    public static function findById($id)
    {
        $res = self::with(['categoryOne' , 'categoryTwo' , 'shopStore' , 'shopParam' , 'shopRule' , 'myIntroduction' , 'image'])
            ->find($id);
        if (empty($res)) {
            return ;
        }
        $res = convert_obj($res);
        self::single($res);
        ShopCategoryOneModel::single($res->category_one);
        ShopCategoryTwoModel::single($res->category_two);
        ShopStoreModel::single($res->shop_store);
        ShopComboModel::multiple($res->shop_rule);
        ShopParameterModel::multiple($res->shop_param);
        ShopIntroductionModel::single($res->my_introduction);
        ShopPicturesModel::multiple($res->image);
        return $res;
    }
}