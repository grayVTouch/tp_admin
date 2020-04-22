<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/7/18
 * Time: 16:14
 */

namespace app\im\model;


class OperationLogModel extends Model
{
    protected $table = 'cq_operation_log';

    public static function u_insertGetId(int $user_id , string $type = 'common' , string $log = '')
    {
        return self::insertGetId([
            'user_id' => $user_id ,
            'type' => $type ,
            'log' => $log
        ]);
    }
}