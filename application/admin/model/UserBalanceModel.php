<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/7/18
 * Time: 11:56
 */

namespace app\admin\model;


use function admin\convert_obj;
use function admin\get_value;
use function admin\image_url;

class UserBalanceModel extends Model
{
    protected $table = 'cq_user_balance';

    public static function single($m = null)
    {
        if (empty($m)) {
            return ;
        }
    }

    public function coin()
    {
        return $this->belongsTo(CoinModel::class , 'cid' , 'id');
    }

    public static function list(array $filter = [] , array $order = [] , int $limit = 20)
    {
        $filter['id'] = $filter['id'] ?? '';
        $filter['uid'] = $filter['uid'] ?? '';
        $filter['cid'] = $filter['cid'] ?? '';
        $order['field'] = $filter['field'] ?? 'id';
        $order['value'] = $filter['value'] ?? 'desc';
        $where = [];
        if ($filter['id'] != '') {
            $where[] = ['id' , '=' , $filter['id']];
        }
        if ($filter['uid'] != '') {
            $where[] = ['uid' , '=' , $filter['uid']];
        }
        if ($filter['cid'] != '') {
            $where[] = ['cid' , '=' , $filter['cid']];
        }
        $res = self::with(['coin'])
            ->where($where)
            ->order($order['field'] , $order['value'])
            ->order('id' , 'asc')
            ->paginate($limit);
        $res = convert_obj($res);
        foreach ($res->data as $v)
        {
            self::single($v);
        }
        return $res;
    }

    public static function findByUidAndCoinId($uid , $coin_id)
    {
        $res = self::where([
            ['uid' , '=' , $uid] ,
            ['cid' , '=' , $coin_id] ,
        ])->find();
        self::single($res);
        return $res;
    }

    public static function api_auto($uid, $coin_id, $balance = '0', $freeze_balance = 0) {
        $user_balance = self::findByUidAndCoinId($uid, $coin_id);
        if (empty($user_balance)) {
            return self::insertGetId([
                'uid' => $uid,
                'cid' => $coin_id,
                'balance' => $balance,
            ]);
        }
        $ins = self::where([
                'uid' => $uid,
                'cid' => $coin_id,
            ])
            ->inc('balance' , $balance);
        if ($freeze_balance) {
//            $ins = $ins->inc('freeze_balance', $freeze_balance);
        }
        return $ins->update();
    }

    // 完善用户资金数据
    public static function improveBalanceData($uid , $coin_id , $wallet_name = 'wallet' , $balance = 0 , $freeze_balance = 0)
    {
        $user_balance = self::findByUidAndCoinId($uid, $coin_id, $wallet_name);
        if (!empty($user_balance)) {
            return ;
        }
        return self::insertGetId([
            'uid' => $uid,
            'cid' => $coin_id,
            'balance' => $balance,
        ]);
    }
}