<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2020/4/23
 * Time: 10:18
 */

namespace app\admin\model;


class ShopParameterModel extends Model
{
    protected $table = 'tp_shop_parameter';

    public static function delByGoodsId($goods_id)
    {
        return self::where('good_id' , $goods_id)
            ->delete();
    }
}