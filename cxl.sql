-- 用户表
drop table if exists `tk_user`;
create table if not exists `tk_user` (
  id int unsigned not null auto_increment ,
  user_id int unsigned default 0 comment '远程用户id，请使用这个 id 作为 用户 id' ,
  `type` tinyint unsigned default 1 comment '用户类型：1-用户 2-商家' ,
  username varchar(255) default '' comment '用户名' ,
  password varchar(255) default '' comment '密码' ,
  sex tinyint unsigned default 0 comment '性别: 0-未知 1-男人 2-女人 3-两性' ,
  phone varchar(20) default '' comment '手机号码' ,
  country_code varchar(20) default '' comment '国家代码' ,
   avatar varchar(500) default '' comment '头像' ,
  birthday date default null comment '生日' ,
  status tinyint unsigned default 1 comment '账号状态：1-正常 2-锁定' ,
  login_time datetime default null comment '最近一次登陆时间' ,
  login_ip char(255) default '' comment '最近一次登录ip' ,
  token datetime default null comment '登录token，仅用于 app 验证' ,
  update_time datetime default current_timestamp on update current_timestamp ,
  create_time datetime default current_timestamp ,
  primary key `id` (`id`)
) engine=innodb character set = utf8mb4 collate = utf8mb4_bin comment '用户表' ;

drop table if exists `tk_user_balance`;
create table if not exists `tk_user_balance` (
  id int unsigned not null auto_increment ,
  user_id int unsigned default 0 comment '远程用户id，请使用这个 id 作为 用户 id' ,
  balance decimal(13,2) default 0 comment '用户余额' ,
  update_time datetime default current_timestamp on update current_timestamp ,
  create_time datetime default current_timestamp ,
  primary key `id` (`id`)
) engine=innodb character set = utf8mb4 collate = utf8mb4_bin comment '用户余额表';

drop table if exists `tk_merchant`;
create table if not exists `tk_merchant` (
  id int unsigned not null auto_increment ,
  name varchar(255) default '' comment '店铺名称' ,
  user_id int unsigned default 0 comment 'tk_user.id' ,
  image varchar(500) default '' comment '店铺封面图' ,
  is_ok tinyint unsigned default 0 comment '商家审核是否通过：1-审核不通过 2-审核通过' ,
  status tinyint unsigned default 1 comment '商家状态：1-正常 2-锁定' ,
  type tinyint unsigned default 3 comment '1-自营店铺 2-合作店铺（同 店家 与 天猫的关系） 3-普通店铺' ,
  `desc` text default null comment '店铺介绍' ,
  update_time datetime default current_timestamp on update current_timestamp ,
  create_time datetime default current_timestamp ,
  primary key `id` (`id`)
) engine=innodb character set = utf8mb4 collate = utf8mb4_bin comment '商家表' ;

drop table if exists `tk_merchant_image`;
create table if not exists `tk_merchant_image` (
  id int unsigned not null auto_increment ,
  merchant_id int unsigned default 0 comment 'tk_merchant.id' ,
  path varchar(500) default '' comment '店铺详情图片' ,
  create_time datetime default current_timestamp ,
  primary key `id` (`id`)
) engine=innodb character set = utf8mb4 collate = utf8mb4_bin comment '商家图片表' ;

drop table if exists `tk_merchant_application`;
create table if not exists `tk_merchant_application` (
  id int unsigned not null auto_increment ,
  user_id int unsigned default 0 comment 'tk_user.id' ,
  merchant_id int unsigned default 0 comment 'tk_merchant.id' ,
  status tinyint unsigned default 1 comment '1-审核中 2-审核通过 3-审核不通过' ,
  reason varchar(500) default '' comment '审核结果说明，每次用户修改申请后，该字段值都需要清空' ,
  update_time datetime default current_timestamp on update current_timestamp ,
  create_time datetime default current_timestamp ,
  primary key `id` (`id`)
) engine=innodb character set = utf8mb4 collate = utf8mb4_bin comment '商家申请表' ;

