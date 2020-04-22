<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/6/19
 * Time: 16:25
 */

namespace app\admin\controller;


use function admin\error;
use function admin\success;
use app\admin\action\AdminAction;
use app\admin\model\AdministratorModel;
use app\admin\model\RoleModel;

class Admin extends Auth
{
    public function logout()
    {
        $res = AdminAction::logout();
        if ($res['code'] != 200) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

    public function listView()
    {
        $role = RoleModel::getAll();
        $this->assign([
            'role' => $role
        ]);
        return $this->fetch('list');
    }

    public function editView()
    {
        $id = $this->request->get('id');
        $res = AdministratorModel::findById($id);
        if (empty($res)) {
            return error('未找到用户' , 404);
        }
        $role = RoleModel::getAll();
        $status = config('business.admin_status');
        $this->assign([
            'mode' => 'edit' ,
            'role' => $role ,
            'thing' => $res ,
            'status' => $status ,
        ]);
        return $this->fetch('thing');
    }

    public function addView()
    {
        $role = RoleModel::getAll();
        $status = config('business.admin_status');
        $this->assign([
            'mode' => 'add' ,
            'role' => $role ,
            'status' => $status ,
        ]);
        return $this->fetch('thing');
    }

    public function list()
    {
        $param = $this->request->post();
        $param['id'] = $param['id'] ?? '';
        $param['username'] = $param['username'] ?? '';
        $param['role_id'] = $param['role_id'] ?? '';
        $param['order'] = $param['order'] ?? '';
        $param['limit'] = $param['limit'] ?? '';
        $res = AdminAction::list($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

    public function updateStatus()
    {
        $param = $this->request->post();
        $param['id_list'] = $param['id_list'] ?? '';
        $param['status'] = $param['status'] ?? '';
        $res = AdminAction::updateStatus($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

    public function updateRole()
    {
        $param = $this->request->post();
        $param['role_id'] = $param['role_id'] ?? '';
        $res = AdminAction::updateRole($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

    public function add()
    {
        $param = $this->request->post();
        $param['username'] = $param['username'] ?? '';
        $param['password'] = $param['password'] ?? '';
        $param['confirm_password'] = $param['confirm_password'] ?? '';
        $param['avatar'] = $param['avatar'] ?? '';
        $param['role_id'] = $param['role_id'] ?? '';
        $param['status'] = $param['status'] ?? '';
        $res = AdminAction::add($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

    public function edit()
    {
        $param = $this->request->post();
        $param['id'] = $param['id'] ?? '';
        $param['username'] = $param['username'] ?? '';
        $param['password'] = $param['password'] ?? '';
        $param['confirm_password'] = $param['confirm_password'] ?? '';
        $param['avatar'] = $param['avatar'] ?? '';
        $param['role_id'] = $param['role_id'] ?? '';
        $param['status'] = $param['status'] ?? '';
        $res = AdminAction::edit($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

    public function del()
    {
        $param = $this->request->post();
        $param['id_list'] = $param['id_list'] ?? '';
        $res = AdminAction::del($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }


}