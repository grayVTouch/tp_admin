<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/7/29
 * Time: 15:22
 */

namespace app\im\controller;


use function im\error;
use function im\success;
use app\im\action\FriendCircleInfoAction;

class FriendCircleInfo extends Auth
{
    // 修改朋友圈发布 can_publish
    public function updateCanPublish()
    {
        $param = $this->request->post();
        $param['id_list'] = $param['id_list'] ?? '';
        $param['can_publish'] = $param['can_publish'] ?? '';
        $res = FriendCircleInfoAction::updateCanPublish($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

    // 修改朋友圈评论 can_comment
    public function updateCanComment()
    {
        $param = $this->request->post();
        $param['id_list'] = $param['id_list'] ?? '';
        $param['can_comment'] = $param['can_comment'] ?? '';
        $res = FriendCircleInfoAction::updateCanComment($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }
}