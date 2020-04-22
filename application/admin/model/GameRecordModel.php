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

class GameRecordModel extends Model
{
    protected $table = 'tk_game_record';

    public static function single($m = null)
    {
        if (empty($m)) {
            return ;
        }
        $m->status_explain = get_value('business.game_status' , $m->status);
    }

    public function user()
    {
        return $this->belongsTo(UserModel::class , 'uid' , 'id');
    }

    public static function list(array $filter = [] , array $order = [] , int $limit = 20)
    {
        $filter['id'] = $filter['id'] ?? '';
        $filter['uid'] = $filter['uid'] ?? '';
        $filter['phone'] = $filter['phone'] ?? '';
        $filter['username'] = $filter['username'] ?? '';
        $filter['status'] = $filter['status'] ?? '';
        $order['field'] = $filter['field'] ?? 'id';
        $order['value'] = $filter['value'] ?? 'desc';
        $where = [];
        if ($filter['id'] != '') {
            $where[] = ['gr.id' , '=' , $filter['id']];
        }
        if ($filter['uid'] != '') {
            $where[] = ['gr.uid' , '=' , $filter['uid']];
        }
        if ($filter['phone'] != '') {
            $where[] = ['u.phone' , '=' , $filter['phone']];
        }
        if ($filter['status'] != '') {
            $where[] = ['gr.status' , '=' , $filter['status']];
        }
        if ($filter['username'] != '') {
            $where[] = ['u.username' , 'like' , "%{$filter['username']}%"];
        }
        $res = self::with(['user'])
            ->alias('gr')
            ->leftJoin('tk_user u' , 'gr.uid = u.id')
            ->field('gr.*')
            ->where($where)
            ->order("gr.{$order['field']}" , $order['value'])
            ->order('gr.id' , 'asc')
            ->paginate($limit);
        $res = convert_obj($res);
        foreach ($res->data as $v)
        {
            self::single($v);
            UserModel::single($v->user);
        }
        return $res;
    }

    public static function sumAmount()
    {
        return self::sum('amount');
    }

    public static function sumAmountByUserId($user_id)
    {
        return self::where('uid' , $user_id)
            ->sum('amount');
    }

    public static function sumInvestment()
    {
        return self::sum('amount');
    }
}