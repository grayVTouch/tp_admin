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

class BalanceRecordModel extends Model
{
    protected $table = 'cq_balance_record';

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

    public function user()
    {
        return $this->belongsTo(UserModel::class , 'uid' , 'id');
    }

    public static function list(array $filter = [] , array $order = [] , int $limit = 20)
    {
        $filter['id'] = $filter['id'] ?? '';
        $filter['uid'] = $filter['uid'] ?? '';
        $filter['coin_id'] = $filter['coin_id'] ?? '';
        $filter['wallet_name'] = $filter['wallet_name'] ?? '';
        $filter['type'] = $filter['type'] ?? '';
        $filter['username'] = $filter['username'] ?? '';
        $filter['phone'] = $filter['phone'] ?? '';
        $order['field'] = $filter['field'] ?? 'id';
        $order['value'] = $filter['value'] ?? 'desc';
        $where = [];
        if ($filter['id'] != '') {
            $where[] = ['br.id' , '=' , $filter['id']];
        }
        if ($filter['uid'] != '') {
            $where[] = ['br.uid' , '=' , $filter['uid']];
        }
        if ($filter['coin_id'] != '') {
            $where[] = ['br.cid' , '=' , $filter['coin_id']];
        }
        if ($filter['type'] != '') {
            $where[] = ['br.type' , '=' , $filter['type']];
        }
        if ($filter['username'] != '') {
            $where[] = ['u.username' , '=' , $filter['username']];
        }
        if ($filter['phone'] != '') {
            $where[] = ['u.phone' , '=' , $filter['phone']];
        }
//        print_r($where);
        $res = self::with(['coin' , 'user'])
            ->alias('br')
            ->leftJoin('cq_user u' , 'br.uid = u.id')
            ->where($where)
            ->order("br.{$order['field']}" , $order['value'])
            ->order('br.id' , 'asc')
            ->field('br.*')
            ->paginate($limit);
        $res = convert_obj($res);
        foreach ($res->data as $v)
        {
            self::single($v);
            CoinModel::single($v->coin);
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

    public static function sumByRecordType($type)
    {
        return self::where('type' , $type)
            ->sum('balance');
    }
}