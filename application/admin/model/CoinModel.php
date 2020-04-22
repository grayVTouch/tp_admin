<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/6/19
 * Time: 10:31
 */

namespace app\admin\model;


use function admin\convert_obj;

class CoinModel extends Model
{
    protected $table = 'cq_coin';

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
        $where = [
            ['status' , '=' , 1] ,
        ];
        if ($filter['id'] != '') {
            $where[] = ['id' , '=' , $filter['id']];
        }
        $res = self::where($where)
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

    public static function getAll()
    {
//        $res = self::where([
//                ['status' , '=' , 1]
//            ])
//            ->select();
        $res = self::select();
        self::multiple($res);
        return $res;
    }
}