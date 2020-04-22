<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/7/29
 * Time: 12:07
 */

namespace app\im\model;


use function im\get_value;

class FriendCircleInfoModel extends Model
{
    protected $table = 'cq_friend_circle_info';

    public static function findByUid(int $uid)
    {
        $res = self::where('user_id' , $uid)
            ->find();
        self::single($res);
        return $res;
    }

    public static function single($m = null)
    {
        if (empty($m)) {
            return ;
        }
        $m->can_publish_explain = get_value('business.bool_str' , $m->can_publish);
        $m->can_comment_explain = get_value('business.bool_str' , $m->can_comment);
    }
}