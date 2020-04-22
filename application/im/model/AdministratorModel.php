<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/6/19
 * Time: 10:32
 */

namespace app\im\model;


class AdministratorModel extends Model
{
    protected $table = 'run_administrator';

    public function role()
    {
        return $this->belongsTo(RoleModel::class , 'role_id' , 'id');
    }

    public static function findById(int $id)
    {
        $res = self::with('role')
            ->find($id);
        if (empty($res)) {
            return ;
        }
        self::single($res);
        RoleModel::single($res->role);
        return $res;
    }

    public static function findByUsername($username = '')
    {
        $res = self::with('role')
            ->where('username' , $username)
            ->find();
        if (empty($res)) {
            return ;
        }
        self::single($res);
        RoleModel::single($res->role);
        return $res;
    }
}