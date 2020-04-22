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
use app\admin\model\OperationLogModel;
use app\admin\model\WalletRecvModel;
use app\admin\util\BalanceUtil;
use think\Db;
use think\Validate;

use Exception;

class WalletRecvAction extends Action
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
        $res = WalletRecvModel::list($param , $order , $param['limit']);
        return self::success($res);
    }
}