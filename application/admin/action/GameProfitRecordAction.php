<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/7/18
 * Time: 11:53
 */

namespace app\admin\action;


use function admin\parse_order;
use app\admin\model\GameProfitRecordModel;

use Exception;

class GameProfitRecordAction extends Action
{
    public static function list(array $param)
    {
        $param['limit'] = empty($param['limit']) ? config('app.limit') : $param['limit'];
        $order = parse_order($param['order']);
        $res = GameProfitRecordModel::list($param , $order , $param['limit']);
        return self::success($res);
    }
}