drop table if exists `tk_category`;
create table if not exists `tk_category` (
  id int unsigned not null auto_increment ,
  name varchar(255) default '' comment '分类名称' ,
  `desc` varchar(500) default '' comment '分类描述' ,
  image varchar(500) default '' comment '分类图片' ,
  p_id int unsigned default 0 comment 'tk_category.id,上级分类id' ,
  enable tinyint unsigned default 1 comment '启用：0-否 1-是' ,
  weight smallint default 0 comment '权重' ,
  update_time datetime default current_timestamp on update current_timestamp ,
  create_time datetime default current_timestamp ,
  primary key `id` (`id`)
) engine=innodb character set = utf8mb4 collate = utf8mb4_bin comment '分类表' ;

drop table if exists `tk_goods_param_key`;
create table if not exists `tk_goods_param_key` (
  id int unsigned not null auto_increment ,
  category_id int unsigned default 0 comment 'tk_category.id' ,
  name varchar(255) default '' comment '参数名称' ,
  create_time datetime default current_timestamp ,
  primary key `id` (`id`)
) engine=innodb character set = utf8mb4 collate = utf8mb4_bin comment '商品参数 key';

drop table if exists `tk_specification_group`;
create table if not exists `tk_specification_group` (
  id int unsigned not null auto_increment ,
  category_id int unsigned default 0 comment 'tk_category.id' ,
  name varchar(1000) default '' comment '规格分组' ,
  create_time datetime default current_timestamp ,
  primary key `id` (`id`)
) engine=innodb character set = utf8mb4 collate = utf8mb4_bin comment '规格分组表' ;

drop table if exists `tk_specification`;
create table if not exists `tk_specification` (
  id int unsigned not null auto_increment ,
  category_id int unsigned default 0 comment 'tk_category.id' ,
  specification_group_id int unsigned default 0 comment 'tk_specification_group.id' ,
  name varchar(500) default '' comment '规格名称' ,
  create_time datetime default current_timestamp ,
  primary key `id` (`id`)
) engine=innodb character set = utf8mb4 collate = utf8mb4_bin comment '商品规格 key' ;

drop table if exists `tk_goods`;
create table if not exists `tk_goods` (
  id int unsigned not null auto_increment ,
  name varchar(500) default '' comment '商品名称' ,
  merchant_id int unsigned default 0 comment 'tk_merchant.id' ,
  category_id int unsigned default 0 comment 'tk_category.id，分类id' ,
  brand_id int unsigned default 0 comment 'tk_brand.id，品牌id' ,
  thumb varchar(500) default '' comment '商品封面图' ,
  `detail` mediumtext comment '商品详情' ,
  package_list varchar(1000) default '' comment '包装清单' ,
  price decimal(13,2) default 0 comment '价格，仅在没有选项的情况下，使用这个价格' ,
  stock int unsigned default 0 comment '库存' ,
  `min_price` decimal(13,2) default 0 comment '最小金额，如果有多个选项，请使用这个价格范围' ,
  `max_price` decimal(13,2) default 0 comment '最高金额，如果有多个选项，请使用这个价格范围' ,
  has_option tinyint unsigned default 0 comment '是否有选项：0-否 1-是' ,
  update_time datetime default current_timestamp on update current_timestamp ,
  create_time datetime default current_timestamp ,
  primary key `id` (`id`)
) engine=innodb character set = utf8mb4 collate = utf8mb4_bin comment '商品表' ;

drop table if exists `tk_goods_param`;
create table if not exists `tk_goods_param` (
  id int unsigned not null auto_increment ,
  goods_id int unsigned default 0 comment 'tk_goods.id' ,
  category_id int unsigned default 0 comment 'tk_category.id，缓存字段' ,
  goods_param_key_id int unsigned default 0 comment 'tk_goods_param_key.id' ,
  `key` varchar(255) default '' comment '参数 key，缓存字段' ,
  `value` varchar(255) default '' comment '参数 value' ,
  create_time datetime default current_timestamp ,
  primary key `id` (`id`)
) engine=innodb character set = utf8mb4 collate = utf8mb4_bin comment '商品参数';

