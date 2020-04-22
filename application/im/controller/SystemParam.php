<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/7/24
 * Time: 17:18
 */

namespace app\im\controller;


use function im\error;
use function im\success;
use app\im\action\SystemParamAction;
use app\im\model\SystemParamModel;

class SystemParam extends Auth
{
    public function listView()
    {
        $this->assign([
        ]);
        return $this->fetch('list');
    }

    public function editView()
    {
        $id = $this->request->get('id');
        $m = SystemParamModel::findById($id);
        if (empty($m)) {
            return error('未找到 id 对应数据' , 404);
        }
        $bool = config('business.bool');
        $this->assign([
            'mode'  => 'edit' ,
            'bool'  => $bool ,
            'thing' => $m ,
        ]);
        return $this->fetch('thing');
    }

    public function addView()
    {
        $bool = config('business.bool');
        $this->assign([
            'mode'      => 'add' ,
            'bool'  => $bool ,
        ]);
        return $this->fetch('thing');
    }

    public function list()
    {
        $param = $this->request->post();
        $param['id'] = $param['id'] ?? '';
        $param['order'] = $param['order'] ?? '';
        $param['limit'] = $param['limit'] ?? '';
        $res = SystemParamAction::list($param);
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
        $param['key'] = $param['key'] ?? '';
        $param['value'] = $param['value'] ?? '';
        $param['desc'] = $param['desc'] ?? '';
        $res = SystemParamAction::edit($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

    public function add()
    {
        $param = $this->request->post();
        $param['name'] = $param['name'] ?? '';
        $param['key'] = $param['key'] ?? '';
        $param['value'] = $param['value'] ?? '';
        $param['desc'] = $param['desc'] ?? '';
        $res = SystemParamAction::add($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

    public function del()
    {
        $param = $this->request->post();
        $param['id_list'] = $param['id_list'] ?? '';
        $res = SystemParamAction::del($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }


}