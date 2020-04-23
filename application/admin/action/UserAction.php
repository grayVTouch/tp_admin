<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/7/18
 * Time: 11:53
 */

namespace app\admin\action;


use function admin\array_unit;
use function admin\get_value;
use function admin\parse_order;
use function admin\user;
use app\admin\model\OperationLogModel;
use app\admin\model\UserModel;
use think\Db;
use think\facade\Session;
use think\Validate;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use Exception;

class UserAction extends Action
{
    public static function logout()
    {
        Session::delete('user');
        return self::success();
    }
}