<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/7/18
 * Time: 18:46
 */

namespace app\admin\controller;


use function admin\error;
use function admin\success;
use app\admin\action\SystemMessageAction;
use app\admin\model\SystemMessageModel;
use app\admin\model\SystemMessageTypeModel;

class SystemMessage extends Auth
{
    public function listView()
    {
        return $this->fetch('list');
    }

    public function addView()
    {
        $type = SystemMessageTypeModel::getAll();
        $this->assign([
            'mode' => 'add' ,
            'type' => $type ,
        ]);
        return $this->fetch('thing');
    }

    public function editView()
    {
        $type = SystemMessageTypeModel::getAll();
        $param = $this->request->get();
        $param['id'] = $param['id'] ?? '';
            $m = SystemMessageModel::findById($param['id']);
        if (empty($m)) {
            return error('未找到id对应记录' , 404);
        }
        $this->assign([
            'mode' => 'edit' ,
            'thing' => $m ,
            'type' => $type ,
        ]);
        return $this->fetch('thing');
    }

    public function list()
    {
        $param = $this->request->post();
        $param['order'] = $param['order'] ?? '';
        $param['limit'] = $param['limit'] ?? '';
        $res = SystemMessageAction::list($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

    public function add()
    {
        $param = $this->request->post();
        $param['type'] = $param['type'] ?? '';
        $param['uid'] = $param['uid'] ?? '';
        $param['title'] = $param['title'] ?? '';
        $param['content'] = $param['content'] ?? '';
        $param['img'] = $param['img'] ?? '';
        $param['date'] = $param['date'] ?? '';
        $res = SystemMessageAction::add($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

    public function edit()
    {
        $param = $this->request->post();
        $param['id'] = $param['id'] ?? '';
        $param['type'] = $param['type'] ?? '';
        $param['uid'] = $param['uid'] ?? '';
        $param['title'] = $param['title'] ?? '';
        $param['content'] = $param['content'] ?? '';
        $param['img'] = $param['img'] ?? '';
        $param['date'] = $param['date'] ?? '';
        $res = SystemMessageAction::edit($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

    public function del()
    {
        $param = $this->request->post();
        $param['id_list'] = $param['id_list'] ?? '';
        $res = SystemMessageAction::del($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

}