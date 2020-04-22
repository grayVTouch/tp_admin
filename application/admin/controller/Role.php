<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/7/18
 * Time: 18:46
 */

namespace app\admin\controller;


use function admin\array_to_obj;
use function admin\error;
use function admin\success;
use function admin\user;
use app\admin\action\RoleAction;
use app\admin\model\RoleModel;
use app\admin\model\RouteModel;
use app\admin\util\CategoryUtil;

class Role extends Auth
{
    public function listView()
    {
        return $this->fetch('list');
    }

    public function addView()
    {
        $this->assign([
            'mode' => 'add' ,
        ]);
        return $this->fetch('thing');
    }

    public function editView()
    {
        $param = $this->request->get();
        $param['id'] = $param['id'] ?? '';
        $m = RoleModel::findById($param['id']);
        if (empty($m)) {
            return error('未找到id对应记录' , 404);
        }
        $this->assign([
            'mode' => 'edit' ,
            'thing' => $m
        ]);
        return $this->fetch('thing');
    }

    public function list()
    {
        $param = $this->request->post();
        $param['order'] = $param['order'] ?? '';
        $param['limit'] = $param['limit'] ?? '';
        $res = RoleAction::list($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

    public function add()
    {
        $param = $this->request->post();
        $param['name'] = $param['name'] ?? '';
        $param['weight'] = $param['weight'] ?? '';
        $res = RoleAction::add($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

    public function edit()
    {
        $param = $this->request->post();
        $param['id'] = $param['id'] ?? '';
        $param['name'] = $param['name'] ?? '';
        $param['weight'] = $param['weight'] ?? '';
        $res = RoleAction::edit($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

    public function del()
    {
        $param = $this->request->post();
        $param['id_list'] = $param['id_list'] ?? '';
        $res = RoleAction::del($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

    public function all()
    {
        $param = $this->request->post();
        $res = RoleAction::all($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

    public function privilegeView()
    {
        $role_id = $this->request->get('id');
        $role = RoleModel::findById($role_id);
        if (empty($role)) {
            echo '未找到角色信息 <button click="window.history.go(-1)">返回上一页</button>';
        }
        $this->assign([
            'role' => $role
        ]);
        return $this->fetch('privilege');
    }

    public function privilege()
    {
        $param = $this->request->post();
        $param['id'] = $param['id'] ?? '';
        $res = RoleAction::privilege($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

    public function allocate()
    {
        $param = $this->request->post();
        $param['role_id'] = $param['role_id'] ?? '';
        $param['id_list'] = $param['id_list'] ?? '';
        $res = RoleAction::allocate($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

}