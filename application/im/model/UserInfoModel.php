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

class UserInfoModel extends Model
{
    protected $table = 'cq_user_info';

    public static function single($m = null)
    {
        if (empty($m)) {
            return ;
        }
        $m->face_explain = empty($m->avatar) ? config('app.avatar') : image_url($m->face);
//        $m->status_explain = get_value('business.user_status' , $m->status);
        $m->sex_explain = get_value('business.sex' , $m->sex);
    }

    public function friendCircleInfo()
    {
        return $this->hasOne(FriendCircleInfoModel::class , 'user_id' , 'uid');
    }

    public function balance()
    {
        return $this->hasMany(UserBalanceModel::class , 'user_id' , 'uid');
    }

    public static function list(array $filter = [] , array $order = [] , int $limit = 20)
    {
        $filter['id'] = $filter['id'] ?? '';
        $filter['uid'] = $filter['uid'] ?? '';
        $filter['sex'] = $filter['sex'] ?? '';
        $filter['telephone'] = $filter['telephone'] ?? '';
        $order['field'] = $filter['field'] ?? 'id';
        $order['value'] = $filter['value'] ?? 'desc';
        $where = [];
        if ($filter['id'] != '') {
            $where[] = ['id' , '=' , $filter['id']];
        }
        if ($filter['uid'] != '') {
            $where[] = ['uid' , '=' , $filter['uid']];
        }
        if ($filter['sex'] != '') {
            $where[] = ['sex' , '=' , $filter['sex']];
        }
        if ($filter['telephone'] != '') {
            $where[] = ['telephone' , '=' , $filter['telephone']];
        }
        $res = self::with(['friend_circle_info' , 'balance'])
            ->where($where)
            ->order($order['field'] , $order['value'])
            ->order('id' , 'asc')
            ->paginate($limit);
        $res = convert_obj($res);
        foreach ($res->data as $v)
        {
            self::single($v);
            FriendCircleInfoModel::single($v->friend_circle_info);
            foreach ($v->balance as $v1)
            {
                UserBalanceModel::single($v1);
                $v1->coin = CoinModel::findById($v1->coin_id);
            }
        }
        return $res;
    }
}