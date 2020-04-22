<?php /*a:2:{s:70:"D:\work\code\lucky\application\admin\view\user\real_name_verified.html";i:1567219420;s:60:"D:\work\code\lucky\application\admin\view\public\iframe.html";i:1563525905;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlentities($top['cn']); ?>-<?php echo htmlentities($cur['cn']); ?></title>
    <link rel="stylesheet" href="<?php echo htmlentities($plugin_url); ?>/layui/css/layui.css?version=<?php echo htmlentities($version); ?>">
    <link rel="stylesheet" href="<?php echo htmlentities($public_url); ?>/css/iframe.css?version=<?php echo htmlentities($version); ?>">
    
<link rel="stylesheet" href="<?php echo htmlentities($public_url); ?>/css/thing.css?version=<?php echo htmlentities($version); ?>">
<link rel="stylesheet" href="<?php echo htmlentities($ctrl_res_url); ?>/css/thing.css?version=<?php echo htmlentities($version); ?>">

</head>
<body>

<!--<form class="layui-form layui-form-pane" method="post" id="form">-->
<form class="layui-form" id="form">

    <div class="layui-form-item">
        <label class="layui-form-label">真实姓名</label>
        <div class="layui-input-block"><span class="layui-run-text layui-run-text-middle"><?php echo isset($thing->info->id_name) ? htmlentities($thing->info->id_name) : ''; ?></span></div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">身份证号码</label>
        <div class="layui-input-block"><span class="layui-run-text layui-run-text-middle"><?php echo isset($thing->info->id_num) ? htmlentities($thing->info->id_num) : ''; ?></span></div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">正面</label>
        <div class="layui-input-block">
            <img src="<?php echo isset($thing->info->id_front) ? htmlentities($thing->info->id_front) : '/static/admin/default_image.jpg'; ?>" class="image">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">反面</label>
        <div class="layui-input-block">
            <img src="<?php echo isset($thing->info->id_back) ? htmlentities($thing->info->id_back) : '/static/admin/default_image.jpg'; ?>" class="image">
        </div>
    </div>

    <div class="layui-form-item layui-form-text">
        <label class="layui-form-label">认证状态<b class="font-red">*</b></label>
        <div class="layui-input-block">
            <?php foreach($is_verify as $k => $v): ?>
            <input type="radio" name="is_verify" value="<?php echo htmlentities($k); ?>" title="<?php echo htmlentities($v); ?>" <?php if($k == $thing->is_verify): ?>checked="checked"<?php endif; ?>>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="layui-form-item">
        <div class="layui-input-block">
            <input type="hidden" name="id" value="<?php echo isset($thing->id) ? htmlentities($thing->id) : ''; ?>"  class="layui-input">
            <button class="layui-btn" lay-submit lay-filter="form">立即提交</button>
        </div>
    </div>

</form>

<script src="<?php echo htmlentities($plugin_url); ?>/layui/layui.all.js?version=<?php echo htmlentities($version); ?>"></script>
<script src="<?php echo htmlentities($plugin_url); ?>/jquery/jquery.js?version=<?php echo htmlentities($version); ?>"></script>
<script src="<?php echo htmlentities($public_url); ?>/js/lib.js?version=<?php echo htmlentities($version); ?>"></script>
<script src="<?php echo htmlentities($public_url); ?>/js/global.js?version=<?php echo htmlentities($version); ?>"></script>
<script src="<?php echo htmlentities($public_url); ?>/js/currency.js?version=<?php echo htmlentities($version); ?>"></script>
<script src="<?php echo htmlentities($public_url); ?>/js/public.js?version=<?php echo htmlentities($version); ?>"></script>

<script src="<?php echo htmlentities($ctrl_res_url); ?>/js/real_name_verified.js?version=<?php echo htmlentities($version); ?>"></script>

</body>
</html>