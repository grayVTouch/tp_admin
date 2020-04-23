<?php /*a:2:{s:67:"D:\work\code\nesm_shop\application\admin\view\shop_goods\thing.html";i:1587623621;s:62:"D:\work\code\nesm_shop\application\admin\view\public\base.html";i:1566960893;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlentities($top['cn']); ?>-<?php echo htmlentities($cur['cn']); ?></title>
    <link rel="stylesheet" href="<?php echo htmlentities($plugin_url); ?>/layui/css/layui.css?version=<?php echo htmlentities($version); ?>">
    <link rel="stylesheet" href="<?php echo htmlentities($module_url); ?>/public/css/base.css?version=<?php echo htmlentities($version); ?>">
    
<link rel="stylesheet" href="<?php echo htmlentities($public_url); ?>/css/thing.css?version=<?php echo htmlentities($version); ?>">
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
            
<form class="layui-form" id="form">

    <div class="layui-tab">
        <ul class="layui-tab-title">
            <li class="layui-this">商品信息</li>
            <li>商品介绍</li>
            <li>商品规格</li>
            <li>商品参数</li>
            <li>商品图片</li>
        </ul>
        <div class="layui-tab-content">
            <!-- 商品信息 -->
            <div class="layui-tab-item layui-show">
                <div class="layui-form-item">
                    <label class="layui-form-label">名称</label>
                    <div class="layui-input-block">
                        <input type="text" name="name"  value="<?php echo isset($thing->name) ? htmlentities($thing->name) : ''; ?>"  class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">一级分类</label>
                    <div class="layui-input-block">
                        <select name="cate_one_id">
                            <option value="">请选择...</option>
                            <?php foreach($category_one as $v): if($mode == 'edit'): ?>
                            <option value="<?php echo htmlentities($v->id); ?>" <?php if($thing->cate_one_id == $v->id): ?>selected="selected"<?php endif; ?>><?php echo htmlentities($v->name); ?></option>
                            <?php else: ?>
                            <option value="<?php echo htmlentities($v->id); ?>"><?php echo htmlentities($v->name); ?></option>
                            <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">二级分类</label>
                    <div class="layui-input-block">
                        <select name="cate_two_id">
                            <option value="">请选择...</option>
                            <?php foreach($category_two as $v): if($mode == 'edit'): ?>
                            <option value="<?php echo htmlentities($v->id); ?>" <?php if($thing->cate_two_id == $v->id): ?>selected="selected"<?php endif; ?>><?php echo htmlentities($v->name); ?></option>
                            <?php else: ?>
                            <option value="<?php echo htmlentities($v->id); ?>"><?php echo htmlentities($v->name); ?></option>
                            <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">运费</label>
                    <div class="layui-input-block">
                        <input type="text" name="freight"  value="<?php echo isset($thing->freight) ? htmlentities($thing->freight) : ''; ?>" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">图标</label>
                    <div class="layui-input-block">
                        <div class="line">
                            <button type="button" class="layui-btn" id="image">
                                <i class="layui-icon">&#xe67c;</i>图标
                            </button>
                        </div>
                        <div class="line" id="image-preview">
                            <img src="<?php echo isset($thing->pic_explain) ? htmlentities($thing->pic_explain) : ''; ?>" class="image">
                        </div>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">简介</label>
                    <div class="layui-input-block">
                        <textarea name="into" placeholder="简介"  class="layui-textarea"><?php echo isset($thing->into) ? htmlentities($thing->into) : ''; ?></textarea>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">是否热门</label>
                    <div class="layui-input-block">
                        <?php foreach($bool as $k => $v): if($mode == 'edit'): ?>
                        <input type="radio" name="is_hot" value="<?php echo htmlentities($k); ?>" title="<?php echo htmlentities($v); ?>" <?php if($k == $thing->is_hot): ?>checked="checked"<?php endif; ?>>
                        <?php else: ?>
                        <input type="radio" name="is_hot" value="<?php echo htmlentities($k); ?>" title="<?php echo htmlentities($v); ?>" <?php if($k == 0): ?>checked="checked"<?php endif; ?>>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">是否推荐</label>
                    <div class="layui-input-block">
                        <?php foreach($bool as $k => $v): if($mode == 'edit'): ?>
                        <input type="radio" name="is_recommend" value="<?php echo htmlentities($k); ?>" title="<?php echo htmlentities($v); ?>" <?php if($k == $thing->is_recommend): ?>checked="checked"<?php endif; ?>>
                        <?php else: ?>
                        <input type="radio" name="is_recommend" value="<?php echo htmlentities($k); ?>" title="<?php echo htmlentities($v); ?>" <?php if($k == 0): ?>checked="checked"<?php endif; ?>>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">商品状态</label>
                    <div class="layui-input-block">
                        <?php foreach($status as $k => $v): if($mode == 'edit'): ?>
                        <input type="radio" name="status" value="<?php echo htmlentities($k); ?>" title="<?php echo htmlentities($v); ?>" <?php if($k == $thing->status): ?>checked="checked"<?php endif; ?>>
                        <?php else: ?>
                        <input type="radio" name="status" value="<?php echo htmlentities($k); ?>" title="<?php echo htmlentities($v); ?>" <?php if($k == 0): ?>checked="checked"<?php endif; ?>>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <!-- 商品简介 -->
            <div class="layui-tab-item">
                <textarea id="introduction"><?php if($mode == 'edit' && !empty($thing->my_introduction)): ?><?php echo htmlentities($thing->my_introduction->introduction); ?><?php endif; ?></textarea>
            </div>
            <!-- 商品规格 -->
            <div class="layui-tab-item run-dynamic-input" id="goods_rule" <?php if($mode == 'edit' && !empty($thing->shop_rule)): ?>data-data="<?php echo htmlentities(json_encode($thing->shop_rule)); ?>"<?php endif; ?>>
                <div class="run-top">
                    <button class="layui-btn layui-btn-sm" @click="add">添加</button>
                </div>
                <div class="run-btm">
                    <div class="run-line" v-for="(v,k) in res">
                        <span class="delete" @click.stop="del(k)">-</span>
                        <div class="run-image">
                            <button type="button" class="layui-btn" :id="'run_upload_' + k" :ref="'run_upload_' + k">
                                <i class="layui-icon">&#xe67c;</i>图标
                            </button>
                            <img :src="v.pic_explain" class="run-preview" :ref="'run_preview_' + k">
                        </div>
                        <input type="text" placeholder="规格" v-model="v.name" class="run-input">
                        <input type="text" placeholder="库存" v-model="v.stock" class="run-input">
                        <input type="text" placeholder="价格" v-model="v.price" class="run-input">
                        <input type="text" placeholder="原始价格" v-model="v.original_price" class="run-input">
                    </div>
                </div>
            </div>
            <!-- 商品参数 -->
            <div class="layui-tab-item run-dynamic-input" id="shop_param" <?php if($mode == 'edit' && !empty($thing->shop_param)): ?>data-data="<?php echo htmlentities(json_encode($thing->shop_param)); ?>"<?php endif; ?>>
                <div class="run-top">
                    <button class="layui-btn layui-btn-sm" @click="add">添加</button>
                </div>
                <div class="run-btm">

                    <div class="run-line" v-for="(v,k) in res">
                        <span class="delete" @click="del(k)">-</span>
                        <input type="text" placeholder="名称" v-model="v.param_name" class="run-input">
                        <input type="text" placeholder="值" v-model="v.param_value" class="run-input">
                    </div>

                </div>
            </div>
            <!-- 商品图片 -->
            <div class="layui-tab-item" id="goods_image" <?php if($mode == 'edit' && !empty($thing->image)): ?>data-data="<?php echo htmlentities(json_encode($thing->image)); ?>"<?php endif; ?>>
                <div class="top">
                    <div class="layui-form-item">
                        <label class="layui-form-label">商品简介图片</label>
                        <div class="layui-input-block">
                            <div class="line">
                                <button type="button" class="layui-btn" ref="upload">
                                    <i class="layui-icon">&#xe67c;</i>图标
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="btm">
                    <table class="layui-table">
                        <thead>
                        <tr>
                            <th>图片</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(v,k) in res">
                            <td><img :src="v.pic_explain" class="image" /></td>
                            <td><button class="layui-btn layui-btn-sm" @click="del(k)">删除</button></td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
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

<script src="<?php echo htmlentities($public_url); ?>/js/vue.min.js?version=<?php echo htmlentities($version); ?>"></script>
<script src="<?php echo htmlentities($ctrl_res_url); ?>/js/thing.js?version=<?php echo htmlentities($version); ?>"></script>

</body>
</html>