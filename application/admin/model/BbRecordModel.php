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

class BbRecordModel extends Model
{
    protected $table = 'tk_bb_record';

    public static function single($m = null)
    {
        if (empty($m)) {
            return ;
        }
    }

    public function config()
    {
        return $this->belongsTo(BbConfigModel::class , 'config_id' , 'id');
    }

    public function coin()
    {
        return $this->belongsTo(CoinModel::class , 'type' , 'id');
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
        $order['field'] = $filter['field'] ?? 'id';
        $order['value'] = $filter['value'] ?? 'desc';
        $where = [];
        if ($filter['id'] != '') {
            $where[] = ['bbr.id' , '=' , $filter['id']];
        }
        if ($filter['uid'] != '') {
            $where[] = ['bbr.uid' , '=' , $filter['id']];
        }
        if ($filter['phone'] != '') {
            $where[] = ['bbr.phone' , '=' , $filter['phone']];
        }
        if ($filter['username'] != '') {
            $where[] = ['bbr.username' , 'like' , "%{$filter['username']}%"];
        }
        $res = self::with(['config' , 'coin' , 'user'])
            ->alias('bbr')
            ->leftJoin('tk_user u' , 'bbr.uid = u.id')
            ->field('bbr.*')
            ->where($where)
            ->order("bbr.{$order['field']}" , $order['value'])
            ->order('bbr.id' , 'asc')
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
            CoinModel::single($v->coin);
        }
        return $res;
    }


}