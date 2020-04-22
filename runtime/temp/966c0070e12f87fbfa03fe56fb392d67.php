<?php /*a:2:{s:70:"D:\work\code\mchat_gamming_adm\application\admin\view\login\login.html";i:1563357775;s:70:"D:\work\code\mchat_gamming_adm\application\admin\view\public\form.html";i:1561203473;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>登录</title>
    <link rel="stylesheet" href="<?php echo htmlentities($plugin_url); ?>/layui/css/layui.css?version=<?php echo htmlentities($version); ?>">
    <link rel="stylesheet" href="<?php echo htmlentities($module_url); ?>/public/css/form.css?version=<?php echo htmlentities($version); ?>">
    
<link rel="stylesheet" href="<?php echo htmlentities($module_url); ?>/login/css/login.css?version=<?php echo htmlentities($version); ?>">

</head>
<body>

<div class="container">
    <div class="header">欢迎使用 <?php echo htmlentities($os['name']); ?> 后台管理系统</div>
    <form class="layui-form" id="form">
        <div class="layui-form-item">
            <label class="layui-form-label">用户名</label>
            <div class="layui-input-block">
                <input type="text" name="username" required lay-verify="required" placeholder="请输入用户名" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">密码</label>
            <div class="layui-input-block">
                <input type="password" name="password" required lay-verify="required" placeholder="请输入密码" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="form">立即提交</button>
            </div>
        </div>
    </form>
</div>

<script src="<?php echo htmlentities($plugin_url); ?>/layui/layui.all.js?version=<?php echo htmlentities($version); ?>"></script>
<script src="<?php echo htmlentities($plugin_url); ?>/jquery/jquery.js?version=<?php echo htmlentities($version); ?>"></script>
<script src="<?php echo htmlentities($module_url); ?>/public/js/lib.js?version=<?php echo htmlentities($version); ?>"></script>
<script src="<?php echo htmlentities($module_url); ?>/public/js/global.js?version=<?php echo htmlentities($version); ?>"></script>

<script src="<?php echo htmlentities($module_url); ?>/login/js/login.js?version=<?php echo htmlentities($version); ?>"></script>

</body>
</html>