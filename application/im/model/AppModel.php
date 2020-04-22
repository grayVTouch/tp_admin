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

class AppModel extends Model
{
    protected $table = 'cq_app';

    public static function findByUserId(int $user_id)
    {
        $res = self::where('user_id' , $user_id)
            ->find();
        if (empty($res)) {
            return ;
        }
        self::single($res);
        return $res;
    }

    public static function single($m = null)
    {
        if (empty($m)) {
            return ;
        }
        $m->thumb_explain = empty($m->thumb) ? config('app.image') : image_url($m->thumb);
        $m->is_app_explain = get_value('business.bool' , $m->is_app);
    }

    public function user()
    {
        return $this->hasOne(UserInfoModel::class , 'id' , 'user_id');
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