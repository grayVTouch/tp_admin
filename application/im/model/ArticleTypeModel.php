<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/7/18
 * Time: 11:56
 */

namespace app\im\model;


use function im\convert_obj;
use function im\get_value;
use function im\image_url;

class ArticleTypeModel extends Model
{
    protected $table = 'cq_article_type';

    public static function single($m = null)
    {
        if (empty($m)) {
            return ;
        }
        $m->image_explain = empty($m->image) ? config('app.image') : image_url($m->image);
        $m->hidden_explain = get_value('business.bool_str' , $m->hidden);
    }

    public static function list(array $filter = [] , array $order = [] , int $limit = 20)
    {
        $filter['id'] = $filter['id'] ?? '';
        $filter['p_id'] = $filter['p_id'] ?? '';
        $order['field'] = $filter['field'] ?? 'id';
        $order['value'] = $filter['value'] ?? 'desc';
        $where = [];
        if ($filter['id'] != '') {
            $where[] = ['id' , '=' , $filter['id']];
        }
        if ($filter['p_id'] != '') {
            $where[] = ['p_id' , '=' , $filter['p_id']];
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

    public static function getIdByPID(int $p_id)
    {
        return self::where('p_id' , $p_id)
            ->column('id');
    }

    public static function getAll()
    {
        $res = self::order('id' , 'asc')
            ->select();
        $res = convert_obj($res);
        self::multiple($res);
        return $res;
    }


}