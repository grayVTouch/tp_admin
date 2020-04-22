<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/6/19
 * Time: 10:31
 */

namespace app\admin\model;


use function admin\convert_obj;
use function admin\get_value;

class BbOrderModel extends Model
{
    protected $table = 'tk_bb_order';

    public static function single($m = null)
    {
        if (empty($m)) {
            return ;
        }
        $m->type_explain = get_value('business.bb_order_type' , $m->type);
        $m->status_explain = get_value('business.bb_order_status' , $m->status);
    }

    public function config()
    {
        return $this->belongsTo(BbConfigModel::class , 'config_id' , 'id');
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
        $filter['status'] = $filter['status'] ?? '';
        $filter['phone'] = $filter['phone'] ?? '';
        $filter['username'] = $filter['username'] ?? '';
        $order['field'] = $filter['field'] ?? 'id';
        $order['value'] = $filter['value'] ?? 'desc';
        $where = [];
        if ($filter['id'] != '') {
            $where[] = ['bbo.id' , '=' , $filter['id']];
        }
        if ($filter['uid'] != '') {
            $where[] = ['bbo.uid' , '=' , $filter['uid']];
        }
        if ($filter['type'] != '') {
            $where[] = ['bbo.type' , '=' , $filter['type']];
        }
        if ($filter['status'] != '') {
            $where[] = ['bbo.status' , '=' , $filter['status']];
        }
        if ($filter['phone'] != '') {
            $where[] = ['u.phone' , '=' , $filter['phone']];
        }
        if ($filter['username'] != '') {
            $where[] = ['u.username' , 'like' , "%{$filter['username']}%"];
        }
        $res = self::with(['config' , 'user'])
            ->alias('bbo')
            ->leftJoin('tk_user u' , 'u.id = bbo.uid')
            ->field('bbo.*')
            ->where($where)
            ->order("bbo.{$order['field']}" , $order['value'])
            ->order('bbo.id' , 'asc')
            ->paginate($limit);
        $res = convert_obj($res);
        foreach ($res->data as $v)
        {
            self::single($v);
            UserModel::single($v->user);
            BbConfigModel::single($v->config);
            if (!empty($v->config)) {
                $v->from_coin = CoinModel::findById($v->config->from_cid);
                $v->to_coin = CoinModel::findById($v->config->to_cid);
            }
        }
        return $res;
    }


}