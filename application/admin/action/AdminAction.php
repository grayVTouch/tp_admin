<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/6/19
 * Time: 16:26
 */

namespace app\admin\action;

use function admin\array_unit;
use function admin\check_len;
use function admin\get_value;
use function admin\parse_order;
use function admin\user;
use app\admin\lib\Hash;
use app\admin\model\AdministratorModel;
use app\admin\model\OperationLogModel;
use app\admin\model\RoleModel;
use Exception;
use think\Db;
use think\facade\Session;
use think\Validate;

class AdminAction extends Action
{
    public static function logout()
    {
        Session::delete('user');
        return self::success();
    }

    public static function list(array $param)
    {
        $param['limit'] = empty($param['limit']) ? config('app.limit') : $param['limit'];
        $order = parse_order($param['order']);
        $res = AdministratorModel::list($param , $order , $param['limit']);
        return self::success($res);
    }

    public static function updateStatus(array $param)
    {
        $validator = Validate::make([
            'id_list' => 'require' ,
            'status' => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        $id_list = json_decode($param['id_list'] , true);
        if (empty($id_list)) {
            return self::error('请提供待待修改记录');
        }
        $range = [1,2,3];
        if (!in_array($param['status'] , $range)) {
            return self::error('不支持的状态类型');
        }
        try {
            Db::startTrans();
            $user = user();
            foreach ($id_list as $v)
            {
                $m = AdministratorModel::findById($v);
                if ($m->is_root && $user->id != $m->id) {
                    Db::rollback();
                    return self::error('包含超级管理员用户！您没有权限操作' , 403);
                }
                if (empty($m)) {
                    Db::rollback();
                    return self::error(sprintf('未找到 id = %s 对应数据，请提供正确数据后重试' , $v) , 404);
                }
                AdministratorModel::updateById($v , array_unit($param , [
                    'status'
                ]));
                // 记录操作日志
                OperationLogModel::u_insertGetId($user->id , 'common' , sprintf('修改平台用户【%d】状态由%s【%d】到 %s【%d】' , $v , $m->status_explain , $m->status , get_value('business.user_status' , $param['status']) , $param['status']));
            }
            Db::commit();
            return self::success('操作成功');
        } catch(Exception $e) {
            Db::rollback();
            throw $e;
        }
    }

    public static function updateRole(array $param)
    {
        $validator = Validate::make([
            'id' => 'require' ,
            'role_id' => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        $user = AdministratorModel::findById($param['id']);
        if (empty($user)) {
            return self::error('未找到用户' , 404);
        }
        $role = RoleModel::findById($param['role_id']);
        if (empty($role)) {
            return self::error('未找到该角色' , 404);
        }
        $login_user = user();
        if ($user->is_root && ($login_user->id != $user->id)) {
            return self::error('不允许修改其他超级管理员' , 403);
        }
        AdministratorModel::updateById($user->id , array_unit($param , [
            'role_id' ,
        ]));
        return self::success('操作成功');
    }

    public static function add(array $param)
    {
        $validator = Validate::make([
            'username' => 'require' ,
            'password' => 'require' ,
            'confirm_password' => 'require' ,
            'role_id' => 'require' ,
            'status' => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        if (!check_len($param['password'] , 6 , 'lte')) {
            return self::error('密码长度至少 6 位');
        }
        if ($param['password'] != $param['confirm_password']) {
            return self::error('两次输入的密码不一致');
        }
        // 检查用户名是否重复
        $user = AdministratorModel::findByUsername($param['username']);
        if (!empty($user)) {
            return self::error('用户名已经被使用');
        }
        $param['password'] = Hash::make($param['password']);
        // 检查角色是否存在
        $role = RoleModel::findById($param['role_id']);
        if (empty($role)) {
            return self::error('角色不存在' , 404);
        }
        try {
            AdministratorModel::insertGetId(array_unit($param , [
                'username' ,
                'password' ,
                'role_id' ,
                'avatar' ,
                'status' ,
            ]));

        } catch(Exception $e) {
            throw $e;
        }
        return self::success('操作成功');
    }

    public static function edit(array $param)
    {
        $validator = Validate::make([
            'id' => 'require' ,
            'username' => 'require' ,
            'role_id' => 'require' ,
            'status' => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        $admin = AdministratorModel::findById($param['id']);
        if (empty($admin)) {
            return self::error('用户不存在' , 404);
        }
        if (!empty($param['password']) && !check_len($param['password'] , 6 , 'lte')) {
            return self::error('密码长度至少 6 位');
        }
        if (!empty($param['password']) && ($param['password'] != $param['confirm_password'])) {
            return self::error('两次输入的密码不一致');
        }
        // 检查用户名是否重复
        $is_repeat = AdministratorModel::isRepeatByUsername($param['id'] , $param['username']);
        if ($is_repeat) {
            return self::error('用户名已经被使用');
        }
        $cur_admin = user();
        if ($admin->is_root && ($admin->id != $cur_admin->id)) {
            return self::error('您没有权限修改其他 root 用户' , 403);
        }
        $param['password'] = empty($param['password']) ? $admin->password : Hash::make($param['password']);
        $param['avatar'] = empty($param['avatar']) ? $admin->avatar : $param['avatar'];
        AdministratorModel::updateById($param['id'] , array_unit($param , [
            'username' ,
            'password' ,
            'role_id' ,
            'avatar' ,
            'status' ,
        ]));
        return self::success('操作成功');
    }

    public static function del(array $param)
    {
        $validator = Validate::make([
            'id_list' => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        $id_list = json_decode($param['id_list'] , true);
        if (empty($id_list)) {
            return self::error('请提供待删除的项');
        }
        try {
            Db::startTrans();
            foreach ($id_list as $v)
            {
                $user = AdministratorModel::findById($v);
                if ($user->is_root) {
                    Db::rollback();
                    return self::error('您没有权限删除 root 用户' , 403);
                }
            }
            AdministratorModel::delByIds($id_list);
            Db::commit();
            return self::success('操作成功');
        } catch(Exception $e) {
            throw $e;
        }
    }
}