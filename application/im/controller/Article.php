<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/7/30
 * Time: 11:29
 */

namespace app\im\controller;


use function im\error;
use function im\success;
use app\im\action\ArticleAction;
use app\im\model\ArticleModel;
use app\im\util\ArticleTypeUtil;

class Article extends Auth
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
            'article_type' => $article_type ,
            'bool' => config('business.bool_str') ,
            'mode' => 'add'
        ]);
        return $this->fetch('thing');
    }

    public function editView()
    {
        $id = $this->request->get('id');
        $m = ArticleModel::findById($id);
        if (empty($m)) {
            return error('未找到 id 对应数据' , 404);
        }
        $article_type = ArticleTypeUtil::all(false);
        $this->assign([
            'mode'  => 'edit' ,
            'article_type' => $article_type ,
            'bool' => config('business.bool_str') ,
            'thing' => $m ,
        ]);
        return $this->fetch('thing');
    }

    public function list()
    {
        $param = $this->request->post();
        $param['id'] = $param['id'] ?? '';
        $param['article_type_id'] = $param['article_type_id'] ?? '';
        $param['order'] = $param['order'] ?? '';
        $param['limit'] = $param['limit'] ?? '';
        $res = ArticleAction::list($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

    public function edit()
    {
        $param = $this->request->post();
        $param['id'] = $param['id'] ?? '';
        $param['title'] = $param['title'] ?? '';
        $param['thumb'] = $param['thumb'] ?? '';
        $param['content'] = $param['content'] ?? '';
        $param['hidden'] = $param['hidden'] ?? '';
        $param['source'] = $param['source'] ?? '';
        $param['weight'] = $param['weight'] ?? '';
        $res = ArticleAction::edit($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

    public function add()
    {
        $param = $this->request->post();
        $param['title'] = $param['title'] ?? '';
        $param['article_type_id'] = $param['article_type_id'] ?? '';
        $param['thumb'] = $param['thumb'] ?? '';
        $param['content'] = $param['content'] ?? '';
        $param['hidden'] = $param['hidden'] ?? '';
        $param['source'] = $param['source'] ?? '';
        $param['weight'] = $param['weight'] ?? '';
        $res = ArticleAction::add($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

    public function del()
    {
        $param = $this->request->post();
        $param['id_list'] = $param['id_list'] ?? '';
        $res = ArticleAction::del($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }
}