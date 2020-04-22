<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/7/30
 * Time: 16:47
 */

namespace app\im\model;


use function im\image_url;

class FriendCircleMediaModel extends Model
{
    protected $table = 'cq_friend_circle_media';

    public static function single($m = null)
    {
        if (empty($m)) {
            return ;
        }
        $m->image = empty($m->path) ? config('app.image') : image_url($m->path);
    }

    public static function delByFriendCircleIds(array $id_list = [])
    {
        return self::whereIn('friend_circle_id' , $id_list)
            ->delete();
    }
}