<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/7/18
 * Time: 18:46
 */

namespace app\im\controller;


use function im\error;
use function im\success;
use app\im\action\ArticleTypeAction;
use app\im\model\ArticleTypeModel;
use app\im\util\ArticleTypeUtil;

class ArticleType extends Auth
{
    public function listView()
    {
        $article_type = ArticleTypeUtil::all(false);
        $this->assign([
            'article_type' => $article_type
        ]);
        return $this->fetch('list');
    }

    public function addView()
    {
        $article_type = ArticleTypeUtil::all(false);
        $this->assign([
            'mode' => 'add' ,
            'article_type' => $article_type ,
            'bool' => config('business.bool_str')
        ]);
        return $this->fetch('thing');
    }

    public function editView()
    {
        $param = $this->request->get();
        $param['id'] = $param['id'] ?? '';
        $m = ArticleTypeModel::findById($param['id']);
        if (empty($m)) {
            return error('未找到id对应记录' , 404);
        }
        $article_type = ArticleTypeUtil::all(false);
        $this->assign([
            'mode' => 'edit' ,
            'article_type' => $article_type ,
            'bool' => config('business.bool_str') ,
            'thing' => $m
        ]);
        return $this->fetch('thing');
    }

    public function list()
    {
        $param = $this->request->post();
        $res = ArticleTypeAction::list($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

    public function add()
    {
        $param = $this->request->post();
        $param['name'] = $param['name'] ?? '';
        $param['p_id'] = $param['p_id'] ?? '';
        $param['image'] = $param['image'] ?? '';
        $param['desc'] = $param['desc'] ?? '';
        $res = ArticleTypeAction::add($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

    public function edit()
    {
        $param = $this->request->post();
        $param['id'] = $param['id'] ?? '';
        $param['name'] = $param['name'] ?? '';
        $param['p_id'] = $param['p_id'] ?? '';
        $param['image'] = $param['image'] ?? '';
        $param['desc'] = $param['desc'] ?? '';
        $res = ArticleTypeAction::edit($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

    public function del()
    {
        $param = $this->request->post();
        $param['id_list'] = $param['id_list'] ?? '';
        $res = ArticleTypeAction::del($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

}