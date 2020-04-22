<?php
namespace app\index\controller;

class Index
{
    public function index()
    {
        return redirect('/admin/index/indexView');
    }

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }
}
