<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/7/18
 * Time: 11:53
 */

namespace app\admin\action;


use function admin\array_unit;
use function admin\get_value;
use function admin\parse_order;
use function admin\user;
use app\admin\model\OperationLogModel;
use app\admin\model\BalanceRecordModel;
use think\Db;
use think\Validate;

use Exception;

class BalanceRecordAction extends Action
{
    public static function list(array $param)
    {
        $param['limit'] = empty($param['limit']) ? config('app.limit') : $param['limit'];
        $order = parse_order($param['order']);
        $res = BalanceRecordModel::list($param , $order , $param['limit']);
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
                $m = BalanceRecordModel::findById($v);
                if (empty($m)) {
                    Db::rollback();
                    return self::error(sprintf('未找到 id = %s 对应数据，请提供正确数据后重试' , $v) , 404);
                }
                BalanceRecordModel::updateById($v , array_unit($param , [
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