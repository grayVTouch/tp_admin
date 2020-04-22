<?php /*a:2:{s:67:"D:\work\code\lucky\application\admin\view\wallet_to_coin\thing.html";i:1567651208;s:60:"D:\work\code\lucky\application\admin\view\public\iframe.html";i:1563525905;}*/ ?>
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
        <label class="layui-form-label">用什么币兑换<b class="font-red">*</b></label>
        <div class="layui-input-block">
            <select name="from_coin_id" required="required"  lay-verify="required">
                <option value="">请选择...</option>
                <?php foreach($coin as $v): if($mode == 'edit'): ?>
                <option value="<?php echo htmlentities($v->id); ?>" <?php if($thing->from_coin_id == $v->id): ?>selected="selected"<?php endif; ?>><?php echo htmlentities($v->name); ?>【<?php echo htmlentities($v->cname); ?>】</option>
                <?php else: ?>
                <option value="<?php echo htmlentities($v->id); ?>"><?php echo htmlentities($v->name); ?>【<?php echo htmlentities($v->cname); ?>】</option>
                <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">兑换什么币<b class="font-red">*</b></label>
        <div class="layui-input-block">
            <select name="to_coin_id" required="required"  lay-verify="required">
                <option value="">请选择...</option>
                <?php foreach($coin as $v): if($mode == 'edit'): ?>
                <option value="<?php echo htmlentities($v->id); ?>" <?php if($thing->to_coin_id == $v->id): ?>selected="selected"<?php endif; ?>><?php echo htmlentities($v->name); ?>【<?php echo htmlentities($v->cname); ?>】</option>
                <?php else: ?>
                <option value="<?php echo htmlentities($v->id); ?>"><?php echo htmlentities($v->name); ?>【<?php echo htmlentities($v->cname); ?>】</option>
                <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">币种资产类型<b class="font-red">*</b></label>
        <div class="layui-input-block">
            <input type="text" name="symbol" required="required" value="<?php echo isset($thing->symbol) ? htmlentities($thing->symbol) : ''; ?>"  lay-verify="required" class="layui-input">
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