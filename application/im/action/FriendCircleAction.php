<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/7/19
 * Time: 15:46
 */

namespace app\im\action;


use function im\array_unit;
use function im\parse_order;
use app\im\model\FriendCircleCommentModel;
use app\im\model\FriendCircleMediaModel;
use app\im\model\FriendCircleModel;
use Exception;
use think\Db;
use think\Validate;

class FriendCircleAction extends Action
{
    public static function list(array $param)
    {
        $param['limit'] = empty($param['limit']) ? config('app.limit') : $param['limit'];
        $order = parse_order($param['order']);
        $res = FriendCircleModel::list($param , $order , $param['limit']);
        return self::success($res);
    }

    // 删除
    public static function del(array $param)
    {
        $validator = Validate::make([
            'id_list' => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        $id_list = json_decode($param['id_list'] , true);
        if (empty($id_list)) {
            return self::error('请提供待删除的项');
        }
        try {
            Db::startTrans();
            FriendCircleModel::delByIds($id_list);
            FriendCircleMediaModel::delByFriendCircleIds($id_list);
            FriendCircleCommentModel::delByFriendCircleIds($id_list);
            Db::commit();
            return self::success('操作成功');
        } catch(Exception $e) {
            Db::rollback();
            throw $e;
        }
    }


}