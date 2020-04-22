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

class GameTqRecordModel extends Model
{
    protected $table = 'tk_game_tq_record';

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
        $filter['type'] = $filter['type'] ?? '';
        $filter['phone'] = $filter['phone'] ?? '';
        $filter['username'] = $filter['username'] ?? '';
        $order['field'] = $filter['field'] ?? 'id';
        $order['value'] = $filter['value'] ?? 'desc';
        $where = [];
        if ($filter['id'] != '') {
            $where[] = ['gtr.id' , '=' , $filter['id']];
        }
        if ($filter['uid'] != '') {
            $where[] = ['gtr.uid' , '=' , $filter['uid']];
        }
        if ($filter['type'] != '') {
            $where[] = ['gtr.type' , '=' , $filter['type']];
        }
        if ($filter['phone'] != '') {
            $where[] = ['u.phone' , '=' , $filter['phone']];
        }
        if ($filter['username'] != '') {
            $where[] = ['u.username' , 'like' , "%{$filter['username']}%"];
        }
        $res = self::with(['user'])
            ->alias('gtr')
            ->leftJoin('tk_user u' , 'gtr.uid = u.id')
            ->where($where)
            ->order("gtr.{$order['field']}" , $order['value'])
            ->order('gtr.id' , 'asc')
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
}