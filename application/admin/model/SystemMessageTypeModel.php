<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/7/18
 * Time: 11:56
 */

namespace app\admin\model;


use function admin\convert_obj;
use function admin\get_value;
use function admin\image_url;

class SystemMessageTypeModel extends Model
{
    protected $table = 'cq_system_message_type';

    // 检查 type 是否存在
    public static function findByType(int $type)
    {
        $res = self::where('type' , $type)
            ->find();
        self::single($res);
        return $res;
    }
}