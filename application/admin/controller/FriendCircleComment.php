<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/7/30
 * Time: 11:29
 */

namespace app\admin\controller;


use function admin\error;
use function admin\success;

class FriendCircleComment extends Auth
{
    public function listView()
    {
        return $this->fetch('list');
    }
}