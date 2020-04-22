<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/6/19
 * Time: 10:31
 */

namespace app\admin\model;


use function admin\convert_obj;

class WalletRecvModel extends Model
{
    protected $table = 'tk_wallet_recv';

    public static function single($m = null)
    {
        if (empty($m)) {
            return ;
        }
    }

    public function coin()
    {
        return $this->belongsTo(CoinModel::class , 'coin_id' , 'id');
    }

    public function user()
    {
        return $this->belongsTo(UserModel::class , 'uid' , 'id');
    }

    public static function list(array $filter = [] , array $order = [] , int $limit = 20)
    {
        $filter['id'] = $filter['id'] ?? '';
        $filter['coin_id'] = $filter['coin_id'] ?? '';
        $filter['start_date'] = $filter['start_date'] ?? '';
        $filter['end_date'] = $filter['end_date'] ?? '';
        $filter['phone'] = $filter['phone'] ?? '';
        $filter['username'] = $filter['username'] ?? '';
        $filter['uid'] = $filter['uid'] ?? '';
        $order['field'] = $filter['field'] ?? 'id';
        $order['value'] = $filter['value'] ?? 'desc';
        $where = [];
        $ins = self::with(['coin' , 'user'])
            ->alias('wr')
            ->leftJoin('tk_user u' , 'wr.uid = u.id');
        if ($filter['id'] != '') {
            $where[] = ['wr.id' , '=' , $filter['id']];
        }
        if ($filter['coin_id'] != '') {
            $where[] = ['wr.coin_id' , '=' , $filter['coin_id']];
        }
        if ($filter['start_date'] != '') {
            $ins->whereRaw("date_format(wr.date , '%Y-%m-%d') >= '{$filter['start_date']}'");
        }
        if ($filter['end_date'] != '') {
            $ins->whereRaw("date_format(wr.date , '%Y-%m-%d') <= '{$filter['end_date']}'");
        }
        if ($filter['username'] != '') {
            $where[] = ['u.username' , 'like' , "%{$filter['username']}%"];
        }
        if ($filter['phone'] != '') {
            $where[] = ['u.phone' , '=' , $filter['phone']];
        }
        if ($filter['uid'] != '') {
            $where[] = ['wr.uid' , '=' , $filter['uid']];
        }
        $res = $ins->where($where)
            ->order("wr.{$order['field']}" , $order['value'])
            ->order('wr.id' , 'asc')
            ->paginate($limit);
        $res = convert_obj($res);
        foreach ($res->data as $v)
        {
            self::single($v);
            UserModel::single($v->user);
            CoinModel::single($v->coin);
        }
        return $res;
    }

    public static function sumByGroup()
    {
        return self::with('coin')
            ->group('coin_id')
            ->field('id , coin_id , sum(amount) as amount')
            ->select();
    }

    public static function sumByCoinId($coin_id)
    {
        return (int) (self::where([
                ['coin_id' , '=' , $coin_id] ,
            ])
            ->sum('amount'));
    }

    public static function inSum()
    {
        return self::sum('amount');
    }

}