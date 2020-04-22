<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/7/19
 * Time: 11:20
 */

namespace app\admin\util;


use function admin\obj_to_array;
use app\admin\lib\Category;
use app\admin\model\CategoryModel;

class CategoryUtil
{
    public static function all(bool $struct = false): array
    {
        $res = CategoryModel::getAll();
        $res = obj_to_array($res);
        $res = Category::childrens(0 , $res , [
            'id' => 'id' ,
            'p_id' => 'p_id' ,
        ] , false , $struct);
        return $res;
    }
}