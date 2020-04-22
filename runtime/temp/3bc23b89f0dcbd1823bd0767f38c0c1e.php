<?php /*a:2:{s:72:"D:\work\code\lucky\application\admin\view\community_slideshow\thing.html";i:1567132535;s:60:"D:\work\code\lucky\application\admin\view\public\iframe.html";i:1563525905;}*/ ?>
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
        <label class="layui-form-label">图片</label>
        <div class="layui-input-block">
            <div class="line">
                <button type="button" class="layui-btn" id="image">
                    <i class="layui-icon">&#xe67c;</i>图片
                </button>
            </div>
            <div class="line" id="image-preview">
                <img src="<?php echo isset($thing->pic_explain) ? htmlentities($thing->pic_explain) : ''; ?>" class="image">
            </div>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">状态</label>
        <div class="layui-input-block">
            <?php foreach($status as $k => $v): if($mode == 'edit'): ?>
            <input type="radio" name="status" value="<?php echo htmlentities($k); ?>" title="<?php echo htmlentities($v); ?>" <?php if($k == $thing->status): ?>checked="checked"<?php endif; ?>>
            <?php else: ?>
            <input type="radio" name="status" value="<?php echo htmlentities($k); ?>" title="<?php echo htmlentities($v); ?>" <?php if($k == 1): ?>checked="checked"<?php endif; ?>>
            <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit="submit" lay-filter="form">立即提交</button>
        </div>
    </div>

</form>

<script src="<?php echo htmlentities($plugin_url); ?>/layui/layui.all.js?version=<?php echo htmlentities($version); ?>"></script>
<script src="<?php echo htmlentities($plugin_url); ?>/jquery/jquery.js?version=<?php echo htmlentities($version); ?>"></script>
<script src="<?php echo htmlentities($public_url); ?>/js/lib.js?version=<?php echo htmlentities($version); ?>"></script>
<script src="<?php echo htmlentities($public_url); ?>/js/global.js?version=<?php echo htmlentities($version); ?>"></script>
<script src="<?php echo htmlentities($public_url); ?>/js/currency.js?version=<?php echo htmlentities($version); ?>"></script>
<script src="<?php echo htmlentities($public_url); ?>/js/public.js?version=<?php echo htmlentities($version); ?>"></script>

<script src="<?php echo htmlentities($ctrl_res_url); ?>/js/thing.js?version=<?php echo htmlentities($version); ?>"></script>

</body>
</html>