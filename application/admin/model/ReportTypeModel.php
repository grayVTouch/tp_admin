<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/7/18
 * Time: 11:56
 */

namespace app\admin\model;


use function admin\convert_obj;
use function admin\get_image_url;
use function admin\get_value;
use function admin\image_url;

class ReportTypeModel extends Model
{
    protected $table = 'cq_report_type';

    public static function single($m = null)
    {
        if (empty($m)) {
            return ;
        }
    }
}