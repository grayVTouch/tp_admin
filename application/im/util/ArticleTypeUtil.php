<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/7/19
 * Time: 11:20
 */

namespace app\im\util;


use function im\obj_to_array;
use app\im\lib\Category;
use app\im\model\ArticleTypeModel;

class ArticleTypeUtil
{
    public static function all(bool $struct = false): array
    {
        $res = ArticleTypeModel::getAll();
        $res = obj_to_array($res);
        $res = Category::childrens(0 , $res , [
            'id' => 'id' ,
            'p_id' => 'p_id' ,
        ] , false , $struct);
        return $res;
    }
}