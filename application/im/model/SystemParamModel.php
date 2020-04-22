<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/7/24
 * Time: 12:15
 */

namespace app\im\model;


use function im\convert_obj;
use function im\get_value;
use function im\image_url;

class SystemParamModel extends Model
{
    protected $table = 'cq_system_param';

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
}