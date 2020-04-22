<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/7/17
 * Time: 18:18
 */

namespace app\admin\controller;


class Index extends Auth
{
    public function indexView()
    {
        return $this->fetch('index');
    }
}