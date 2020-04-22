<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/7/18
 * Time: 11:53
 */

namespace app\im\action;


use function im\array_unit;
use function im\get_value;
use function im\obj_to_array;
use function im\parse_order;
use function im\user;
use app\im\lib\Category;
use app\im\model\OperationLogModel;
use app\im\model\ArticleTypeModel;
use think\Db;
use think\Validate;

use Exception;

class ArticleTypeAction extends Action
{
    public static function list(array $param)
    {
        $res = ArticleTypeModel::getAll();
        $res = obj_to_array($res);
        $res = Category::childrens(0 , $res , [
            'id' => 'id' ,
            'p_id' => 'p_id' ,
        ] , false , false);
        return self::success($res);
    }

    public static function add(array $param)
    {
        $validator=  Validate::make([
            'name' => 'require' ,
            'p_id' => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        $param['weight'] = empty($param['weight']) ? config('app.weight') : $param['weight'];
        $id = ArticleTypeModel::insertGetId(array_unit($param , [
            'name' ,
            'p_id' ,
            'weight' ,
            'hidden' ,
        ]));
        return self::success($id);
    }

    public static function edit(array $param)
    {
        $validator=  Validate::make([
            'id' => 'require' ,
            'name' => 'require' ,
            'p_id' => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        $m = ArticleTypeModel::findById($param['id']);
        if (empty($m)) {
            return self::error('未找到 id 对应项' , 404);
        }
        ArticleTypeModel::updateById($m->id , array_unit($param , [
            'name' ,
            'p_id' ,
            'weight' ,
            'hidden' ,
        ]));
        return self::success($m->id);
    }

    public static function del(array $param)
    {
        $validator=  Validate::make([
            'id_list' => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        $id_list = json_decode($param['id_list'] , true);
        if (empty($id_list)) {
            return self::error('请提供待删除项');
        }
        $del = function(array $id_list) use(&$del){
            ArticleTypeModel::delByIds($id_list);
            foreach ($id_list as $v)
            {
                $next_id_list = ArticleTypeModel::getIdByPId($v);
                if (!empty($next_id_list)) {
                    $del($next_id_list);
                }
            }
        };
        try {
            Db::startTrans();
            $del($id_list);
            Db::commit();
            return self::success('操作成功');
        } catch(Exception $e) {
            Db::rollback();
            throw $e;
        }
    }

}