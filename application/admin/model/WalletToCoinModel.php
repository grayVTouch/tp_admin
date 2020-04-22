<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/6/19
 * Time: 10:31
 */

namespace app\admin\model;


use function admin\convert_obj;

class WalletToCoinModel extends Model
{
    protected $table = 'tk_wallet_to_coin';

    public static function single($m = null)
    {
        if (empty($m)) {
            return ;
        }
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
        }
        return $res;
    }

    public function fromCoin()
    {
        return $this->belongsTo(CoinModel::class , 'from_coin_id' , 'id');
    }

    public function toCoin()
    {
        return $this->belongsTo(CoinModel::class , 'to_coin_id' , 'id');
    }

    // 检查是否重复
    public static function isRepeatForCoin($id , $from_coin_id , $to_coin_id , $symbol)
    {
        return (bool) (self::where([
            ['id' , '<>' , $id] ,
            ['from_coin_id' , '=' , $from_coin_id] ,
            ['to_coin_id' , '=' , $to_coin_id] ,
            ['symbol' , '=' , $symbol] ,
        ])->count());
    }

    public static function findByFromCoinIdAndToCoinIdAndSymbol($from_coin_id , $to_coin_id , $symbol)
    {
        return self::where([
            ['from_coin_id' , '=' , $from_coin_id] ,
            ['to_coin_id' , '=' , $to_coin_id] ,
            ['symbol' , '=' , $symbol] ,
        ])->find();
    }
}