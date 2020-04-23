<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2020/4/23
 * Time: 10:18
 */

namespace app\admin\model;


use function admin\res_url;

class ShopComboModel extends Model
{
    protected $table = 'tp_shop_combo';

    public static function single($m = null)
    {
        if (empty($m)) {
            return ;
        }
        $m->pic_explain = res_url($m->pic);
    }

    public static function delByGoodsId($goods_id)
    {
        return self::where('good_id' , $goods_id)
            ->delete();
    }
}