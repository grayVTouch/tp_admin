<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/7/29
 * Time: 15:31
 */

namespace app\im\action;


use function im\user;
use app\im\model\OperationLogModel;
use app\im\model\UserBalanceModel;
use Exception;
use think\Db;
use think\Validate;

class UserBalanceAction extends Action
{
    public static function allocateCF(array $param)
    {
        $validator = Validate::make([
            'user_id' => 'require' ,
            'amount' => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        //
        $balance = UserBalanceModel::findByUserIdAndCoinId($param['user_id'] , 1);
        if (empty($balance)) {
            return self::error('未找到用户币种信息');
        }
        $update_balance = $balance->balance + $param['amount'];
        try {
            Db::startTrans();
            UserBalanceModel::updateByUserId($param['user_id'] , [
                'balance' => $update_balance
            ]);
            OperationLogModel::u_insertGetId(user()->id , 'fund' , sprintf('为用户【%s】新增 %s %s ' , $param['user_id'] , $balance->coin->name , $param['amount']));
            Db::commit();
            return self::success('操作成功');
        } catch(Exception $e) {
            Db::rollback();
            throw $e;
        }
    }
}