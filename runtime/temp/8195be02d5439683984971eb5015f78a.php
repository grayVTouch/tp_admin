<?php /*a:2:{s:64:"D:\work\code\lucky\application\admin\view\user_balance\list.html";i:1567930247;s:60:"D:\work\code\lucky\application\admin\view\public\iframe.html";i:1563525905;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlentities($top['cn']); ?>-<?php echo htmlentities($cur['cn']); ?></title>
    <link rel="stylesheet" href="<?php echo htmlentities($plugin_url); ?>/layui/css/layui.css?version=<?php echo htmlentities($version); ?>">
    <link rel="stylesheet" href="<?php echo htmlentities($public_url); ?>/css/iframe.css?version=<?php echo htmlentities($version); ?>">
    
<link rel="stylesheet" href="<?php echo htmlentities($public_url); ?>/css/list.css?version=<?php echo htmlentities($version); ?>">

</head>
<body>

<!-- 标题 -->
<div class="filter-option <?php if($mode == 'balance'): ?>layui-hide<?php endif; ?>">
    <form class="layui-form layui-form-pane" lay-filter="search-form" id="search">

        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">ID</label>
                <div class="layui-input-inline">
                    <input type="text" name="id" class="layui-input">
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">uid</label>
                <div class="layui-input-inline">
                    <input type="text" name="uid" class="layui-input">
                </div>
            </div>

            <div class="layui-inline">
                <label class="layui-form-label">钱包名称</label>
                <div class="layui-input-inline">
                    <input type="text" name="wallet_name" class="layui-input">
                </div>
            </div>

            <div class="layui-inline">
                <label class="layui-form-label">币种类型</label>
                <div class="layui-input-inline">
                    <select name="coin_id">
                        <option value="">请选择...</option>
                        <?php foreach($coin as $v): ?>
                        <option value="<?php echo htmlentities($v->id); ?>"><?php echo htmlentities($v->name); ?></option>
                        <?php endforeach; ?>
                    </select>
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

<script src="<?php echo htmlentities($plugin_url); ?>/layui/layui.all.js?version=<?php echo htmlentities($version); ?>"></script>
<script src="<?php echo htmlentities($plugin_url); ?>/jquery/jquery.js?version=<?php echo htmlentities($version); ?>"></script>
<script src="<?php echo htmlentities($public_url); ?>/js/lib.js?version=<?php echo htmlentities($version); ?>"></script>
<script src="<?php echo htmlentities($public_url); ?>/js/global.js?version=<?php echo htmlentities($version); ?>"></script>
<script src="<?php echo htmlentities($public_url); ?>/js/currency.js?version=<?php echo htmlentities($version); ?>"></script>
<script src="<?php echo htmlentities($public_url); ?>/js/public.js?version=<?php echo htmlentities($version); ?>"></script>

<script type="text/html" id="operation">
    <button class="layui-btn layui-btn-xs" lay-event="balance">拨币</button>
    <!--<button class="layui-btn layui-btn-xs layui-btn-danger" lay-event="del">删除</button>-->
</script>
<script src="<?php echo htmlentities($ctrl_res_url); ?>/js/list.js?version=<?php echo htmlentities($version); ?>"></script>

</body>
</html>