<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/7/19
 * Time: 15:44
 */

namespace app\admin\controller;


use function admin\error;
use function admin\get_extension;
use function admin\random;
use function admin\success;
use app\admin\action\ImageAction;
use app\admin\lib\Http;
use CURLFile;

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

    public function iview_image()
    {
        $image = $this->request->file('image');
        $res = ImageAction::iview_image($image);
        if ($res['code'] != 0) {
            return error($res['data'] , $res['code']);
        }
        return success($res['data']);
    }

    // 返回符合 wang-editor 编辑器多图上传要求的数据
    public function wangEditor()
    {
        $image = $_FILES['image'] ?? [];
        $res = [];
        $oss_for_upload = config('app.oss_for_upload');
        foreach ($image['tmp_name'] as $k => $v)
        {
            $tmp_name = $image['tmp_name'][$k];
            $mime = $image['type'][$k];
            $size = $image['size'][$k];
            $name = $image['name'][$k];
            $error = $image['error'][$k];
            $extension = get_extension($name);
            $filename = random(12 , 'mixed' , true);
            $filename = sprintf('%s.%s' , $filename , $extension);
            $file = new CURLFile($tmp_name , $mime , $filename);
            $response = Http::post($oss_for_upload , [
                'data' => [
                    'file' => $file
                ] ,
            ]);
            if (empty($response)) {
                return error('CURL 请求发送失败，请检查自身网络 或 对方服务器是否在线' , 500);
            }
            $response = json_decode($response , true);
            if ($response['code'] != 0) {
                return error('远程接口返回错误信息：' . $response['data'] , 500);
            }
            $res[] = $response['data'];

        }
        return json([
            'errno' => 0 ,
            'data' => $res
        ]);
    }

    public function layuiEditImageUpload()
    {
        $file = $_FILES['file'] ?? null;
        if (empty($file)) {
            return json_encode([
                'code' => 400 ,
                'msg' => '请提供待上传的图片' ,
            ]);
        }
        $url = 'http://upload.moeddcoin.vip:81/upfull?token=lucky';
        $extension = get_extension($file['name']);
        $filename = random(12 , 'mixed' , true);
        $filename = sprintf('%s.%s' , $filename , $extension);
        $curl_file = new CURLFile($file['tmp_name'] , $file['type'] , $filename);
        $res = Http::post($url , [
            'data' => [
                'file' => $curl_file
            ] ,
        ]);
        if (empty($res)) {
            return json_encode([
                'code' => 500 ,
                'msg' => '网络问题 或 远程服务器没有返回任何响应' ,
            ]);
        }
        $res = json_decode($res , true);
        if ($res['code'] != 0) {
            return json_encode([
                'code' => 500 ,
                'msg' => $res['data'] ,
            ]);
        }
        return json_encode([
            'code' => 0 ,
            'msg' => '' ,
            'data' => [
                'src' => $res['data'] ,
                'title' => $filename ,
            ]
        ]);
    }

}