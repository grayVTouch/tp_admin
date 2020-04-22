<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2020/4/22
 * Time: 11:15
 */

namespace app\admin\model;


class ShopStoreModel extends Model
{
    protected $table = 'tp_shop_store';

    public static function findByUid($uid)
    {
        $res = self::where('uid' , $uid)
            ->find();
        if (empty($res)) {
            return ;
        }
        return $res;
    }
}