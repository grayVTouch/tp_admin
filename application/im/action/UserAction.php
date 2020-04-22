<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/7/18
 * Time: 11:53
 */

namespace app\im\action;


use function im\array_unit;
use function im\get_value;
use function im\parse_order;
use function im\user;
use app\im\model\FriendCircleInfoModel;
use app\im\model\OperationLogModel;
use app\im\model\UserInfoModel;
use think\Db;
use think\Validate;

use Exception;

class UserAction extends Action
{
    public static function list(array $param)
    {
        $param['limit'] = empty($param['limit']) ? config('app.limit') : $param['limit'];
        $order = parse_order($param['order']);
        $res = UserInfoModel::list($param , $order , $param['limit']);
        foreach ($res->data as $v)
        {
            if (empty($v->friend_circle_info)) {
                // 没有朋友圈
                $id = FriendCircleInfoModel::insertGetId([
                    'user_id' => $v->uid ,
                    'background_image' => '' ,
                ]);
                $v->friend_circle_info = FriendCircleInfoModel::findById($id);
            }
        }
        return self::success($res);
    }

    public static function updateStatus(array $param)
    {
        $validator = Validate::make([
            'id_list' => 'require' ,
            'status' => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        $id_list = json_decode($param['id_list'] , true);
        if (empty($id_list)) {
            return self::error('请提供待待修改记录');
        }
        $range = [1,2];
        if (!in_array($param['status'] , $range)) {
            return self::error('不支持的状态类型');
        }
        try {
            Db::startTrans();
            $user = user();
            foreach ($id_list as $v)
            {
                $m = UserInfoModel::findById($v);
                if (empty($m)) {
                    Db::rollback();
                    return self::error(sprintf('未找到 id = %s 对应数据，请提供正确数据后重试' , $v) , 404);
                }
                UserInfoModel::updateById($v , array_unit($param , [
                    'status'
                ]));
                // 记录操作日志
                OperationLogModel::u_insertGetId($user->id , 'common' , sprintf('修改平台用户【%d】状态由%s【%d】到 %s【%d】' , $v , $m->status_explain , $m->status , get_value('business.user_status' , $param['status']) , $param['status']));
            }
            Db::commit();
            return self::success('操作成功');
        } catch(Exception $e) {
            Db::rollback();
            throw $e;
        }
    }
}