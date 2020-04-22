<?php /*a:2:{s:63:"D:\work\code\lucky\application\admin\view\statistics\index.html";i:1568108125;s:58:"D:\work\code\lucky\application\admin\view\public\base.html";i:1566960893;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlentities($top['cn']); ?>-<?php echo htmlentities($cur['cn']); ?></title>
    <link rel="stylesheet" href="<?php echo htmlentities($plugin_url); ?>/layui/css/layui.css?version=<?php echo htmlentities($version); ?>">
    <link rel="stylesheet" href="<?php echo htmlentities($module_url); ?>/public/css/base.css?version=<?php echo htmlentities($version); ?>">
    
<link rel="stylesheet" href="<?php echo htmlentities($ctrl_res_url); ?>/css/index.css">

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
            
<!-- 理材游戏统计 -->
<div class="line">
    <div class="header">
        <div class="left">理财游戏</div>
        <div class="right"></div>
    </div>
    <div class="content">
        <table class="layui-table">
            <thead>
            <tr>
                <th>总投资</th>
                <th>总提取</th>
                <th>总收益</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><?php echo htmlentities($in_sum_for_game); ?></td>
                <td><?php echo htmlentities($out_sum_for_game); ?></td>
                <td><?php echo htmlentities($total_game_profit); ?></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="line layui-hide">
    <div class="header">
        <div class="left">划转统计-转入</div>
        <div class="right"></div>
    </div>
    <div class="content">
        <table class="layui-table">
            <thead>
            <tr>
                <th>币种</th>
                <th>数量</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($transfer_out as $v): ?>
            <tr>
                <td><?php echo !empty($v->coin) ? htmlentities($v->coin->cname) :  '未知币种'; ?></td>
                <td><?php echo htmlentities($v->amount); ?></td>
            </tr>
            <?php endforeach; if(count($transfer_out) == 0): ?>
            <tr>
                <td colspan="2">尚无统计记录</td>
            </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="line layui-hide">
    <div class="header">
        <div class="left">划转统计-转出</div>
        <div class="right"></div>
    </div>
    <div class="content">
        <table class="layui-table">
            <thead>
            <tr>
                <th>币种</th>
                <th>数量</th>
                <th>合计</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($transfer as $v): ?>
            <tr>
                <td><?php echo !empty($v->coin) ? htmlentities($v->coin->cname) :  '未知币种'; ?></td>
                <td><?php echo htmlentities($v->amount); ?></td>
                <td></td>
            </tr>
            <?php endforeach; if(count($transfer) == 0): ?>
            <tr>
                <td colspan="3">尚无统计记录</td>
            </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="line layui-hide">
    <div class="header">
        <div class="left">划转统计</div>
        <div class="right"></div>
    </div>
    <div class="content">
        <table class="layui-table">
            <thead>
            <tr>
                <th>币种</th>
                <th>转入</th>
                <th>转出</th>
                <!--<th>总划转</th>-->
            </tr>
            </thead>
            <tbody>
            <?php foreach($transfer_record as $k => $v): ?>
            <tr>
                <td><?php echo isset($v->cname) ? htmlentities($v->cname) : '未知币种'; ?></td>
                <td><?php echo htmlentities($v->sumForIn); ?></td>
                <td><?php echo htmlentities($v->sumForOut); ?></td>
                <!--<td></td>-->
            </tr>
            <?php endforeach; ?>
            <!--<tr>-->
                <!--<td colspan="3"></td>-->
                <!--<td><?php echo htmlentities($sum_for_transfer); ?></td>-->
            <!--</tr>-->
            <?php if(count($transfer_record) == 0): ?>
            <tr>
                <td colspan="4">尚无统计记录</td>
            </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="line">
    <div class="header">
        <div class="left">资金统计</div>
        <div class="right"></div>
    </div>
    <div class="content">
        <table class="layui-table">
            <tbody>
            <tr>
                <td>外网总转入</td>
                <td><?php echo htmlentities($transfer_in_sum); ?></td>
            </tr>
            <tr>
                <td>外网总转出</td>
                <td><?php echo htmlentities($transfer_out_sum); ?></td>
            </tr>
            <tr>
                <td>总划转</td>
                <td><?php echo htmlentities($sum_for_transfer); ?></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>


<div class="line">
    <div class="header">
        <div class="left">用户统计</div>
        <div class="right"></div>
    </div>
    <div class="content">
        <table class="layui-table">
            <tbody>
            <tr>
                <td>总注册数</td>
                <td><?php echo htmlentities($user_count); ?></td>
            </tr>
            <tr>
                <td>今日注册数</td>
                <td><?php echo htmlentities($user_count_for_today); ?></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="line">
    <div class="header">
        <div class="left">后台操作</div>
        <div class="right"></div>
    </div>
    <div class="content">
        <table class="layui-table">
            <tbody>
            <tr>
                <td>后台拨币数量</td>
                <td><?php echo htmlentities($sum_for_admin); ?></td>
            </tr>
            </tbody>
        </table>
    </div>
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

</body>
</html>