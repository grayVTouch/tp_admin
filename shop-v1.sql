/*
 Navicat Premium Data Transfer

 Source Server         : local
 Source Server Type    : MySQL
 Source Server Version : 80012
 Source Host           : localhost:3306
 Source Schema         : shop

 Target Server Type    : MySQL
 Target Server Version : 80012
 File Encoding         : 65001

 Date: 21/07/2019 16:04:31
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for tp_administrator
-- ----------------------------
DROP TABLE IF EXISTS `tp_administrator`;
CREATE TABLE `tp_administrator`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT '角色名称',
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT '密码',
  `avatar` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT '头像',
  `role_id` int(10) UNSIGNED NULL DEFAULT 0 COMMENT 'tk_role.id',
  `is_root` tinyint(4) NULL DEFAULT 0 COMMENT '是否超级管理员：0-否 1-是',
  `last_ip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT '最后一次登录 ip',
  `last_time` datetime(0) NULL DEFAULT NULL COMMENT '最近一次登录时间',
  `number` int(10) UNSIGNED NULL DEFAULT 0 COMMENT '登录次数',
  `status` tinyint(4) NULL DEFAULT 1 COMMENT '账号状态：1-正常 2-锁定 3-禁用',
  `update_time` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0),
  `create_time` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_bin COMMENT = '管理员表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tp_administrator
-- ----------------------------
INSERT INTO `tp_administrator` VALUES (1, 'admin', '$2y$10$Y9he/ChopYzEGHTyQqyBr.QxV46V2ARjLp4TY6j0jtRO.OMFvlG2y', '', 1, 1, '127.0.0.1', '2019-07-21 16:01:26', 6, 1, '2019-07-21 16:01:26', '2019-07-17 18:10:20');

-- ----------------------------
-- Table structure for tp_category
-- ----------------------------
DROP TABLE IF EXISTS `tp_category`;
CREATE TABLE `tp_category`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT '分类名称',
  `desc` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT '分类描述',
  `image` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT '分类图片',
  `p_id` int(10) UNSIGNED NULL DEFAULT 0 COMMENT 'tk_category.id,上级分类id',
  `update_time` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0),
  `create_time` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 16 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_bin COMMENT = '分类表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tp_category
-- ----------------------------
INSERT INTO `tp_category` VALUES (1, '测试分类', '', '20190719/1875a4dce4218be5717a378b5dd16e4c.png', 1, '2019-07-19 20:09:21', '2019-07-19 16:27:37');
INSERT INTO `tp_category` VALUES (2, '人才', '滚', '20190719/a7767703a706444a697b172f8f01d328.png', 2, '2019-07-19 20:09:11', '2019-07-19 16:29:13');

-- ----------------------------
-- Table structure for tp_goods
-- ----------------------------
DROP TABLE IF EXISTS `tp_goods`;
CREATE TABLE `tp_goods`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT '商品名称',
  `merchant_id` int(10) UNSIGNED NULL DEFAULT 0 COMMENT 'tk_merchant.id',
  `thumb` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT '商品封面图',
  `detail` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL COMMENT '商品详情',
  `package_list` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT '包装清单',
  `price` decimal(13, 2) NULL DEFAULT 0.00 COMMENT '价格',
  `stock` int(10) UNSIGNED NULL DEFAULT 0 COMMENT '库存',
  `min_price` decimal(13, 2) NULL DEFAULT 0.00 COMMENT '最小金额',
  `max_price` decimal(13, 2) NULL DEFAULT 0.00 COMMENT '最高金额',
  `has_option` tinyint(4) NULL DEFAULT 0 COMMENT '是否有选项：0-否 1-是',
  `update_time` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0),
  `create_time` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_bin COMMENT = '商品表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tp_goods_option
-- ----------------------------
DROP TABLE IF EXISTS `tp_goods_option`;
CREATE TABLE `tp_goods_option`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `goods_id` int(10) UNSIGNED NULL DEFAULT 0 COMMENT 'tk_goods.id',
  `goods_option_group_id` int(10) UNSIGNED NULL DEFAULT 0 COMMENT 'tk_goods_option_group.id',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT '选项名称',
  `desc` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT '描述',
  `image` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT '图片',
  `enable_preview` tinyint(4) NULL DEFAULT 0 COMMENT '是否开启选项图片预览：0-否 1-是',
  `enable` tinyint(4) NULL DEFAULT 1 COMMENT '是否启用：0-不启用 1-启用',
  `create_time` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_bin COMMENT = '商品-选项-关联表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tp_goods_option_group
-- ----------------------------
DROP TABLE IF EXISTS `tp_goods_option_group`;
CREATE TABLE `tp_goods_option_group`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT '分组名称',
  `create_time` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_bin COMMENT = '商品选项分组表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tp_goods_option_list
-- ----------------------------
DROP TABLE IF EXISTS `tp_goods_option_list`;
CREATE TABLE `tp_goods_option_list`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `goods_id` int(10) UNSIGNED NULL DEFAULT 0 COMMENT 'tk_goods.id，缓存字段',
  `price` decimal(13, 2) NULL DEFAULT 0.00 COMMENT '价格',
  `stock` int(10) UNSIGNED NULL DEFAULT 0 COMMENT '库存',
  `create_time` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_bin COMMENT = '商品不同选项对应的价格|库存等表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tp_goods_option_list_option
-- ----------------------------
DROP TABLE IF EXISTS `tp_goods_option_list_option`;
CREATE TABLE `tp_goods_option_list_option`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `goods_id` int(10) UNSIGNED NULL DEFAULT 0 COMMENT 'tk_goods.id，缓存字段',
  `goods_option_list_id` int(10) UNSIGNED NULL DEFAULT 0 COMMENT 'tk_goods_option_list.id',
  `goods_option_id` int(10) UNSIGNED NULL DEFAULT 0 COMMENT 'tk_goods_option.id',
  `create_time` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_bin COMMENT = '固定选项商品具备的选项表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tp_goods_option_relation
-- ----------------------------
DROP TABLE IF EXISTS `tp_goods_option_relation`;
CREATE TABLE `tp_goods_option_relation`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `goods_id` int(10) UNSIGNED NULL DEFAULT 0 COMMENT 'tk_goods.id',
  `goods_option_id` int(10) UNSIGNED NULL DEFAULT 0 COMMENT 'tk_goods_option.id',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT '选项名称',
  `desc` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT '描述',
  `image` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT '图片',
  `enable_preview` tinyint(4) NULL DEFAULT 0 COMMENT '是否开启选项图片预览：0-否 1-是',
  `enable` tinyint(4) NULL DEFAULT 1 COMMENT '是否启用：0-不启用 1-启用',
  `create_time` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_bin COMMENT = '商品-选项-关联表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tp_goods_order
-- ----------------------------
DROP TABLE IF EXISTS `tp_goods_order`;
CREATE TABLE `tp_goods_order`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NULL DEFAULT 0 COMMENT 'tk_user.user_id',
  `order_no` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT '订单号',
  `price` decimal(13, 2) NULL DEFAULT 0.00 COMMENT '价格',
  `p_id` int(10) UNSIGNED NULL DEFAULT 0 COMMENT 'tk_goods_order.id，上级订单id',
  `update_time` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0),
  `create_time` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_bin COMMENT = '商品订单表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tp_goods_order_goods
-- ----------------------------
DROP TABLE IF EXISTS `tp_goods_order_goods`;
CREATE TABLE `tp_goods_order_goods`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NULL DEFAULT 0 COMMENT 'tk_user.user_id，缓存字段',
  `tk_id` int(10) UNSIGNED NULL DEFAULT 0 COMMENT 'tk_shop.id，缓存字段',
  `goods_id` int(10) UNSIGNED NULL DEFAULT 0 COMMENT 'tk_goods.id',
  `name` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT '商品名称-缓存字段',
  `thumb` int(10) UNSIGNED NULL DEFAULT 0 COMMENT '商品封面图-缓存字段',
  `price` decimal(13, 2) NULL DEFAULT 0.00 COMMENT '商品价格-缓存字段',
  `number` int(10) UNSIGNED NULL DEFAULT 0 COMMENT '购买数量',
  `has_option` tinyint(4) NULL DEFAULT 0 COMMENT '是否有选项：0-没有 1-有 ，缓存字段',
  `goods_option` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL COMMENT '商品选项，字符串描述；用以展示用',
  `goods_option_id` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT 'json 字符串，按照从小到大顺序保存，tp_goods_option.id ',
  `update_time` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0),
  `create_time` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_bin COMMENT = '商品订单表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tp_goods_specification
-- ----------------------------
DROP TABLE IF EXISTS `tp_goods_specification`;
CREATE TABLE `tp_goods_specification`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `goods_id` int(10) UNSIGNED NULL DEFAULT 0 COMMENT 'tk_goods.id',
  `specification_id` int(10) UNSIGNED NULL DEFAULT 0 COMMENT 'tk_specification.id',
  `create_time` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_bin COMMENT = '商品-规格-关联表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tp_merchant
-- ----------------------------
DROP TABLE IF EXISTS `tp_merchant`;
CREATE TABLE `tp_merchant`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT '店铺名称',
  `user_id` int(10) UNSIGNED NULL DEFAULT 0 COMMENT 'tk_user.user_id',
  `image` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT '店铺封面图',
  `is_ok` tinyint(4) NULL DEFAULT 0 COMMENT '商家审核是否通过：1-审核不通过 2-审核通过',
  `status` tinyint(4) NULL DEFAULT 1 COMMENT '商家状态：1-正常 2-锁定',
  `type` tinyint(4) NULL DEFAULT 3 COMMENT '1-自营店铺 2-合作店铺（同 店家 与 天猫的关系） 3-普通店铺',
  `update_time` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0),
  `create_time` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_bin COMMENT = '商家表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tp_merchant_application
-- ----------------------------
DROP TABLE IF EXISTS `tp_merchant_application`;
CREATE TABLE `tp_merchant_application`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `merchant_id` int(10) UNSIGNED NULL DEFAULT 0 COMMENT 'tk_merchant.id',
  `status` tinyint(4) NULL DEFAULT 0 COMMENT '1-审核中 2-申请通过 3-审核不通过',
  `remark` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT '审核结果说明，每次用户修改申请后，该字段值都需要清空',
  `update_time` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0),
  `create_time` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_bin COMMENT = '商家申请表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tp_merchant_image
-- ----------------------------
DROP TABLE IF EXISTS `tp_merchant_image`;
CREATE TABLE `tp_merchant_image`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `merchant_id` int(10) UNSIGNED NULL DEFAULT 0 COMMENT 'tk_merchant.id',
  `path` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT '店铺详情图片',
  `create_time` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_bin COMMENT = '商家图片表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tp_operation_log
-- ----------------------------
DROP TABLE IF EXISTS `tp_operation_log`;
CREATE TABLE `tp_operation_log`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NULL DEFAULT 0 COMMENT 'tk_admin_user.id，操作者用户id',
  `type` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT '日志类型: common-普通日志 order-订单日志',
  `log` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL COMMENT '操作日志，请具体说明操作内容',
  `create_time` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_bin COMMENT = '操作日志' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tp_operation_log
-- ----------------------------
INSERT INTO `tp_operation_log` VALUES (1, 1, 'common', '修改平台用户【1】状态由正常【1】到 【2】', '2019-07-18 18:01:31');
INSERT INTO `tp_operation_log` VALUES (2, 1, 'common', '修改平台用户【1】状态由正常【1】到 【2】', '2019-07-18 18:01:44');
INSERT INTO `tp_operation_log` VALUES (3, 1, 'common', '修改平台用户【1】状态由正常【1】到 【2】', '2019-07-18 18:02:53');
INSERT INTO `tp_operation_log` VALUES (4, 1, 'common', '修改平台用户【1】状态由正常【1】到 【2】', '2019-07-18 18:02:58');
INSERT INTO `tp_operation_log` VALUES (5, 1, 'common', '修改平台用户【1】状态由正常【1】到 【2】', '2019-07-18 18:03:02');
INSERT INTO `tp_operation_log` VALUES (6, 1, 'common', '修改平台用户【1】状态由正常【1】到 【2】', '2019-07-18 18:05:39');
INSERT INTO `tp_operation_log` VALUES (7, 1, 'common', '修改平台用户【1】状态由锁定【2】到 【1】', '2019-07-18 18:05:41');
INSERT INTO `tp_operation_log` VALUES (8, 1, 'common', '修改平台用户【1】状态由正常【1】到 【2】', '2019-07-19 11:41:45');
INSERT INTO `tp_operation_log` VALUES (9, 1, 'common', '修改平台用户【1】状态由锁定【2】到 【1】', '2019-07-19 11:41:49');

-- ----------------------------
-- Table structure for tp_return_goods
-- ----------------------------
DROP TABLE IF EXISTS `tp_return_goods`;
CREATE TABLE `tp_return_goods`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NULL DEFAULT 0 COMMENT 'tk_user.user_id',
  `service_no` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT '服务单号',
  `goods_id` int(10) UNSIGNED NULL DEFAULT 0 COMMENT 'tk_goods.id，缓存字段',
  `tk_id` int(10) UNSIGNED NULL DEFAULT 0 COMMENT 'tk_shop.id，缓存字段',
  `goods_order_goods_id` int(10) UNSIGNED NULL DEFAULT 0 COMMENT 'tk_goods_order_goods.id 订单商品id',
  `type` tinyint(4) NULL DEFAULT 1 COMMENT '类型：1-退货 2-换货 3-维修',
  `reason` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT '退换货原因',
  `status` tinyint(4) NULL DEFAULT 1 COMMENT '状态：1-审核中 2-同意售后 3-拒绝售后 4-关闭 5-已完成 6-已评价',
  `remark` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT '审核意见，仅允许商家填写',
  `return_address` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT '返寄地址',
  `create_time` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_bin COMMENT = '退换货' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tp_role
-- ----------------------------
DROP TABLE IF EXISTS `tp_role`;
CREATE TABLE `tp_role`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT '角色名称',
  `weight` smallint(6) NULL DEFAULT 0 COMMENT '权重',
  `create_time` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_bin COMMENT = '角色表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tp_role
-- ----------------------------
INSERT INTO `tp_role` VALUES (1, '超级管理员', 0, '2019-07-17 18:10:56');
INSERT INTO `tp_role` VALUES (2, '管理员', 0, '2019-07-17 18:11:05');

-- ----------------------------
-- Table structure for tp_role_route
-- ----------------------------
DROP TABLE IF EXISTS `tp_role_route`;
CREATE TABLE `tp_role_route`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_id` int(10) UNSIGNED NULL DEFAULT 0 COMMENT 'tk_role.id',
  `route_id` int(10) UNSIGNED NULL DEFAULT 0 COMMENT 'route_id.id',
  `create_time` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_bin COMMENT = '角色-路由-关联表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tp_route
-- ----------------------------
DROP TABLE IF EXISTS `tp_route`;
CREATE TABLE `tp_route`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cn` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT '中文名称',
  `en` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT '英文名称',
  `route` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT '路由，例如：/admin/Login/loginView',
  `s_ico` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT '小图标',
  `b_ico` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT '大图标',
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT 'api' COMMENT '路由类型：api-接口;view-视图',
  `menu` tinyint(4) NULL DEFAULT 0 COMMENT '是否菜单 0-否；1-是',
  `p_id` int(11) NULL DEFAULT 0 COMMENT '上级id，tp_route.id',
  `enable` tinyint(4) NULL DEFAULT 1 COMMENT '是否启用：0-不启用 1-启用',
  `weight` smallint(6) NULL DEFAULT 0 COMMENT '权重',
  `create_time` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP(0) COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_bin COMMENT = '路由表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tp_route
-- ----------------------------
INSERT INTO `tp_route` VALUES (1, '登录/注册', '', '/admin/login/loginView', '', '', 'view', 0, 0, 0, 0, '2019-07-17 17:06:35');
INSERT INTO `tp_route` VALUES (2, '控制台', 'Control', '/admin/index/indexView', '', '', 'view', 1, 0, 1, 0, '2019-07-17 18:20:59');
INSERT INTO `tp_route` VALUES (3, '用户管理', 'User', '', '', '', 'view', 1, 0, 1, 0, '2019-07-17 18:29:39');
INSERT INTO `tp_route` VALUES (4, '商品分类', 'Category', '', '', '', 'view', 1, 0, 1, 0, '2019-07-17 18:29:56');
INSERT INTO `tp_route` VALUES (5, '订单管理', 'Order', '', '', '', 'view', 1, 0, 1, 0, '2019-07-17 18:30:28');
INSERT INTO `tp_route` VALUES (6, '公告管理', 'Announcement', '', '', '', 'view', 1, 0, 1, 0, '2019-07-17 18:31:50');
INSERT INTO `tp_route` VALUES (7, '商家管理', 'Shop', '', '', '', 'view', 1, 0, 1, 0, '2019-07-17 18:32:21');
INSERT INTO `tp_route` VALUES (8, '系统设置', 'System', '', '', '', 'view', 1, 0, 1, 0, '2019-07-17 18:32:30');
INSERT INTO `tp_route` VALUES (9, '用户列表', '', '/admin/user/listView', '', '', 'view', 1, 3, 1, 0, '2019-07-17 18:33:38');
INSERT INTO `tp_route` VALUES (10, '申请列表', '', '/admin/merchant_application/listView', '', '', 'view', 1, 7, 1, 0, '2019-07-17 18:35:05');
INSERT INTO `tp_route` VALUES (11, '商家列表', '', '/admin/merchant/listView', '', '', 'view', 1, 7, 1, 0, '2019-07-17 18:35:26');
INSERT INTO `tp_route` VALUES (12, '公告列表', '', '/admin/announcement/listView', '', '', 'view', 1, 6, 1, 0, '2019-07-17 18:35:53');
INSERT INTO `tp_route` VALUES (13, '分类列表', '', '/admin/category/listView', '', '', 'view', 1, 4, 1, 0, '2019-07-17 18:37:28');
INSERT INTO `tp_route` VALUES (14, '订单列表', '', '/admin/goods_order/listView', '', '', 'view', 1, 5, 1, 0, '2019-07-17 18:38:04');
INSERT INTO `tp_route` VALUES (15, '系统参数', '', '/admin/system_param/listView', '', '', 'view', 1, 8, 1, 0, '2019-07-17 18:41:17');
INSERT INTO `tp_route` VALUES (16, '添加商品分类', '', '/admin/category/addView', '', '', 'view', 0, 13, 1, 0, '2019-07-19 11:38:15');
INSERT INTO `tp_route` VALUES (17, '编辑商品分类', '', '/admin/category/editView', '', '', 'view', 0, 13, 1, 0, '2019-07-19 17:38:44');

-- ----------------------------
-- Table structure for tp_specification
-- ----------------------------
DROP TABLE IF EXISTS `tp_specification`;
CREATE TABLE `tp_specification`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT '规格名称',
  `merchant_id` int(10) UNSIGNED NULL DEFAULT 0 COMMENT 'tk_merchant.id',
  `thumb` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT '商品封面图',
  `detail` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL COMMENT '商品详情',
  `update_time` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0),
  `create_time` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_bin COMMENT = '规格表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tp_specification_group
-- ----------------------------
DROP TABLE IF EXISTS `tp_specification_group`;
CREATE TABLE `tp_specification_group`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT '分组名称',
  `create_time` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_bin COMMENT = '规格分组表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tp_system_param
-- ----------------------------
DROP TABLE IF EXISTS `tp_system_param`;
CREATE TABLE `tp_system_param`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT '名称',
  `desc` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT '描述',
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT 'key',
  `value` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT 'value',
  `update_time` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0),
  `create_time` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_bin COMMENT = '系统参数表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tp_timer_log
-- ----------------------------
DROP TABLE IF EXISTS `tp_timer_log`;
CREATE TABLE `tp_timer_log`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT 'none' COMMENT '类型：none-无类型',
  `log` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL COMMENT '操作日志',
  `create_time` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_bin COMMENT = '定时器操作日志' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tp_user
-- ----------------------------
DROP TABLE IF EXISTS `tp_user`;
CREATE TABLE `tp_user`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NULL DEFAULT 0 COMMENT '远程用户id，请使用这个 id 作为 用户 id',
  `type` tinyint(4) NULL DEFAULT 1 COMMENT '用户类型：1-用户 2-商家',
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT '密码',
  `sex` tinyint(4) NULL DEFAULT 0 COMMENT '性别: 0-未知 1-男人 2-女人 3-两性',
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT '手机号码',
  `country_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT '国家代码',
  `avatar` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT '头像',
  `birthday` date NULL DEFAULT NULL COMMENT '生日',
  `status` tinyint(4) NULL DEFAULT 1 COMMENT '账号状态：1-正常 2-锁定',
  `update_time` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0),
  `create_time` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_bin COMMENT = '用户表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tp_user
-- ----------------------------
INSERT INTO `tp_user` VALUES (1, 1, 1, 'test', '', 0, '13375086826', '86', '', '2019-07-18', 1, '2019-07-19 11:41:49', '2019-07-18 12:07:20');

-- ----------------------------
-- Table structure for tp_user_balance
-- ----------------------------
DROP TABLE IF EXISTS `tp_user_balance`;
CREATE TABLE `tp_user_balance`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NULL DEFAULT 0 COMMENT '远程用户id，请使用这个 id 作为 用户 id',
  `balance` decimal(13, 2) NULL DEFAULT 0.00 COMMENT '用户余额',
  `update_time` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0),
  `create_time` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_bin COMMENT = '用户余额表' ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
