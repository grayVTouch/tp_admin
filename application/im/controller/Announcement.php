<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/7/30
 * Time: 11:29
 */

namespace app\im\controller;


use function im\error;
use function im\success;
use app\im\action\AnnouncementAction;
use app\im\model\AnnouncementModel;
use app\im\util\ArticleTypeUtil;

class Announcement extends Auth
{
    public function listView()
    {
        $this->assign([
            'announcement_pos' => config('business.announcement_pos') ,
        ]);
        return $this->fetch('list');
    }

    public function addView()
    {
        $this->assign([
            'announcement_pos' => config('business.announcement_pos') ,
            'mode' => 'add'
        ]);
        return $this->fetch('thing');
    }

    public function editView()
    {
        $id = $this->request->get('id');
        $m = AnnouncementModel::findById($id);
        if (empty($m)) {
            return error('未找到 id 对应数据' , 404);
        }
        $this->assign([
            'mode'  => 'edit' ,
            'announcement_pos' => config('business.announcement_pos') ,
            'thing' => $m ,
        ]);
        return $this->fetch('thing');
    }

    public function list()
    {
        $param = $this->request->post();
        $param['id'] = $param['id'] ?? '';
        $param['article_type_id'] = $param['article_type_id'] ?? '';
        $param['order'] = $param['order'] ?? '';
        $param['limit'] = $param['limit'] ?? '';
        $res = AnnouncementAction::list($param);
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
        $param['pos'] = $param['pos'] ?? '';
        $param['text'] = $param['text'] ?? '';
        $param['weight'] = $param['weight'] ?? '';
        $res = AnnouncementAction::edit($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

    public function add()
    {
        $param = $this->request->post();
        $param['title'] = $param['title'] ?? '';
        $param['pos'] = $param['pos'] ?? '';
        $param['text'] = $param['text'] ?? '';
        $param['weight'] = $param['weight'] ?? '';
        $res = AnnouncementAction::add($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

    public function del()
    {
        $param = $this->request->post();
        $param['id_list'] = $param['id_list'] ?? '';
        $res = AnnouncementAction::del($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }
}