drop table if exists `tk_goods_specification`;
create table if not exists `tk_goods_specification` (
  id int unsigned not null auto_increment ,
  goods_id int unsigned default 0 comment 'tk_goods.id' ,
  category_id int unsigned default 0 comment 'tk_category.id' ,
  specification_group_id int unsigned default 0 comment 'tk_specification_group.id，缓存字段' ,
  specification_id int unsigned default 0 comment 'tk_specification.id' ,
  `group` varchar(255) default '' comment '规格分组名称，缓存字段' ,
  `key` varchar(1000) default '' comment '规格 key，缓存字段' ,
  `value` varchar(1000) default '' comment '规格 value' ,
  create_time datetime default current_timestamp ,
  primary key `id` (`id`)
) engine=innodb character set = utf8mb4 collate = utf8mb4_bin comment '商品规格表' ;

drop table if exists `tk_goods_option_group`;
create table if not exists `tk_goods_option_group` (
  id int unsigned not null auto_increment ,
  name varchar(255) default '' comment '分组名称' ,
  create_time datetime default current_timestamp ,
  primary key `id` (`id`)
) engine=innodb character set = utf8mb4 collate = utf8mb4_bin comment '商品选项分组表' ;

drop table if exists `tk_goods_option`;
create table if not exists `tk_goods_option` (
  id int unsigned not null auto_increment ,
  goods_id int unsigned default 0 comment 'tk_goods.id' ,
  goods_option_group_id int unsigned default 0 comment 'tk_goods_option_group.id' ,
  name_for_goods_option_group varchar(255) default '' comment '选项分组名称' ,
  name varchar(255) default '' comment '选项名称' ,
  `desc` varchar(500) default '' comment '描述' ,
  ico varchar(500) default '' comment '选项图片' ,
  enable_ico tinyint unsigned default 0 comment '是否开启选项图片预览：0-否 1-是' ,
  enable tinyint unsigned default 1 comment '是否启用选项：0-不启用 1-启用' ,
  enable_thumb_switch tinyint default 0 comment '是否开启封面切换：0-否 1-是' ,
  thumb varchar(1000) default null comment '商品预览图（封面图）' ,
  create_time datetime default current_timestamp ,
  primary key `id` (`id`)
) engine=innodb character set = utf8mb4 collate = utf8mb4_bin comment '商品-选项-关联表' ;

drop table if exists `tk_goods_stock_and_price`;
create table if not exists `tk_goods_stock_and_price` (
  id int unsigned not null auto_increment ,
  goods_id int unsigned default 0 comment 'tk_goods.id' ,
  goods_options varchar(1000) default '' comment 'tk_goods_option.id 的 json 组合' ,
  price decimal(13,2) default 0 comment '价格' ,
  stock int unsigned default 0 comment '库存' ,
  create_time datetime default current_timestamp ,
  primary key `id` (`id`)
) engine=innodb character set = utf8mb4 collate = utf8mb4_bin comment '商品-价格-库存-表' ;

-- 订单表
drop table if exists `tk_goods_order`;
create table if not exists `tk_goods_order` (
  id int unsigned not null auto_increment ,
  user_id int unsigned default 0 comment 'tk_user.id' ,
  order_no varchar(255) default '' comment '订单号' ,
  price decimal(13,2) default 0 comment '价格' ,
  p_id int unsigned default 0 comment 'tk_goods_order.id，上级订单id' ,
  update_time datetime default current_timestamp on update current_timestamp ,
  create_time datetime default current_timestamp ,
  primary key `id` (`id`)
) engine=innodb character set = utf8mb4 collate = utf8mb4_bin comment '商品订单表' ;

