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
use app\admin\action\CommunityAnnounceAction;
use app\admin\model\CommunityAnnounceModel;

class CommunityAnnounce extends Auth
{
    public function listView()
    {
        return $this->fetch('list');
    }

    public function addView()
    {
        $this->assign([
            'mode' => 'add' ,
            'status' => config('business.community_status') ,
            'type' => config('business.community_announce_type') ,
        ]);
        return $this->fetch('thing');
    }

    public function editView()
    {
        $param = $this->request->get();
        $param['id'] = $param['id'] ?? '';
        $m = CommunityAnnounceModel::findById($param['id']);
        if (empty($m)) {
            return error('未找到id对应记录' , 404);
        }
        $this->assign([
            'mode' => 'edit' ,
            'status' => config('business.community_status') ,
            'type' => config('business.community_announce_type') ,
            'thing' => $m
        ]);
        return $this->fetch('thing');
    }

    public function list()
    {
        $param = $this->request->post();
        $param['order'] = $param['order'] ?? '';
        $param['limit'] = $param['limit'] ?? '';
        $res = CommunityAnnounceAction::list($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

    public function add()
    {
        $param = $this->request->post();
        $param['title'] = $param['title'] ?? '';
        $param['content'] = $param['content'] ?? '';
        $param['status'] = $param['status'] ?? '';
        $param['type'] = $param['type'] ?? '';
        $res = CommunityAnnounceAction::add($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

    public function edit()
    {
        $param = $this->request->post();
        $param['id'] = $param['id'] ?? '';
        $param['title'] = $param['title'] ?? '';
        $param['content'] = $param['content'] ?? '';
        $param['status'] = $param['status'] ?? '';
        $param['type'] = $param['type'] ?? '';
        $res = CommunityAnnounceAction::edit($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

    public function del()
    {
        $param = $this->request->post();
        $param['id_list'] = $param['id_list'] ?? '';
        $res = CommunityAnnounceAction::del($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

}