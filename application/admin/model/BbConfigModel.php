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

class BbConfigModel extends Model
{
    protected $table = 'tk_bb_config';

    public static function single($m = null)
    {
        if (empty($m)) {
            return ;
        }
    }

    public function fromCoin()
    {
        return $this->belongsTo(CoinModel::class , 'from_cid' , 'id');
    }

    public function toCoin()
    {
        return $this->belongsTo(CoinModel::class , 'to_cid' , 'id');
    }

    public static function list(array $filter = [] , array $order = [] , int $limit = 20)
    {
        $filter['id'] = $filter['id'] ?? '';
        $order['field'] = $filter['field'] ?? 'id';
        $order['value'] = $filter['value'] ?? 'desc';
        $where = [];
        if ($filter['id'] != '') {
            $where[] = ['id' , '=' , $filter['id']];
        }
        $res = self::with(['from_coin' , 'to_coin'])
            ->where($where)
            ->order($order['field'] , $order['value'])
            ->order('id' , 'asc')
            ->paginate($limit);
        $res = convert_obj($res);
        foreach ($res->data as $v)
        {
            self::single($v);
            CoinModel::single($v->from_coin);
            CoinModel::single($v->to_coin);
        }
        return $res;
    }


}