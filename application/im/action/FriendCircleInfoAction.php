<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/7/29
 * Time: 15:22
 */

namespace app\im\action;


use function im\array_unit;
use app\im\model\FriendCircleInfoModel;
use think\Validate;

class FriendCircleInfoAction extends Action
{
    public static function updateCanPublish(array $param)
    {
        $validator = Validate::make([
            'id_list' => 'require' ,
            'can_publish' => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        $range = ['y' , 'n'];
        if (!in_array($param['can_publish'] , $range)) {
            return self::error('can_publish 参数错误');
        }
        $id_list = json_decode($param['id_list'] , true);
        if (empty($id_list)) {
            return self::error('请提供待处理的 id');
        }
        FriendCircleInfoModel::updateByIds($id_list , array_unit($param , [
            'can_publish' ,
        ]));
        return self::success('操作成功');
    }

    public static function updateCanComment(array $param)
    {
        $validator = Validate::make([
            'id_list'   => 'require' ,
            'can_comment' => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        $range = ['y' , 'n'];
        if (!in_array($param['can_comment'] , $range)) {
            return self::error('can_comment 参数错误');
        }
        $id_list = json_decode($param['id_list'] , true);
        if (empty($id_list)) {
            return self::error('请提供待处理的 id');
        }
        FriendCircleInfoModel::updateByIds($id_list , array_unit($param , [
            'can_comment' ,
        ]));
        return self::success('操作成功');
    }
}