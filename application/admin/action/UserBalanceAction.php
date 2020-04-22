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
use app\admin\model\CoinModel;
use app\admin\model\OperationLogModel;
use app\admin\model\UserBalanceModel;
use app\admin\model\UserModel;
use app\admin\util\BalanceUtil;
use think\Db;
use think\Validate;

use Exception;

class UserBalanceAction extends Action
{
    public static function list(array $param)
    {
        $validator = Validate::make([
            'uid' => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        $param['limit'] = 10 * 1000;
        $order = parse_order($param['order']);
        $user = UserModel::findById($param['uid']);
        if (empty($user)) {
            return self::error('未找到用户' , 404);
        }
        try {
            Db::startTrans();
            // 处理币种
            $coin = CoinModel::getAll();
            foreach ($coin as $v)
            {
                UserBalanceModel::improveBalanceData($user->id , $v->id , config('app.wallet_name') , 0 , 0);
            }
            Db::commit();
        } catch(Exception $e) {
            Db::rollback();
            throw $e;
        }
        $res = UserBalanceModel::list($param , $order , $param['limit']);
        return self::success($res);
    }

    public static function updateBalance(array $param)
    {
        $validator = Validate::make([
            'id' => 'require' ,
            'amount' => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        $balance = UserBalanceModel::findById($param['id']);
        if (empty($balance)) {
            return self::error('未找到用户余额数据');
        }
        $order_id = random(32 , 'mixed' , true);
        $res = BalanceUtil::update($balance->uid , $balance->cid , $order_id , 203 , $param['amount'] , '后台拨币');
        if ($res['code'] != 0) {
            return self::error($res['data']);
        }
        return self::success('操作成功');
    }
}