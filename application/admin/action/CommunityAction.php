<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/7/18
 * Time: 11:53
 */

namespace app\admin\action;


use function admin\array_unit;
use function admin\parse_order;
use app\admin\model\CommunityModel;
use think\Db;
use think\Validate;

use Exception;

class CommunityAction extends Action
{
    public static function list(array $param)
    {
        $param['limit'] = empty($param['limit']) ? config('app.limit') : $param['limit'];
//        $param['limit'] = 4;
        $order = parse_order($param['order']);
        $res = CommunityModel::list($param , $order , $param['limit']);
        return self::success($res);
    }

    public static function add(array $param)
    {
        $validator=  Validate::make([
            'name' => 'require' ,
            'type' => 'require' ,
            'status' => 'require' ,
            'is_app' => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        $id = CommunityModel::insertGetId(array_unit($param , [
            'name' ,
            'pic' ,
            'url' ,
            'status' ,
            'type' ,
            'download_url' ,
            'is_app' ,
            'android_download_url' ,
            'andorid_url' ,
        ]));
        return self::success($id);
    }

    public static function edit(array $param)
    {
        $validator=  Validate::make([
            'id' => 'require' ,
            'name' => 'require' ,
            'type' => 'require' ,
            'status' => 'require' ,
            'is_app' => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        $m = CommunityModel::findById($param['id']);
        if (empty($m)) {
            return self::error('未找到 id 对应项' , 404);
        }
        $param['pic'] = empty($param['pic']) ? $m->pic : $param['pic'];
        CommunityModel::updateById($m->id , array_unit($param , [
            'name' ,
            'pic' ,
            'url' ,
            'status' ,
            'type' ,
            'download_url' ,
            'is_app' ,
            'android_download_url' ,
            'andorid_url' ,
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
        CommunityModel::delByIds($id_list);
        return self::success('操作成功');
    }
}