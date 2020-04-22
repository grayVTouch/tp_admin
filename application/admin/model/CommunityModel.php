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

class CommunityModel extends Model
{
    protected $table = 'tk_community';

    public static function single($m = null)
    {
        if (empty($m)) {
            return ;
        }
        $m->status_explain = get_value('business.community_status' , $m->status);
        $m->type_explain = get_value('business.community_type' , $m->status);
        $m->is_app_explain = get_value('business.bool' , $m->is_app);
        $m->pic_explain = image_url($m->pic);
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