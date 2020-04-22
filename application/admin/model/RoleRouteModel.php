<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/6/19
 * Time: 15:49
 */

namespace app\admin\model;

class RoleRouteModel extends Pivot
{
    protected $table = 'run_role_route';

    public static function delByRoleId($role_id)
    {
        return self::where('role_id' , $role_id)
            ->delete();
    }
}