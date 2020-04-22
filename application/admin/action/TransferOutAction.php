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
use function admin\obj_to_array;
use function admin\parse_order;
use function admin\random;
use function admin\user;
use app\admin\lib\Http;
use app\admin\model\OperationLogModel;
use app\admin\model\TransferOutModel;
use app\admin\util\BalanceUtil;
use think\Db;
use think\Validate;

use Exception;

class TransferOutAction extends Action
{
    public static function list(array $param)
    {
        if (!empty($param['date_range'])) {
            $date_range = str_replace(' - ' , '|' , $param['date_range']);
            $range = explode('|' , $date_range);
            $param['start_date'] = $range[0];
            $param['end_date'] = $range[1];
        }
        $param['limit'] = empty($param['limit']) ? config('app.limit') : $param['limit'];
        $order = parse_order($param['order']);
        $res = TransferOutModel::list($param , $order , $param['limit']);
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
            return self::error('请提供待修改的项');
        }
        $status_range = [1 , -1];
        if (!in_array($param['status'] , $status_range)) {
            return self::error('不支持的状态');
        }
        TransferOutModel::updateByIds($id_list , [
            'approve' => 1 ,
            'compelete' => 1 ,
        ]);
        return self::success('操作成功');
    }

    public static function updateStatusSpecial(array $param)
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
            return self::error('请提供待修改的项');
        }
        $transfer_out_id = $id_list[0];
        $transfer_out = TransferOutModel::findById($transfer_out_id);
        if (empty($transfer_out)) {
            return self::error('未找到 id ' + $transfer_out_id + ' 对应记录' , 404);
        }
        $status_range = [1 , -1];
        if (!in_array($param['status'] , $status_range)) {
            return self::error('不支持的状态');
        }
        switch ($param['status'])
        {
            case 1:
                TransferOutModel::updateByIds($id_list , [
                    'approve' => 1 ,
                    'compelete' => 1 ,
                ]);
                break;
            case -1:
                Http::post('http://chat.kkweb.vip:170/adc/admin/admin_refund' , [
                    'data' => [
                        'order_id' => $transfer_out->order_id
                    ]
                ]);
                break;
        }
        return self::success('操作成功');
    }

    public static function updateCompleteStatus(array $param)
    {
        $validator = Validate::make([
            'id_list' => 'require' ,
            'complete' => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        $id_list = json_decode($param['id_list'] , true);
        if (empty($id_list)) {
            return self::error('请提供待修改的项');
        }
        $status_range = [0 , 1];
        if (!in_array($param['complete'] , $status_range)) {
            return self::error('不支持的状态');
        }
        TransferOutModel::updateByIds($id_list , [
            'compelete' => $param['complete']
        ]);
        return self::success('操作成功');
    }

}