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
use app\im\action\FriendCircleCommentAction;

class FriendCircleComment extends Auth
{
    public function listView()
    {
        $this->assign([]);
        return $this->fetch('list');
    }

    public function list()
    {
        $param = $this->request->post();
        $param['id'] = $param['id'] ?? '';
        $param['article_type_id'] = $param['article_type_id'] ?? '';
        $param['order'] = $param['order'] ?? '';
        $param['limit'] = $param['limit'] ?? '';
        $res = FriendCircleCommentAction::list($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

    public function del()
    {
        $param = $this->request->post();
        $param['id_list'] = $param['id_list'] ?? '';
        $res = FriendCircleCommentAction::del($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }
}