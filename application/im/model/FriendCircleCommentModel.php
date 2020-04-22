<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/7/30
 * Time: 15:49
 */

namespace app\im\model;


use function im\convert_obj;
use function im\get_value;

class FriendCircleCommentModel extends Model
{
    protected $table = 'cq_friend_circle_comment';

    public static function single($m = null)
    {
        if (empty($m)) {
            return ;
        }
    }

    public function user()
    {
        return $this->belongsTo(UserInfoModel::class , 'user_id' , 'uid');
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
        $res = self::with(['user'])
            ->where($where)
            ->order($order['field'] , $order['value'])
            ->order('id' , 'asc')
            ->paginate($limit);
        $res = convert_obj($res);
        foreach ($res->data as $v)
        {
            self::single($v);
            UserInfoModel::single($v->user);
        }
        return $res;
    }

    public static function delByFriendCircleIds(array $id_list = [])
    {
        return self::whereIn('friend_circle_id' , $id_list)
            ->delete();
    }
}