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

class GameProfitRecordModel extends Model
{
    protected $table = 'tk_game_profit_record';

    public static function single($m = null)
    {
        if (empty($m)) {
            return ;
        }
        $m->type_explain = get_value('business.game_profit_type' , $m->type);
    }

    public function user()
    {
        return $this->belongsTo(UserModel::class , 'uid' , 'id');
    }

    public static function list(array $filter = [] , array $order = [] , int $limit = 20)
    {
        $filter['id'] = $filter['id'] ?? '';
        $filter['uid'] = $filter['uid'] ?? '';
        $filter['order_id'] = $filter['order_id'] ?? '';
        $filter['type'] = $filter['type'] ?? '';
        $filter['phone'] = $filter['phone'] ?? '';
        $filter['username'] = $filter['username'] ?? '';
        $order['field'] = $filter['field'] ?? 'id';
        $order['value'] = $filter['value'] ?? 'desc';
        $where = [];
        if ($filter['id'] != '') {
            $where[] = ['gpr.id' , '=' , $filter['id']];
        }
        if ($filter['uid'] != '') {
            $where[] = ['gpr.uid' , '=' , $filter['uid']];
        }
        if ($filter['order_id'] != '') {
            $where[] = ['gpr.order_id' , '=' , $filter['order_id']];
        }
        if ($filter['type'] != '') {
            $where[] = ['gpr.type' , '=' , $filter['type']];
        }
        if ($filter['phone'] != '') {
            $where[] = ['u.phone' , '=' , $filter['phone']];
        }
        if ($filter['username'] != '') {
            $where[] = ['u.username' , 'like' , "%{$filter['username']}%"];
        }
        $res = self::with(['user'])
            ->alias('gpr')
            ->leftJoin('tk_user u' , 'gpr.uid = u.id')
            ->field('gpr.*')
            ->where($where)
            ->order("gpr.{$order['field']}" , $order['value'])
            ->order('gpr.id' , 'asc')
            ->paginate($limit);
        $res = convert_obj($res);
        foreach ($res->data as $v)
        {
            self::single($v);
            UserModel::single($v->user);
        }
        return $res;
    }

    public static function sumProfit()
    {
        return self::sum('profit');
    }
}