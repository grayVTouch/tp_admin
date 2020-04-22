<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/6/18
 * Time: 17:33
 */

namespace app\im\controller;


use app\im\middleware\UserAuth;
use think\Request;

class Auth extends Base
{
    protected $middleware = [
//        UserAuth::class ,
    ];

    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

}