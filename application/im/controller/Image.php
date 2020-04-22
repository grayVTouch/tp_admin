<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/7/19
 * Time: 15:44
 */

namespace app\im\controller;


use function im\error;
use function im\image_url;
use function im\success;
use app\im\action\ImageAction;
use app\im\model\ImageModel;

class Image extends Auth
{
    // layui 图片上传
    public function layui_image()
    {
        $image = $this->request->file('image');
        $res = ImageAction::layui_image($image);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

    // 返回符合 wang-editor 编辑器多图上传要求的数据
    public function wangEditor()
    {
        $image = $this->request->file('image');
        $res = [];
        $upload_dir = config('app.upload_dir');
        foreach ($image as $v)
        {
            $info = $v->validate([
                'ext' => 'jpg,png,jpeg,gif,bmp' ,
                'size' => 50 * 1024 * 1024 ,
            ])->move($upload_dir);
            if ($info) {
                $path = $info->getSaveName();
                $url = image_url($path);
                $res[] = $url;
            }
        }
        return json([
            'errno' => 0 ,
            'data' => $res
        ]);
    }



    public function listView()
    {
        $this->assign([
        ]);
        return $this->fetch('list');
    }

    public function editView()
    {
        $id = $this->request->get('id');
        $m = ImageModel::findById($id);
        if (empty($m)) {
            return error('未找到 id 对应数据' , 404);
        }
        $image_pos = config('business.image_pos');
        $this->assign([
            'mode'  => 'edit' ,
            'image_pos'  => $image_pos ,
            'thing' => $m ,
        ]);
        return $this->fetch('thing');
    }

    public function addView()
    {
        $image_pos = config('business.image_pos');
        $this->assign([
            'mode'      => 'add' ,
            'image_pos'  => $image_pos ,
        ]);
        return $this->fetch('thing');
    }

    public function list()
    {
        $param = $this->request->post();
        $param['id'] = $param['id'] ?? '';
        $param['order'] = $param['order'] ?? '';
        $param['limit'] = $param['limit'] ?? '';
        $res = ImageAction::list($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

    public function edit()
    {
        $param = $this->request->post();
        $param['id'] = $param['id'] ?? '';
        $param['pos'] = $param['pos'] ?? '';
        $param['path'] = $param['path'] ?? '';
        $param['link'] = $param['link'] ?? '';
        $param['weight'] = $param['weight'] ?? '';
        $res = ImageAction::edit($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

    public function add()
    {
        $param = $this->request->post();
        $param['pos'] = $param['pos'] ?? '';
        $param['path'] = $param['path'] ?? '';
        $param['link'] = $param['link'] ?? '';
        $param['weight'] = $param['weight'] ?? '';
        $res = ImageAction::add($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

    public function del()
    {
        $param = $this->request->post();
        $param['id_list'] = $param['id_list'] ?? '';
        $res = ImageAction::del($param);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }
}