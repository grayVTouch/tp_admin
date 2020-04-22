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

class GameProfitModel extends Model
{
    protected $table = 'tk_game_profit';

    public static function single($m = null)
    {
        if (empty($m)) {
            return ;
        }
    }

    public function user()
    {
        return $this->belongsTo(UserModel::class , 'uid' , 'id');
    }

    public static function list(array $filter = [] , array $order = [] , int $limit = 20)
    {
        $filter['id'] = $filter['id'] ?? '';
        $filter['uid'] = $filter['uid'] ?? '';
        $filter['username'] = $filter['username'] ?? '';
        $filter['phone'] = $filter['phone'] ?? '';
        $order['field'] = $filter['field'] ?? 'id';
        $order['value'] = $filter['value'] ?? 'desc';
        $where = [];
        if ($filter['id'] != '') {
            $where[] = ['gp.id' , '=' , $filter['id']];
        }
        if ($filter['uid'] != '') {
            $where[] = ['gp.uid' , '=' , $filter['uid']];
        }
        if ($filter['phone'] != '') {
            $where[] = ['u.phone' , '=' , $filter['phone']];
        }
        if ($filter['username'] != '') {
            $where[] = ['u.username' , 'like' , "%{$filter['username']}%"];
        }
        $res = self::with(['user'])
            ->alias('gp')
            ->leftJoin('tk_user u' , 'u.id = gp.uid')
            ->field('gp.*')
            ->where($where)
            ->order("gp.{$order['field']}" , $order['value'])
            ->order('gp.id' , 'asc')
            ->paginate($limit);
        $res = convert_obj($res);
        foreach ($res->data as $v)
        {
            self::single($v);
            UserModel::single($v->user);
        }
        return $res;
    }
}