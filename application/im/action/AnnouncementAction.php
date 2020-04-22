<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/7/19
 * Time: 15:46
 */

namespace app\im\action;


use function im\array_unit;
use function im\parse_order;
use app\im\model\ArticleContentModel;
use app\im\model\AnnouncementModel;
use Exception;
use think\Db;
use think\Validate;

class AnnouncementAction extends Action
{
    public static function list(array $param)
    {
        $param['limit'] = empty($param['limit']) ? config('app.limit') : $param['limit'];
        $order = parse_order($param['order']);
        $res = AnnouncementModel::list($param , $order , $param['limit']);
        return self::success($res);
    }

    public static function edit(array $param)
    {
        $validator=  Validate::make([
            'id' => 'require' ,
            'title' => 'require' ,
            'pos' => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        $m = AnnouncementModel::findById($param['id']);
        if (empty($m)) {
            return self::error('未找到 id 对应项' , 404);
        }
        AnnouncementModel::updateById($param['id'] , array_unit($param , [
            'title' ,
            'pos' ,
            'text' ,
            'weight' ,
        ]));
        return self::success('操作成功');
    }

    public static function add(array $param)
    {
        $validator=  Validate::make([
            'title' => 'require' ,
            'pos' => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        $param['weight'] = empty($param['weight']) ? config('app.weight') : $param['weight'];
        AnnouncementModel::insertGetId(array_unit($param , [
            'title' ,
            'pos' ,
            'text' ,
            'weight' ,
        ]));
        return self::success('操作成功');
    }

    // 删除
    public static function del(array $param)
    {
        $validator = Validate::make([
            'id_list' => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        $id_list = json_decode($param['id_list'] , true);
        if (empty($id_list)) {
            return self::error('请提供待删除的项');
        }
        AnnouncementModel::delByIds($id_list);
        return self::success('操作成功');
    }


}