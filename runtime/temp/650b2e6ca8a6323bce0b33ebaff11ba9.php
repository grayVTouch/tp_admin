<?php /*a:2:{s:68:"D:\work\code\mchat_gamming_adm\application\admin\view\coin\list.html";i:1568109251;s:70:"D:\work\code\mchat_gamming_adm\application\admin\view\public\base.html";i:1566960893;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlentities($top['cn']); ?>-<?php echo htmlentities($cur['cn']); ?></title>
    <link rel="stylesheet" href="<?php echo htmlentities($plugin_url); ?>/layui/css/layui.css?version=<?php echo htmlentities($version); ?>">
    <link rel="stylesheet" href="<?php echo htmlentities($module_url); ?>/public/css/base.css?version=<?php echo htmlentities($version); ?>">
    
<link rel="stylesheet" href="<?php echo htmlentities($public_url); ?>/css/list.css?version=<?php echo htmlentities($version); ?>">

</head>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <div class="layui-logo"><?php echo htmlentities($os['name']); ?></div>
        <!--&lt;!&ndash; 头部区域（可配合layui已有的水平导航） &ndash;&gt;-->
        <!--<ul class="layui-nav layui-layout-left">-->
            <!--<li class="layui-nav-item"><a href="">控制台</a></li>-->
            <!--<li class="layui-nav-item"><a href="">商品管理</a></li>-->
            <!--<li class="layui-nav-item"><a href="">用户</a></li>-->
            <!--<li class="layui-nav-item">-->
                <!--<a href="javascript:;">其它系统</a>-->
                <!--<dl class="layui-nav-child">-->
                    <!--<dd><a href="">邮件管理</a></dd>-->
                    <!--<dd><a href="">消息管理</a></dd>-->
                    <!--<dd><a href="">授权管理</a></dd>-->
                <!--</dl>-->
            <!--</li>-->
        <!--</ul>-->
        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item">
                <a href="javascript:;">
                    <img src="<?php echo htmlentities($user->avatar_explain); ?>" class="layui-nav-img">
                    <?php echo htmlentities($user->username); ?>
                </a>
                <!--<dl class="layui-nav-child">-->
                    <!--<dd><a href="">基本资料</a></dd>-->
                    <!--<dd><a href="">安全设置</a></dd>-->
                <!--</dl>-->
            </li>
            <li class="layui-nav-item"><a href="javascript:;" id="logout">注销</a></li>
        </ul>
    </div>

    <div class="layui-side layui-bg-black">
        <div class="layui-side-scroll">
            <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
            <ul class="layui-nav layui-nav-tree"  lay-filter="test">
                <?php foreach($priv as $v): if($v['menu'] == 1): ?>
                <li class="layui-nav-item <?php if($v['id'] == $top['id']): ?>layui-nav-itemed <?php if(!empty($v['route'])): ?>layui-this<?php endif; ?><?php endif; ?>">
                    <!--<li class="layui-nav-item layui-nav-itemed <?php if($v['id'] == $top['id']): if(!empty($v['route'])): ?>layui-this<?php endif; ?><?php endif; ?>">-->
                    <?php if(empty($v['route'])): ?>
                    <a class="" href="javascript:;"><?php echo htmlentities($v['cn']); ?></a>
                    <?php if(!empty($v['children'])): ?>
                    <dl class="layui-nav-child">
                        <?php foreach($v['children'] as $v1): if($v1['menu'] == 1): if(isset($sec)): ?>
                        <dd class="<?php if($v1['id'] == $sec['id']): ?>layui-this<?php endif; ?>"><a href="<?php echo htmlentities($v1['route']); ?>"><?php echo htmlentities($v1['cn']); ?></a></dd>
                        <?php else: ?>
                        <dd><a href="<?php echo htmlentities($v1['route']); ?>"><?php echo htmlentities($v1['cn']); ?></a></dd>
                        <?php endif; ?>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </dl>
                    <?php endif; else: ?>
                    <a class="" href="<?php echo htmlentities($v['route']); ?>"><?php echo htmlentities($v['cn']); ?></a>
                    <?php endif; ?>
                </li>
                <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <div class="layui-body">
        <div class="header">
            <div class="left">
                <div class="module">
                    <img src="<?php echo htmlentities($top['b_ico']); ?>" class="image">
                    <span><?php echo htmlentities($top['cn']); ?></span>
                    /
                    <span><?php echo htmlentities($top['en']); ?></span>
                </div>
            </div>
            <div class="right">
                <div class="position">
                    <span class="layui-breadcrumb">
                    <?php foreach($position as $v): if(empty($v['route'])): ?>
                            <a href="javascript:;"><?php echo htmlentities($v['cn']); ?></a>
                        <?php else: ?>
                         <a href="<?php echo htmlentities($v['route']); ?>"><?php echo htmlentities($v['cn']); ?></a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </span>
                </div>
            </div>
        </div>
        <div class="content">
            
<!-- 标题 -->
<div class="filter-option">
    <form class="layui-form layui-form-pane" id="search">

        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">ID</label>
                <div class="layui-input-inline">
                    <input type="text" name="id" class="layui-input">
                </div>
            </div>

            <div class="layui-inline">
                <button class="layui-btn" type="submit" lay-submit lay-filter="search">查询</button>
            </div>
        </div>
    </form>
</div>

<div class="operation">
    <!--<button class="layui-btn" data-link="<?php echo htmlentities($ctrl_url); ?>/addView?mode=add" id="add">添加</button>-->
    <!--<button class="layui-btn" id="delete-selected">删除选中项</button>-->
</div>

<!-- 列表 -->
<div class="list">
    <table class="layui-hide" id="list" lay-filter="table"></table>
</div>

        </div>
    </div>

    <div class="layui-footer"><?php echo htmlentities($os['name']); ?></div>
</div>
<script src="<?php echo htmlentities($plugin_url); ?>/layui/layui.all.js?version=<?php echo htmlentities($version); ?>"></script>
<script src="<?php echo htmlentities($plugin_url); ?>/jquery/jquery.js?version=<?php echo htmlentities($version); ?>"></script>
<script src="<?php echo htmlentities($module_url); ?>/public/js/lib.js?version=<?php echo htmlentities($version); ?>"></script>
<script src="<?php echo htmlentities($module_url); ?>/public/js/global.js?version=<?php echo htmlentities($version); ?>"></script>
<script src="<?php echo htmlentities($module_url); ?>/public/js/currency.js?version=<?php echo htmlentities($version); ?>"></script>
<script src="<?php echo htmlentities($module_url); ?>/public/js/public.js?version=<?php echo htmlentities($version); ?>"></script>

<script type="text/html" id="status">
    <input type="checkbox" name="status" value="{{d.id}}" lay-skin="switch" lay-text="开启|关闭" lay-filter="status" {{ d.status == 1 ? 'checked' : '' }}>
</script>

<script type="text/html" id="can_show">
    <input type="checkbox" name="can_show" value="{{d.id}}" lay-skin="switch" lay-text="开启|关闭" lay-filter="can_show" {{ d.can_show == 1 ? 'checked' : '' }}>
</script>

<script type="text/html" id="can_transfer">
    <input type="checkbox" name="can_transfer" value="{{d.id}}" lay-skin="switch" lay-text="开启|关闭" lay-filter="can_transfer" {{ d.can_transfer == 1 ? 'checked' : '' }}>
</script>

<script type="text/html" id="can_transfer_out">
    <input type="checkbox" name="can_transfer_out" value="{{d.id}}" lay-skin="switch" lay-text="开启|关闭" lay-filter="can_transfer_out" {{ d.can_transfer_out == 1 ? 'checked' : '' }}>
</script>

<script type="text/html" id="can_trend">
    <input type="checkbox" name="can_trend" value="{{d.id}}" lay-skin="switch" lay-text="开启|关闭" lay-filter="can_trend" {{ d.can_trend == 1 ? 'checked' : '' }}>
</script>

<script type="text/html" id="is_virtual">
    <input type="checkbox" name="is_virtual" value="{{d.id}}" lay-skin="switch" lay-text="开启|关闭" lay-filter="is_virtual" {{ d.is_virtual == 1 ? 'checked' : '' }}>
</script>

<script type="text/html" id="is_real">
    <input type="checkbox" name="is_real" value="{{d.id}}" lay-skin="switch" lay-text="开启|关闭" lay-filter="is_real" {{ d.is_real == 1 ? 'checked' : '' }}>
</script>

<script type="text/html" id="is_reward">
    <input type="checkbox" name="is_reward" value="{{d.id}}" lay-skin="switch" lay-text="开启|关闭" lay-filter="is_reward" {{ d.is_reward == 1 ? 'checked' : '' }}>
</script>

<script type="text/html" id="red_pack">
    <input type="checkbox" name="red_pack" value="{{d.id}}" lay-skin="switch" lay-text="开启|关闭" lay-filter="red_pack" {{ d.red_pack == 1 ? 'checked' : '' }}>
</script>

<script type="text/html" id="can_use_in_third_game">
    <input type="checkbox" name="can_use_in_third_game" value="{{d.id}}" lay-skin="switch" lay-text="开启|关闭" lay-filter="can_use_in_third_game" {{ d.can_use_in_third_game == 1 ? 'checked' : '' }}>
</script>

<script type="text/html" id="operation">
    <button class="layui-btn layui-btn-xs" lay-event="edit"><i class="layui-icon">&#xe642;</i>编辑</button>
    <!--<button class="layui-btn layui-btn-xs layui-btn-danger" lay-event="del">删除</button>-->
</script>

<script src="<?php echo htmlentities($ctrl_res_url); ?>/js/list.js?version=<?php echo htmlentities($version); ?>"></script>

</body>
</html>