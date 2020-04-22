<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/7/18
 * Time: 11:53
 */

namespace app\admin\action;


use function admin\array_unit;
use function admin\get_value;
use function admin\obj_to_array;
use function admin\parse_order;
use function admin\user;
use app\admin\lib\Category;
use app\admin\model\OperationLogModel;
use app\admin\model\RoleModel;
use app\admin\model\RoleRouteModel;
use think\Db;
use think\Validate;

use Exception;

class RoleAction extends Action
{
    public static function list(array $param)
    {
        $param['limit'] = empty($param['limit']) ? config('app.limit') : $param['limit'];
        $order = parse_order($param['order']);
        $res = RoleModel::list($param , $order , $param['limit']);
        return self::success($res);
    }

    public static function add(array $param)
    {
        $validator=  Validate::make([
            'name' => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        $id = RoleModel::insertGetId(array_unit($param , [
            'name' ,
            'weight' ,
        ]));
        return self::success($id);
    }

    public static function edit(array $param)
    {
        $validator=  Validate::make([
            'id' => 'require' ,
            'name' => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        $m = RoleModel::findById($param['id']);
        if (empty($m)) {
            return self::error('未找到 id 对应项' , 404);
        }
        RoleModel::updateById($m->id , array_unit($param , [
            'name' ,
            'weight' ,
        ]));
        return self::success($m->id);
    }

    public static function del(array $param)
    {
        $validator=  Validate::make([
            'id_list' => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        $id_list = json_decode($param['id_list'] , true);
        if (empty($id_list)) {
            return self::error('请提供待删除项');
        }
        RoleModel::delByIds($id_list);
        return self::success('操作成功');
    }

    public static function all(array $param)
    {
        $res = RoleModel::getAll($param);
        return self::success($res);
    }

    public static function privilege(array $param)
    {
        $validator=  Validate::make([
            'id' => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        $res = RoleModel::getRouteById($param['id']);
        if (empty($res)) {
            return self::error('未找到给定的角色相关信息' , 404);
        }
        return self::success($res);
    }

    public static function allocate(array $param)
    {
        $validator=  Validate::make([
            'role_id' => 'require' ,
            'id_list' => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        $id_list = json_decode($param['id_list'] , true);
        if (empty($id_list)) {
            return self::error('请提供角色权限');
        }
        try {
            Db::startTrans();
            RoleRouteModel::delByRoleId($param['role_id']);
            foreach ($id_list as $v)
            {
                RoleRouteModel::insert([
                    'role_id' => $param['role_id'] ,
                    'route_id' => $v
                ]);
            }
            Db::commit();
            return self::success('操作成功');
        } catch(Exception $e) {
            throw $e;
        }
    }
}