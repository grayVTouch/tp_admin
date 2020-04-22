<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/6/19
 * Time: 10:31
 */

namespace app\admin\model;


use function admin\convert_obj;

class RoleModel extends Model
{
    protected $table = 'run_role';

    public static function single($m = null)
    {
        if (empty($m)) {
            return ;
        }
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

    public function route()
    {
        return $this->belongsToMany(RouteModel::class , RoleRouteModel::class , 'route_id' , 'role_id');
    }

    // 获取给定角色的权限列表
    public static function getRouteById($role_id)
    {
        $res = self::with([
                'route' => function($query){
                     return $query->where('enable' , 1);
                }
            ])
            ->where('id' , $role_id)
            ->find();
        if (empty($res)) {
            return ;
        }
        self::single($res);
        self::multiple($res->route);
        return $res;
    }


}