-- 订单详情表
drop table if exists `tk_goods_order_detail`;
drop table if exists `tk_goods_order_goods`;
create table if not exists `tk_goods_order_goods` (
  id int unsigned not null auto_increment ,
  user_id int unsigned default 0 comment 'tk_user.id，缓存字段' ,
  tk_id int unsigned default 0 comment 'tk_shop.id，缓存字段' ,
  goods_id int unsigned default 0 comment 'tk_goods.id' ,
  `number`int unsigned default 0 comment '购买数量' ,
  -- 以下是缓存字段
  name varchar(500) default '' comment '商品名称-缓存字段' ,
  `thumb`int unsigned default 0 comment '商品封面图-缓存字段' ,
  price decimal(13,2) default 0 comment '商品价格-缓存字段' ,
  has_option tinyint unsigned default 0 comment '是否有选项：0-没有 1-有 ，缓存字段' ,
  goods_option varchar(1000) comment '商品选项，字符串描述；用以展示用' ,
  goods_option_id varchar(500) default '' comment 'json 字符串，按照从小到大顺序保存，tk_goods_option.id' ,
  goods_detail longtext default null comment '商品详情，缓存字段' ,
  -- 缓存商品规格
  goods_specification longtext default null comment 'json字段，缓存字段，商品规格' ,
  -- 缓存商品参数
  goods_param longtext default null comment 'json 字段，缓存字段，商品参数' ,
  update_time datetime default current_timestamp on update current_timestamp ,
  create_time datetime default current_timestamp ,
  primary key `id` (`id`)
) engine=innodb character set = utf8mb4 collate = utf8mb4_bin comment '商品订单表' ;


-- 后台-操作日志
drop table if exists `tk_operation_log`;
create table if not exists `tk_operation_log` (
  id int unsigned not null auto_increment ,
  user_id int unsigned default 0 comment 'tk_admin_user.id，操作者用户id' ,
  type varchar(500) default '' comment '日志类型: common-普通日志 order-订单日志' ,
  log text comment '操作日志，请具体说明操作内容' ,
  create_time datetime default current_timestamp ,
  primary key `id` (`id`)
) engine=innodb character set = utf8mb4 collate = utf8mb4_bin comment '操作日志';

-- 退/换货
drop table if exists `tk_return_goods`;
create table if not exists `tk_return_goods` (
  id int unsigned not null auto_increment ,
  user_id int unsigned default 0 comment 'tk_user.id' ,
  service_no varchar(255) default '' comment '服务单号' ,
  goods_id int unsigned default 0 comment 'tk_goods.id，缓存字段' ,
  tk_id int unsigned default 0 comment 'tk_shop.id，缓存字段' ,
  goods_order_goods_id int unsigned default 0 comment 'tk_goods_order_goods.id 订单商品id' ,
  type tinyint unsigned default 1 comment '类型：1-退货 2-换货 3-维修' ,
  reason varchar(1000) default '' comment '退换货原因' ,
  status tinyint unsigned default 1 comment '状态：1-审核中 2-同意售后 3-拒绝售后 4-关闭 5-已完成 6-已评价' ,
  remark varchar(1000) default '' comment '审核意见，仅允许商家填写' ,
--   return_method tinyint unsigned default 1 comment '寄送方式：1-快递至商家 2-上门取件' ,
--   get_address varchar(1000) default '' comment '取件地址，return_method = 2 时，有效 ' ,
  return_address varchar(1000) default '' comment '返寄地址' ,
  create_time datetime default current_timestamp ,
  primary key `id` (`id`)
) engine=innodb character set = utf8mb4 collate = utf8mb4_bin comment '退换货';


drop table if exists `tk_timer_log`;
create table if not exists `tk_timer_log` (
  id int unsigned not null auto_increment ,
  type varchar(500) default 'none' comment '类型：none-无类型' ,
  log text comment '操作日志' ,
  create_time datetime default current_timestamp ,
  primary key `id` (`id`)
) engine=innodb character set = utf8mb4 collate = utf8mb4_bin comment '定时器操作日志';

drop table if exists `tk_administrator`;
create table if not exists `tk_administrator` (
  `id` int unsigned not null auto_increment,
  username varchar(255) default '' comment '角色名称',
  password varchar(255) default '' comment '密码' ,
  avatar varchar(500) default '' comment '头像' ,
  role_id int unsigned default 0 comment 'tk_role.id' ,
  is_root tinyint unsigned default 0 comment '是否超级管理员：0-否 1-是' ,
  last_ip varchar(255) default '' comment '最后一次登录 ip' ,
  last_time datetime default null comment '最近一次登录时间' ,
  `number` int unsigned default 0 comment '登录次数' ,
  status tinyint unsigned default 1 comment '账号状态：1-正常 2-锁定 3-禁用' ,
  update_time datetime default current_timestamp on update current_timestamp ,
  `create_time` datetime default current_timestamp ,
  primary key `id` (`id`)
) engine=innodb character set = utf8mb4 collate = utf8mb4_bin comment '管理员表';

