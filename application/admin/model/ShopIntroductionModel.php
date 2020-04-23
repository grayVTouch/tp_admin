<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2020/4/23
 * Time: 10:16
 */

namespace app\admin\model;


class ShopIntroductionModel extends Model
{
    protected $table = 'tp_shop_introduction';

    public static function updateByGoodsId($goods_id , array $data = [])
    {
        return self::where([
            ['good_id' , '=' , $goods_id] ,
        ])->update($data);
    }
}