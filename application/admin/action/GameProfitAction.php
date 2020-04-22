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
use app\admin\model\GameRecordModel;
use app\admin\model\OperationLogModel;
use app\admin\model\GameProfitModel;
use think\Db;
use think\Validate;

use Exception;

class GameProfitAction extends Action
{
    public static function list(array $param)
    {
        $param['limit'] = empty($param['limit']) ? config('app.limit') : $param['limit'];
        $order = parse_order($param['order']);
        $res = GameProfitModel::list($param , $order , $param['limit']);
        foreach ($res->data as $v)
        {
            // 总投资（游戏转入）
            $v->in_sum_amount = GameRecordModel::sumAmountByUserId($v->uid);
            // 总提取
            $v->total_withdraw = bcsub($v->total_game_profit , $v->game_profit);
        }
        return self::success($res);
    }
}