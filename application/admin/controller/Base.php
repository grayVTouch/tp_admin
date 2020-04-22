<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/6/18
 * Time: 16:49
 */

namespace app\admin\controller;


use function admin\obj_to_array;
use function admin\user;
use app\admin\model\RouteModel;
use app\admin\lib\Category;
use Exception;
use think\facade\View;
use ReflectionClass;
use think\Controller;
use think\Request;

class Base extends Controller
{
    // 当前路由
    protected $route;

    /**
     * 中间件
     *
     * @var array
     */
    protected $middleware = [];

    /**
     * 用户权限
     *
     * @var
     */
    protected $priv = [];

    /**
     * @var \think\Request
     */
    protected $request;

    /**
     * 工造函数
     * @param Request $request
     * @throws \ReflectionException
     */
    public function __construct(Request $request)
    {
        $class = new ReflectionClass(parent::class);
        if ($class->hasMethod('__construct')) {
            // 如果有父级构造函数，那么调用
            parent::__construct();
        }
        // 做初始化操作
        $this->request = $request;
    }

    /**
     * 视图渲染重写方法，提供一些预定义视图变量
     *
     * @param string $template
     * @param array $vars
     * @param array $config
     * @return mixed
     * @throws Exception
     */
    public function fetch($template = '', $vars = [], $config = [])
    {
        // 解析当前路由
        $this->parseRoute();
        if (!empty($this->route)) {
            // 未在路由表里面找到相关路由信息的时候，说明其是简略视图
            // 或则不希望被 赋予预定义视图变量
            // 所以，这边仅针对可配置权限的视图进行赋值
            $this->share();
            // 登录视图共享变量
            $this->logined();
        }
        // 渲染视图
        return parent::fetch($template , $vars , $config);
    }

    private function parseRoute()
    {
        $path = $this->request->path();
        $path = ltrim($path , '/');
        $path = sprintf('/%s' , $path);
        $route = RouteModel::findByRoute($path);
        $this->route = $route;
    }

    /**
     * 视图共享变量
     *
     * @return void
     */
    private function share()
    {
        $mca = $this->mca();
        $module_url = config('app.module_url');
        $ctrl_url = sprintf('/%s/%s' , $mca['module'] , $mca['controller']);
        $ctrl_url = strtolower($ctrl_url);
        $ctrl_res_url = sprintf('%s/%s' , $module_url , $mca['controller']);
        $ctrl_res_url = strtolower($ctrl_res_url);
        $os = config('app.os');

        View::share('os'    , $os);
        View::share('logo' , config('app.logo'));
        View::share('version' , config('app.version'));
        View::share('static_url' , config('app.static_url'));
        View::share('module_url' , $module_url);
        View::share('plugin_url' , config('app.plugin_url'));
        View::share('public_url' , config('app.public_url'));
        View::share('ctrl_res_url' , $ctrl_res_url);
        // 控制器 url
        View::share('ctrl_url' , $ctrl_url);
        View::share('module' , $mca['module']);
        View::share('controller' , $mca['controller']);
        View::share('action' , $mca['action']);
    }

    /**
     * 登录后用户视图共享变量
     *
     * @return void
     */
    private function logined()
    {
        $user = user();
        if (empty($user)) {
            return;
        }

        $priv   = obj_to_array($user->priv);
        $this->priv = $priv;
        $priv = Category::childrens(0 , $priv , [
            'id'    => 'id' ,
            'p_id'  => 'p_id'
        ]);
        $position = $this->position();
        // 仅在登录状态下赋值
        View::share('priv'  , $priv);
        View::share('position'  , $position);
        View::share('top'  , $position[0] ?? null);
        View::share('sec'  , $position[1] ?? null);
        View::share('cur'  , $position[count($position) - 1] ?? []);
        View::share('user'  , $user);
    }

    /**
     * 模块 + 控制器 + 动作
     *
     * @return array
     */
    private function mca()
    {
        $path   = $this->request->path();
        $res    = explode('/' , $path);
        $res[0] = $res[0] ?? 'index';
        $res[1] = $res[1] ?? 'index';
        $res[2] = $res[2] ?? 'index';
        return [
            'module'        => lcfirst($res['0']) ,
            'controller'    => ucfirst($res['1']) ,
            'action'        => lcfirst($res['2']) ,
        ];
    }

    /**
     * 当前位置
     *
     * @return array|mixed
     */
    private function position()
    {
        $res = Category::parents($this->route->id , $this->priv , [
            'id'    => 'id' ,
            'p_id'  => 'p_id' ,
        ] , true , false);
        return $res;
    }
}