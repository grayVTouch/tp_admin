<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2020/4/22
 * Time: 11:15
 */

namespace app\admin\model;


use function admin\convert_obj;
use function admin\get_value;
use function admin\res_url;

class ShopStoreModel extends Model
{
    protected $table = 'tp_shop_store';

    public static function single($m = null)
    {
        if (empty($m)) {
            return ;
        }
        $m->type_explain = get_value('business.shop_goods_auth' , $m->type);
        $m->status_explain = get_value('business.shop_status' , $m->status);
        $m->pic_explain = res_url($m->pic);
    }

    public static function findByUid($uid)
    {
        $res = self::where('uid' , $uid)
            ->find();
        if (empty($res)) {
            return ;
        }
        $res = convert_obj($res);
        self::single($res);
        return $res;
    }
}