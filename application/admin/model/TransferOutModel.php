<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/9/6
 * Time: 15:39
 */

namespace app\admin\model;


use function admin\convert_obj;
use function admin\get_value;

class TransferOutModel extends Model
{
    protected $table = 'cq_transfer_out';

    public static function single($m = null)
    {
        if (empty($m)) {
            return ;
        }
        $m->complete_explain = get_value('business.transfer_out_complete' , $m->compelete);
        $m->approve_explain = get_value('business.approve_for_transfer_out' , $m->approve);
    }

    public function coin()
    {
        return $this->belongsTo(CoinModel::class , 'cid' , 'id');
    }

    public static function sumByGroup()
    {
        return self::with('coin')
            ->where([
                ['status' , '>=' , 0] ,
            ])
            ->group('cid')
            ->field('id , cid , sum(amount) as amount')
            ->select();
    }

    public function user()
    {
        return $this->belongsTo(UserModel::class , 'uid' , 'id');
    }

    public function userCard()
    {
        return $this->belongsTo(UserCardModel::class , 'card_id');
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
        $ins = self::with(['coin' , 'user' , 'user_card'])
            ->alias('to')
            ->leftJoin('cq_user u' , 'to.uid = u.id');
        if ($filter['id'] != '') {
            $where[] = ['to.id' , '=' , $filter['id']];
        }
        if ($filter['coin_id'] != '') {
            $where[] = ['to.cid' , '=' , $filter['coin_id']];
        }
        if ($filter['start_date'] != '') {
            $ins->whereRaw("date_format(to.date , '%Y-%m-%d') >= '{$filter['start_date']}'");
        }
        if ($filter['end_date'] != '') {
            $ins->whereRaw("date_format(to.date , '%Y-%m-%d') <= '{$filter['end_date']}'");
        }
        if ($filter['username'] != '') {
            $where[] = ['u.username' , 'like' , "%{$filter['username']}%"];
        }
        if ($filter['phone'] != '') {
            $where[] = ['u.phone' , '=' , $filter['phone']];
        }
        if ($filter['uid'] != '') {
            $where[] = ['to.uid' , '=' , $filter['uid']];
        }
//        print_r($where);
        $res = $ins->where($where)
            ->field('to.*')
            ->order("to.{$order['field']}" , $order['value'])
            ->order('to.id' , 'asc')
            ->paginate($limit);
        $res = convert_obj($res);
        foreach ($res->data as $v)
        {
            self::single($v);
            UserModel::single($v->user);
            CoinModel::single($v->coin);
            UserCardModel::single($v->user_card);
        }
        return $res;
    }

    public static function sumByCoinId($coin_id)
    {
        return (int) (self::where([
            ['cid' , '=' , $coin_id] ,
            ['status' , '>=' , 0] ,
        ])
            ->sum('amount'));
    }

    public static function outSum()
    {
        return self::where([
                ['status' , '>=' , 0] ,
            ])
            ->sum('amount');
    }
}