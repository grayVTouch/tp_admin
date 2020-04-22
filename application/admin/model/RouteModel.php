<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/6/18
 * Time: 17:44
 */

namespace app\admin\model;


use function admin\obj_to_array;
use app\admin\lib\Category;

class RouteModel extends Model
{
    protected $table = 'run_route';

    public static function getByRoleId(int $role_id)
    {
        $id_list = RoleRouteModel::where('role_id' , $role_id)
            ->column('route_id');
        return self::getByIds($id_list);
    }

    public static function getByIds(array $id_list = [])
    {
        $res = self::whereIn('id' , $id_list)
            ->where('enable' , 1)
            ->order('weight' , 'desc')
            ->order('id' , 'asc')
            ->select();
        static::multiple($res);
        return $res;
    }

    public static function getAll()
    {
        $res = self::where('enable' , 1)
            ->order('weight' , 'desc')
            ->order('id' , 'asc')
            ->select();
        self::multiple($res);
        return $res;
    }

    public static function findByRoute(string $route = '')
    {
        $res = self::where('route' , $route)
            ->find();
        self::single($res);
        return $res;
    }

    public static function allForMenu()
    {
        $res = self::where([
                ['menu' , '=' , 1] ,
                ['enable' , '=' , 1] ,
            ])
            ->order('weight' , 'desc')
            ->order('id' , 'asc')
            ->select();
        $res = obj_to_array($res);
        $res = Category::childrens(0 , $res , [
            'id'    => 'id' ,
            'p_id'  => 'p_id' ,
        ] , false , true);
        return $res;
    }
}