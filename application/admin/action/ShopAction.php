<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2020/4/22
 * Time: 14:11
 */

namespace app\admin\action;


use function admin\array_unit;
use app\admin\controller\Auth;
use app\admin\model\ShopStoreModel;
use think\facade\Validate;

class ShopAction extends Action
{
    public static function edit(Auth $auth , array $param)
    {
        $validator = Validate::make([
            'id' => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        $shop_store = ShopStoreModel::findById($param['id']);
        if (empty($shop_store)) {
            return self::error('未找到商户信息' , 404);
        }
        $param['pic'] = empty($param['pic']) ? $shop_store->pic : $param['pic'];
        ShopStoreModel::updateById($shop_store->id , array_unit($param , [
            'pic' ,
            'name' ,
            'introduction' ,
            'case' ,
            'kf_uid' ,
        ]));
        return self::success();
    }
}