<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/7/19
 * Time: 15:46
 */

namespace app\im\action;


use function im\array_unit;
use function im\format_path;
use function im\image_url;
use function im\parse_order;
use app\im\model\ArticleContentModel;
use app\im\model\ArticleModel;
use Exception;
use think\Db;
use think\Validate;

class ArticleAction extends Action
{
    public static function list(array $param)
    {
        $param['limit'] = empty($param['limit']) ? config('app.limit') : $param['limit'];
        $order = parse_order($param['order']);
        $res = ArticleModel::list($param , $order , $param['limit']);
        return self::success($res);
    }

    public static function edit(array $param)
    {
        $validator=  Validate::make([
            'id' => 'require' ,
            'title' => 'require' ,
            'article_type_id' => 'require' ,
            'hidden' => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        $m = ArticleModel::findById($param['id']);
        if (empty($m)) {
            return self::error('未找到 id 对应项' , 404);
        }
        $param['thumb'] = empty($param['thumb']) ? $m->thumb : $param['thumb'];
        try {
            Db::startTrans();
            ArticleModel::updateById($param['id'] , array_unit($param , [
                'title' ,
                'article_type_id' ,
                'thumb' ,
                'source' ,
                'hidden' ,
                'weight' ,
            ]));
            ArticleContentModel::updateByArticleId($param['id'] , $param['content']);
            Db::commit();
            return self::success('操作成功');
        } catch(Exception $e) {
            Db::rollback();
            throw $e;
        }
    }

    public static function add(array $param)
    {
        $validator=  Validate::make([
            'title' => 'require' ,
            'article_type_id' => 'require' ,
            'hidden' => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        $param['weight'] = empty($param['weight']) ? config('app.weight') : $param['weight'];
        try {
            Db::startTrans();
            $id = ArticleModel::insertGetId(array_unit($param , [
                'title' ,
                'article_type_id' ,
                'thumb' ,
                'source' ,
                'hidden' ,
                'weight' ,
            ]));
            ArticleContentModel::insertGetId([
                'article_id' => $id ,
                'content' => $param['content']
            ]);
            Db::commit();
            return self::success('操作成功');
        } catch(Exception $e) {
            Db::rollback();
            throw $e;
        }

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
        ArticleModel::delByIds($id_list);
        return self::success('操作成功');
    }


}