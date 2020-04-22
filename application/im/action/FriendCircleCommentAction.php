<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/7/19
 * Time: 15:46
 */

namespace app\im\action;


use function im\parse_order;
use app\im\model\FriendCircleCommentModel;
use think\Validate;

class FriendCircleCommentAction extends Action
{
    public static function list(array $param)
    {
        $param['limit'] = empty($param['limit']) ? config('app.limit') : $param['limit'];
        $order = parse_order($param['order']);
        $res = FriendCircleCommentModel::list($param , $order , $param['limit']);
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
        FriendCircleCommentModel::delByIds($id_list);
        return self::success('操作成功');
    }


}