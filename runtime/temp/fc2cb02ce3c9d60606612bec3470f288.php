<?php /*a:2:{s:79:"D:\work\code\mchat_gamming_adm\application\admin\view\system_message\thing.html";i:1575343050;s:70:"D:\work\code\mchat_gamming_adm\application\admin\view\public\base.html";i:1566960893;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlentities($top['cn']); ?>-<?php echo htmlentities($cur['cn']); ?></title>
    <link rel="stylesheet" href="<?php echo htmlentities($plugin_url); ?>/layui/css/layui.css?version=<?php echo htmlentities($version); ?>">
    <link rel="stylesheet" href="<?php echo htmlentities($module_url); ?>/public/css/base.css?version=<?php echo htmlentities($version); ?>">
    
<link rel="stylesheet" href="<?php echo htmlentities($public_url); ?>/css/thing.css?version=<?php echo htmlentities($version); ?>">
<link rel="stylesheet" href="<?php echo htmlentities($public_url); ?>/css/wang-editor.css?version=<?php echo htmlentities($version); ?>">
<link rel="stylesheet" href="<?php echo htmlentities($plugin_url); ?>/wang-editor/release/wangEditor.css?version=<?php echo htmlentities($version); ?>">
<link rel="stylesheet" href="<?php echo htmlentities($ctrl_res_url); ?>/css/thing.css?version=<?php echo htmlentities($version); ?>">

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
            
<!--<form class="layui-form layui-form-pane" method="post" id="form">-->
<form class="layui-form" id="form">

    <div class="layui-form-item">
        <label class="layui-form-label">标题<b class="font-red">*</b></label>
        <div class="layui-input-block">
            <input type="text" name="title" required="required" value="<?php echo isset($thing->title) ? htmlentities($thing->title) : ''; ?>" required="required" lay-verify="required" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">uid</label>
        <div class="layui-input-block">
            <input type="number" name="uid" value="<?php echo isset($thing->uid) ? htmlentities($thing->uid) : ''; ?>" class="layui-input">
            如果是系统消息可以不用填写；如果是其他类型的消息则必须填写。
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">类型</label>
        <div class="layui-input-block">
            <select name="type">
                <?php foreach($type as $v): ?>
                <option value="<?php echo htmlentities($v->type); ?>"><?php echo htmlentities($v->name); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">封面</label>
        <div class="layui-input-block">
            <div class="line">
                <button type="button" class="layui-btn" id="image">
                    <i class="layui-icon">&#xe67c;</i>图标
                </button>
            </div>
            <div class="line" id="image-preview">
                <img src="<?php echo isset($thing->img_explain) ? htmlentities($thing->img_explain) : ''; ?>" class="image">
            </div>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">内容</label>
        <div class="layui-input-block">
            <div id="editor" class="wang-editor" data-content="<?php echo isset($thing->content) ? htmlentities($thing->content) : ''; ?>"></div>
        </div>
    </div>


    <div class="layui-form-item">
        <label class="layui-form-label">创建时间</label>
        <div class="layui-input-block">
            <input type="text" name="date" readonly="readonly" value="<?php echo isset($thing->date) ? htmlentities($thing->date) : ''; ?>" class="layui-input" id="datetime">
        </div>
    </div>

    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit="submit" lay-filter="form">立即提交</button>
        </div>
    </div>

</form>

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

<script src="<?php echo htmlentities($plugin_url); ?>/wang-editor/release/wangEditor.js?version=<?php echo htmlentities($version); ?>"></script>
<script src="<?php echo htmlentities($ctrl_res_url); ?>/js/thing.js?version=<?php echo htmlentities($version); ?>"></script>

</body>
</html>