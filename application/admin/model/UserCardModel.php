<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/9/6
 * Time: 15:39
 */

namespace app\admin\model;


use function admin\convert_obj;
use function admin\get_value;

class UserCardModel extends Model
{
    protected $table = 'cq_user_card';

    public static function single($m = null)
    {
        if (empty($m)) {
            return ;
        }
        $m->active_explain = get_value('business.bool' , $m->active);
    }
}