<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/7/18
 * Time: 11:53
 */

namespace app\admin\action;


use function admin\array_unit;
use function admin\parse_order;
use function admin\random;
use app\admin\model\SystemMessageModel;
use app\admin\model\SystemMessageTypeModel;
use app\admin\model\UserModel;
use think\Db;
use think\Validate;

use Exception;

class SystemMessageAction extends Action
{
    public static function list(array $param)
    {
        $param['limit'] = empty($param['limit']) ? config('app.limit') : $param['limit'];
        $order = parse_order($param['order']);
        $res = SystemMessageModel::list($param , $order , $param['limit']);
        return self::success($res);
    }

    public static function add(array $param)
    {
        $validator=  Validate::make([
            'title' => 'require' ,
            'type' => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        $type = SystemMessageTypeModel::findByType($param['type']);
        if (empty($type)) {
            return self::error('不支持的 type' , 404);
        }
        $param['date'] = empty($param['date']) ? date('Y-m-d H:i:s') : $param['date'];
        $param['msg_id'] = mt_rand(100000000 , 999999999);
        try {
            Db::startTrans();
            if ($param['type'] == 1) {
                // 系统消息
                $user = UserModel::getAll();
                foreach ($user as $v)
                {
                    $user = UserModel::findById($v);
                    if (empty($user)) {
                        return self::error('用户不存在' , 404);
                    }
                    $copy = $param;
                    $copy['uid'] = $v;
                    SystemMessageModel::insertGetId(array_unit($copy , [
                        'title' ,
                        'content' ,
                        'date' ,
                        'uid' ,
                        'type' ,
                        'img' ,
                        'msg_id' ,
                    ]));
                }
            } else {
                if (empty($param['uid'])) {
                    return self::error('uid 尚未提供');
                }
                $user = UserModel::findById($param['uid']);
                if (empty($user)) {
                    return self::error('用户不存在' , 404);
                }
                SystemMessageModel::insertGetId(array_unit($param , [
                    'title' ,
                    'content' ,
                    'date' ,
                    'uid' ,
                    'type' ,
                    'img' ,
                    'msg_id' ,
                ]));
            }
            Db::commit();
            return self::success();
        } catch(Exception $e) {
            Db::rollback();
            throw $e;
        }
    }

    public static function edit(array $param)
    {
        $validator=  Validate::make([
            'id' => 'require' ,
            'title' => 'require' ,
            'content' => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        $m = SystemMessageModel::findById($param['id']);
        if (empty($m)) {
            return self::error('未找到 id 对应项' , 404);
        }
        $param['date'] = empty($param['date']) ? $m->date : $param['date'];
        SystemMessageModel::updateById($m->id , array_unit($param , [
            'title' ,
            'content' ,
            'date' ,
        ]));
        return self::success($m->id);
    }

    public static function del(array $param)
    {
        $validator=  Validate::make([
            'id_list' => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        $id_list = json_decode($param['id_list'] , true);
        if (empty($id_list)) {
            return self::error('请提供待删除项');
        }
        $msg_ids = SystemMessageModel::getMsgIdByIds($id_list);
        SystemMessageModel::delByMsgIds($msg_ids);
        return self::success('操作成功');
    }
}