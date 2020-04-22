<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/8/28
 * Time: 11:33
 */

namespace app\admin\controller;

use function admin\error;
use function admin\success;
use app\admin\action\RouteAction;

class Route extends Auth
{
    public function allForMenu()
    {
        $res = RouteAction::allForMenu();
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }
}