<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/6/19
 * Time: 10:31
 */

namespace app\im\model;


class RoleModel extends Model
{
    protected $table = 'run_role';

    public static function single($m = null)
    {
        if (empty($m)) {
            return ;
        }
    }
}