drop table if exists `tk_role`;
create table if not exists `tk_role` (
  `id` int unsigned not null auto_increment,
  `name` varchar(255) default '' comment '角色名称',
  `weight` smallint default '0' comment '权重',
  `create_time` datetime default current_timestamp ,
  primary key `id` (`id`)
) engine=innodb character set = utf8mb4 collate = utf8mb4_bin comment '角色表';

drop table if exists `tk_route`;
create table if not exists `tk_route` (
  `id` int unsigned not null auto_increment,
  `cn` varchar(50) default '' comment '中文名称',
  `en` varchar(50) default '' comment '英文名称',
  `route` varchar(255) default '' comment '路由，例如：/admin/Login/loginView',
  `s_ico` varchar(500)  default '' comment '小图标',
  `b_ico` varchar(500)  default '' comment '大图标',
  `type` varchar(255) default 'api' comment '路由类型：api-接口;view-视图',
  `menu` tinyint unsigned  default 0 comment '是否菜单 0-否；1-是',
  `p_id` int(11) default '0' comment '上级id，tk_route.id',
  enable tinyint unsigned default 1 comment '是否启用：0-不启用 1-启用' ,
  `weight` smallint default '0' comment '权重',
  `create_time` datetime default current_timestamp comment '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) engine=innodb character set = utf8mb4 collate = utf8mb4_bin comment '路由表';

drop table if exists `tk_role_route`;
create table if not exists `tk_role_route` (
  `id` int unsigned not null auto_increment,
  `role_id` int unsigned default 0 comment 'tk_role.id',
  `route_id` int unsigned default 0 comment 'route_id.id',
  `create_time` datetime default current_timestamp ,
  primary key `id` (`id`)
) engine=innodb character set = utf8mb4 collate = utf8mb4_bin comment '角色-路由-关联表';

drop table if exists `tk_system_param`;
create table if not exists `tk_system_param` (
  id int unsigned not null auto_increment,
  name varchar(500) default '' comment '名称' ,
  `desc` varchar(500) default '' comment '描述' ,
  `key` varchar(255) default '' comment 'key' ,
  `value` varchar(500) default '' comment 'value' ,
  update_time datetime default current_timestamp on update current_timestamp ,
  create_time datetime default current_timestamp ,
  primary key `id` (`id`)
) engine=innodb character set = utf8mb4 collate = utf8mb4_bin comment '系统参数表';

-- 无效的表
drop table if exists `tk_user_token`;

drop table if exists `tk_goods_logistics`;
create table if not exists `tk_goods_logistics` (
  id int unsigned not null auto_increment,
  user_id int unsigned default 0 comment 'tk_user.id' ,
  goods_order_id int unsigned default 0 comment 'tk_goods_order.id' ,
  status tinyint unsigned unsigned default 0 comment '物流状态：1-已接单' ,
  `desc` varchar(1000) default '' comment '物流描述' ,
  create_time datetime default current_timestamp ,
  primary key `id` (`id`)
) engine=innodb character set = utf8mb4 collate = utf8mb4_bin comment '商品物流';

drop table if exists `tk_announcement`;
create table if not exists `tk_announcement` (
  id int unsigned not null auto_increment,
  title varchar(1000) default '' comment '公告标题' ,
  platform_id int unsigned default 0 comment 'tk_platform.id' ,
  content longtext comment '公告内容' ,
  update_time datetime default current_timestamp on update current_timestamp ,
  create_time datetime default current_timestamp ,
  primary key `id` (`id`)
) engine=innodb character set = utf8mb4 collate = utf8mb4_bin comment '公告';

drop table if exists `tk_image`;
create table if not exists `tk_image` (
  id int unsigned not null auto_increment,
  `position` tinyint unsigned default 0 comment '放置位置，具体放置位置含义请在自己的配置文件中定义，这边仅接受 数字值' ,
  platform_id int unsigned default 0 comment 'tk_platform.id' ,
  path longtext comment '图片地址' ,
  create_time datetime default current_timestamp ,
  primary key `id` (`id`)
) engine=innodb character set = utf8mb4 collate = utf8mb4_bin comment '展示图片表';

drop table if exists `tk_platform`;
create table if not exists `tk_platform` (
  id int unsigned not null auto_increment,
  name varchar(255) default '' comment '平台名称' ,
  create_time datetime default current_timestamp ,
  primary key `id` (`id`)
) engine=innodb character set = utf8mb4 collate = utf8mb4_bin comment '平台表';

insert into `tk_platform` (name) values
('pc') ,
('android') ,
('ios') ,
('app');

drop table if exists `tk_channel`;
create table if not exists `tk_channel` (
  id int unsigned not null auto_increment,
  platform_id int unsigned default 0 comment 'tk_platform.id' ,
  name varchar(500) default '' comment '菜单名称' ,
  image varchar(500) default '' comment '图片地址' ,
  link varchar(2000) default '' comment '链接地址' ,
  create_time datetime default current_timestamp ,
  primary key `id` (`id`)
) engine=innodb character set = utf8mb4 collate = utf8mb4_bin comment '频道表';

drop table if exists `tk_spike`;
create table if not exists `tk_spike` (
  id int unsigned not null auto_increment,
  title varchar(1000) default '' comment '标题' ,
  start_time datetime default null comment '开始时间' ,
  duration int default 0 comment '秒杀持续时长，单位：秒' ,
  end_time datetime default null comment '结束时间' ,
  create_time datetime default current_timestamp ,
  primary key `id` (`id`)
) engine=innodb character set = utf8mb4 collate = utf8mb4_bin comment '活动-秒杀';

drop table if exists `tk_spike_goods`;
create table if not exists `tk_spike_goods` (
  id int unsigned not null auto_increment ,
  spike_id int unsigned default 0 comment 'tk_spike.id' ,
  user_id int unsigned default 0 comment 'tk_user.id，实际上就是商家id（由普通用户升级成为商家）' ,
  goods_id int unsigned default 0 comment '' ,
  create_time datetime default current_timestamp ,
  primary key `id` (`id`)
) engine=innodb character set = utf8mb4 collate = utf8mb4_bin comment '活动-秒杀商品';

drop table if exists `tk_brand`;
create table if not exists `tk_brand` (
  id int unsigned not null auto_increment ,
  category_id int unsigned default 0 comment 'tk_category.id' ,
  name varchar(500) default '' comment '品牌名称' ,
  image varchar(1000) default '' comment '品牌图片' ,
  weight smallint unsigned default 0 comment '权重' ,
  letter varchar(255) default '' comment '字母' ,
  hot tinyint unsigned default 0 comment '是否热门' ,
  enable tinyint unsigned default 1 comment '启用？：0-否 1-是' ,
  `desc` varchar(1000) default '' comment '描述' ,
  create_time datetime default current_timestamp ,
  primary key `id` (`id`)
) engine=innodb character set = utf8mb4 collate = utf8mb4_bin comment '品牌表';

drop table if exists `tk_subject`;
create table if not exists `tk_subject` (
  id int unsigned not null auto_increment ,
  title varchar(500) default '' comment '标题' ,
  thumb varchar(1000) default '' comment '封面名称' ,
  link varchar(500) default '' comment '专题跳转地址' ,
  api varchar(500) default '' comment '专题数据接口' ,
  create_time datetime default current_timestamp ,
  primary key `id` (`id`)
) engine=innodb character set = utf8mb4 collate = utf8mb4_bin comment '专题表';

drop table if exists `tk_subject_image`;
create table if not exists `tk_subject_image` (
  id int unsigned not null auto_increment ,
  subject_id int unsigned default 0 comment 'tk_subject.id' ,
  path varchar(1000) default '' comment '图片地址' ,
  create_time datetime default current_timestamp ,
  primary key `id` (`id`)
) engine=innodb character set = utf8mb4 collate = utf8mb4_bin comment '专题图片表';