<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/8/28
 * Time: 11:34
 */

namespace app\admin\action;

use function admin\array_to_obj;
use app\admin\model\RouteModel;
use app\admin\lib\Category;

class RouteAction extends Action
{
    public static function allForMenu()
    {
        $route = RouteModel::allForMenu();
        return self::success($route);
    }
}