/*
 Navicat Premium Data Transfer

 Source Server         : 聊天-红包游戏
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : rm-t4n09e14u6vu17533io.mysql.singapore.rds.aliyuncs.com:3306
 Source Schema         : mchat_gamming

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 22/04/2020 10:06:24
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for cq_administrator
-- ----------------------------
DROP TABLE IF EXISTS `cq_administrator`;
CREATE TABLE `cq_administrator`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT '角色名称',
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT '密码',
  `avatar` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT '头像',
  `role_id` int(10) UNSIGNED NULL DEFAULT 0 COMMENT 'tk_role.id',
  `is_root` tinyint(3) UNSIGNED NULL DEFAULT 0 COMMENT '是否超级管理员：0-否 1-是',
  `last_ip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT '最后一次登录 ip',
  `last_time` datetime(0) NULL DEFAULT NULL COMMENT '最近一次登录时间',
  `number` int(10) UNSIGNED NULL DEFAULT 0 COMMENT '登录次数',
  `status` tinyint(3) UNSIGNED NULL DEFAULT 1 COMMENT '账号状态：1-正常 2-锁定 3-禁用',
  `update_time` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0),
  `create_time` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_bin COMMENT = '管理员表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cq_administrator
-- ----------------------------
INSERT INTO `cq_administrator` VALUES (1, 'admin', '$2y$10$JVkjMlUUMazRf6TrXMzLuOOE7WchtU/cPGTVreYU8ZMqTxksnomgS', 'http://combi.oss-ap-southeast-1.aliyuncs.com/lucky/20190828/68e4dcfce657d4680d81180a8117011a.jpg', 5, 1, '127.0.0.1', '2020-04-22 10:01:01', 184, 1, '2020-04-22 10:01:01', '2019-08-27 15:29:36');

-- ----------------------------
-- Table structure for cq_app
-- ----------------------------
DROP TABLE IF EXISTS `cq_app`;
CREATE TABLE `cq_app`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` char(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT '名称',
  `thumb` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT '封面',
  `ios_link` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT 'ios 下载链接',
  `android_link` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT 'android 下载链接',
  `android_wakeup_link` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT 'android 唤醒链接',
  `ios_wakeup_link` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT 'ios 唤醒链接',
  `is_app` tinyint(4) NULL DEFAULT 0 COMMENT '是否 app： 0-否 1-是',
  `link` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT '外部链接',
  `weight` smallint(6) NULL DEFAULT 0 COMMENT '权重',
  `create_time` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_bin COMMENT = '应用表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for cq_role
-- ----------------------------
DROP TABLE IF EXISTS `cq_role`;
CREATE TABLE `cq_role`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT '角色名称',
  `weight` smallint(6) NULL DEFAULT 0 COMMENT '权重',
  `create_time` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_bin COMMENT = '角色表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cq_role
-- ----------------------------
INSERT INTO `cq_role` VALUES (5, 'fsds', 0, '2019-11-22 15:57:24');

-- ----------------------------
-- Table structure for cq_role_route
-- ----------------------------
DROP TABLE IF EXISTS `cq_role_route`;
CREATE TABLE `cq_role_route`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_id` int(10) UNSIGNED NULL DEFAULT 0 COMMENT 'tk_role.id',
  `route_id` int(10) UNSIGNED NULL DEFAULT 0 COMMENT 'route_id.id',
  `create_time` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 29 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_bin COMMENT = '角色-路由-关联表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cq_role_route
-- ----------------------------
INSERT INTO `cq_role_route` VALUES (19, 1, 8, '2019-08-28 15:48:10');
INSERT INTO `cq_role_route` VALUES (20, 1, 7, '2019-08-28 15:48:10');
INSERT INTO `cq_role_route` VALUES (21, 1, 3, '2019-08-28 15:48:10');
INSERT INTO `cq_role_route` VALUES (22, 1, 4, '2019-08-28 15:48:10');
INSERT INTO `cq_role_route` VALUES (23, 1, 2, '2019-08-28 15:48:10');
INSERT INTO `cq_role_route` VALUES (24, 2, 8, '2019-08-28 16:04:29');
INSERT INTO `cq_role_route` VALUES (25, 2, 9, '2019-08-28 16:04:29');
INSERT INTO `cq_role_route` VALUES (26, 2, 7, '2019-08-28 16:04:29');
INSERT INTO `cq_role_route` VALUES (27, 2, 5, '2019-08-28 16:04:29');
INSERT INTO `cq_role_route` VALUES (28, 2, 6, '2019-08-28 16:04:29');

-- ----------------------------
-- Table structure for cq_route
-- ----------------------------
DROP TABLE IF EXISTS `cq_route`;
CREATE TABLE `cq_route`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cn` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT '中文名称',
  `en` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT '英文名称',
  `route` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT '路由，例如：/admin/Login/loginView',
  `s_ico` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT '小图标',
  `b_ico` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT '大图标',
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT 'api' COMMENT '路由类型：api-接口;view-视图',
  `menu` tinyint(3) UNSIGNED NULL DEFAULT 0 COMMENT '是否菜单 0-否；1-是',
  `p_id` int(11) NULL DEFAULT 0 COMMENT '上级id，tk_route.id',
  `enable` tinyint(3) UNSIGNED NULL DEFAULT 1 COMMENT '是否启用：0-不启用 1-启用',
  `weight` smallint(6) NULL DEFAULT 0 COMMENT '权重',
  `create_time` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP(0) COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 101 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_bin COMMENT = '路由表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cq_route
-- ----------------------------
INSERT INTO `cq_route` VALUES (0, '用户审核', '', '/admin/user/userAuth', '', '', 'view', 1, 3, 0, 0, '2019-08-27 15:32:36');
INSERT INTO `cq_route` VALUES (1, '登录', '', '/admin/login/loginView', '', '', 'view', 0, 0, 1, 0, '2019-08-27 15:28:47');
INSERT INTO `cq_route` VALUES (2, '控制台', 'Control', '/admin/index/indexView', '', '', 'view', 1, 0, 1, 0, '2019-08-27 15:29:10');
INSERT INTO `cq_route` VALUES (3, '用户管理', 'User', '', '', '', 'view', 1, 0, 1, 0, '2019-08-27 15:32:20');
INSERT INTO `cq_route` VALUES (4, '用户列表', '', '/admin/user/listView', '', '', 'view', 1, 3, 1, 0, '2019-08-27 15:32:36');
INSERT INTO `cq_route` VALUES (5, '后台用户', 'Adminstrator', '', '', '', 'view', 1, 0, 1, 0, '2019-08-27 15:33:31');
INSERT INTO `cq_route` VALUES (6, '用户列表', '', '/admin/admin/listView', '', '', 'view', 1, 5, 1, 0, '2019-08-27 15:33:51');
INSERT INTO `cq_route` VALUES (7, '角色列表', '', '/admin/role/listView', '', '', 'view', 1, 8, 1, 0, '2019-08-27 15:34:24');
INSERT INTO `cq_route` VALUES (8, '权限管理', 'Privilege', '', '', '', 'view', 1, 0, 1, 0, '2019-08-27 15:35:13');
INSERT INTO `cq_route` VALUES (9, '权限列表', '', '/admin/privilege/listView', '', '', 'view', 1, 8, 0, 0, '2019-08-27 15:35:32');
INSERT INTO `cq_route` VALUES (10, '资金管理', 'Fund', '', '', '', 'view', 1, 0, 1, 0, '2019-08-27 15:36:12');
INSERT INTO `cq_route` VALUES (11, '资金记录', '', '/admin/balance_record/listView', '', '', 'view', 1, 10, 1, 0, '2019-08-27 15:36:37');
INSERT INTO `cq_route` VALUES (12, '添加用户', '', '/admin/admin/addView', '', '', 'view', 0, 6, 0, 0, '2019-08-28 09:39:49');
INSERT INTO `cq_route` VALUES (13, '编辑用户', '', '/admin/admin/editView', '', '', 'view', 0, 6, 0, 0, '2019-08-28 09:40:05');
INSERT INTO `cq_route` VALUES (14, '添加角色', '', '/admin/role/addView', '', '', 'view', 0, 7, 1, 0, '2019-08-28 11:11:14');
INSERT INTO `cq_route` VALUES (15, '编辑角色', '', '/admin/role/editView', '', '', 'view', 0, 7, 1, 0, '2019-08-28 11:11:27');
INSERT INTO `cq_route` VALUES (16, '添加权限', '', '/admin/privilege/addView', '', '', 'view', 0, 9, 1, 0, '2019-08-28 11:11:50');
INSERT INTO `cq_route` VALUES (17, '编辑权限', '', '/admin/privilege/editView', '', '', 'view', 0, 9, 1, 0, '2019-08-28 11:12:05');
INSERT INTO `cq_route` VALUES (18, '角色权限', '', '/admin/role/privilegeView', '', '', 'view', 0, 7, 0, 0, '2019-08-28 11:38:02');
INSERT INTO `cq_route` VALUES (19, '用户余额', '', '/admin/user_balance/listView', '', '', 'view', 0, 3, 1, 0, '2019-08-28 16:16:35');
INSERT INTO `cq_route` VALUES (20, '币种管理', 'Coin', '', '', '', 'view', 1, 0, 0, 0, '2019-08-28 16:17:54');
INSERT INTO `cq_route` VALUES (21, '币种列表', '', '/admin/coin/listView', '', '', 'view', 1, 20, 0, 0, '2019-08-28 16:18:12');
INSERT INTO `cq_route` VALUES (22, '系统管理', 'System', '', '', '', 'view', 1, 0, 1, 0, '2019-08-28 16:21:59');
INSERT INTO `cq_route` VALUES (23, '系统参数', '', '/admin/system_param/listView', '', '', 'view', 1, 22, 1, 0, '2019-08-28 16:22:24');
INSERT INTO `cq_route` VALUES (24, '用户余额', '', '/admin/user/balanceView', '', '', 'view', 0, 4, 0, 0, '2019-08-29 10:49:04');
INSERT INTO `cq_route` VALUES (25, '游戏管理', 'Game', '', '', '', 'view', 1, 0, 0, 0, '2019-08-29 16:09:08');
INSERT INTO `cq_route` VALUES (26, '理财游戏', '', '/admin/game_profit/listView', '', '', 'view', 1, 62, 0, 0, '2019-08-29 16:11:59');
INSERT INTO `cq_route` VALUES (27, '收益明细', '', '/admin/game_profit_record/listView', '', '', 'view', 1, 25, 0, 0, '2019-08-29 16:12:47');
INSERT INTO `cq_route` VALUES (28, '游戏记录', '', '/admin/game_record/listView', '', '', 'view', 1, 25, 0, 0, '2019-08-29 16:13:17');
INSERT INTO `cq_route` VALUES (29, '提取记录', '', '/admin/game_tq_record/listView', '', '', 'view', 1, 25, 0, 0, '2019-08-29 16:14:27');
INSERT INTO `cq_route` VALUES (30, '社区管理', 'Community', '', '', '', 'view', 1, 0, 1, 0, '2019-08-29 17:09:51');
INSERT INTO `cq_route` VALUES (31, '平台资讯', '', '/admin/community_announce/listView', '', '', 'view', 1, 30, 1, 0, '2019-08-29 17:10:09');
INSERT INTO `cq_route` VALUES (32, '社区轮播', '', '/admin/community_slideshow/listView', '', '', 'view', 1, 30, 1, 0, '2019-08-29 17:10:19');
INSERT INTO `cq_route` VALUES (33, '应用下载', '', '/admin/community/listView', '', '', 'view', 1, 30, 1, 0, '2019-08-29 17:10:42');
INSERT INTO `cq_route` VALUES (34, '编辑应用', '', '/admin/community/editView', '', '', 'view', 0, 33, 1, 0, '2019-08-30 09:53:49');
INSERT INTO `cq_route` VALUES (35, '添加应用', '', '/admin/community/addView', '', '', 'view', 0, 33, 1, 0, '2019-08-30 09:54:05');
INSERT INTO `cq_route` VALUES (36, '编辑图片', '', '/admin/community_slideshow/editView', '', '', 'view', 0, 32, 1, 0, '2019-08-30 10:34:21');
INSERT INTO `cq_route` VALUES (37, '添加图片', '', '/admin/community_slideshow/addView', '', '', 'view', 0, 32, 1, 0, '2019-08-30 10:34:41');
INSERT INTO `cq_route` VALUES (38, '添加社区资讯', '', '/admin/community_announce/addView', '', '', 'view', 0, 31, 1, 0, '2019-08-30 11:14:36');
INSERT INTO `cq_route` VALUES (39, '编辑社区资讯', '', '/admin/community_announce/editView', '', '', 'view', 0, 31, 1, 0, '2019-08-30 11:15:00');
INSERT INTO `cq_route` VALUES (40, '公告管理', 'SystemMessage', '', '', '', 'view', 1, 0, 1, 0, '2019-08-30 13:51:57');
INSERT INTO `cq_route` VALUES (41, '公告列表', '', '/admin/system_message/listView', '', '', 'view', 1, 40, 1, 0, '2019-08-30 13:52:15');
INSERT INTO `cq_route` VALUES (42, '添加系统参数', '', '/admin/system_param/addView', '', '', 'view', 0, 23, 0, 0, '2019-08-30 14:09:27');
INSERT INTO `cq_route` VALUES (43, '编辑系统参数', '', '/admin/system_param/editView', '', '', 'view', 0, 23, 0, 0, '2019-08-30 14:09:43');
INSERT INTO `cq_route` VALUES (44, '币币交易', 'CoinSale', '', '', '', 'view', 1, 0, 0, 0, '2019-08-30 14:40:05');
INSERT INTO `cq_route` VALUES (45, '配置列表', '', '/admin/bb_config/listView', '', '', 'view', 1, 44, 0, 0, '2019-08-30 14:40:52');
INSERT INTO `cq_route` VALUES (46, '交易订单', '', '/admin/bb_order/listView', '', '', 'view', 1, 44, 0, 0, '2019-08-30 14:41:28');
INSERT INTO `cq_route` VALUES (47, '交易记录', '', '/admin/bb_record/listView', '', '', 'view', 1, 44, 0, 0, '2019-08-30 14:42:35');
INSERT INTO `cq_route` VALUES (48, '添加公告', '', '/admin/system_message/addView', '', '', 'view', 0, 41, 1, 0, '2019-08-30 15:18:32');
INSERT INTO `cq_route` VALUES (50, '编辑公告', '', '/admin/system_message/editView', '', '', 'view', 0, 41, 1, 0, '2019-08-30 15:31:15');
INSERT INTO `cq_route` VALUES (51, '编辑用户', '', '/admin/user/editView', '', '', 'view', 0, 6, 0, 0, '2019-08-30 17:35:44');
INSERT INTO `cq_route` VALUES (52, '实名认证', '', '/admin/user/realNameVerifiedView', '', '', 'view', 0, 6, 0, 0, '2019-08-31 09:49:14');
INSERT INTO `cq_route` VALUES (53, '用户关系图', '', '/admin/user/relationView', '', '', 'view', 0, 6, 0, 0, '2019-09-02 11:02:22');
INSERT INTO `cq_route` VALUES (54, 'IM 管理', 'IM', '', '', '', 'view', 1, 0, 0, 0, '2019-09-02 11:44:51');
INSERT INTO `cq_route` VALUES (55, '朋友圈', '', '/admin/friend_circle/listView', '', '', 'view', 1, 54, 0, 0, '2019-09-02 11:45:25');
INSERT INTO `cq_route` VALUES (56, '朋友圈评论', '', '/admin/friend_circle_comment/listView', '', '', 'view', 1, 54, 0, 0, '2019-09-02 14:33:03');
INSERT INTO `cq_route` VALUES (57, '划转管理', '', '', '', '', 'view', 1, 0, 0, 0, '2019-09-04 16:02:24');
INSERT INTO `cq_route` VALUES (58, '划转币种', '', '/admin/wallet_to_coin/listView', '', '', 'view', 1, 57, 0, 0, '2019-09-04 16:02:35');
INSERT INTO `cq_route` VALUES (59, '编辑划转', '', '/admin/wallet_to_coin/editView', '', '', 'view', 0, 58, 0, 0, '2019-09-04 16:16:16');
INSERT INTO `cq_route` VALUES (60, '添加划转', '', '/admin/wallet_to_coin/addView', '', '', 'view', 0, 58, 0, 0, '2019-09-04 16:16:33');
INSERT INTO `cq_route` VALUES (61, '转入统计', '', '/admin/wallet_recv/listView', '', '', 'view', 1, 57, 0, 0, '2019-09-06 14:10:50');
INSERT INTO `cq_route` VALUES (62, '数据统计', 'Statistics', '', '', '', 'view', 1, 0, 0, 0, '2019-09-06 14:50:45');
INSERT INTO `cq_route` VALUES (63, '累计统计', '', '/admin/statistics/indexView', '', '', 'view', 1, 62, 0, 0, '2019-09-09 10:18:23');
INSERT INTO `cq_route` VALUES (66, '我的客服', '', '/admin/customer_service/listView', '', '', 'view', 1, 22, 0, 0, '2019-09-16 11:47:57');
INSERT INTO `cq_route` VALUES (67, '编辑客服', '', '/admin/customer_service/editView', '', '', 'view', 0, 66, 0, 0, '2019-09-16 11:48:25');
INSERT INTO `cq_route` VALUES (68, '添加客服', '', '/admin/customer_service/addView', '', '', 'view', 0, 66, 0, 0, '2019-09-16 11:48:40');
INSERT INTO `cq_route` VALUES (69, '翻译管理', '', '', '', '', 'view', 1, 0, 0, 0, '2019-09-17 09:41:47');
INSERT INTO `cq_route` VALUES (70, '翻译列表', '', '/admin/translation/listView', '', '', 'view', 1, 69, 0, 0, '2019-09-17 09:42:07');
INSERT INTO `cq_route` VALUES (71, '编辑翻译', '', '/admin/translation/editView', '', '', 'view', 0, 70, 0, 0, '2019-09-17 09:42:29');
INSERT INTO `cq_route` VALUES (72, '添加翻译', '', '/admin/translation/addView', '', '', 'view', 0, 70, 0, 0, '2019-09-17 09:42:55');
INSERT INTO `cq_route` VALUES (73, '用户反馈', '', '', '', '', 'view', 1, 0, 1, 0, '2019-12-03 11:36:17');
INSERT INTO `cq_route` VALUES (74, '反馈列表', '', '/admin/report_list/listView', '', '', 'view', 1, 73, 1, 0, '2019-12-03 11:36:52');
INSERT INTO `cq_route` VALUES (76, '胜利数查看', '', '/admin/win/listView', '', '', 'view', 1, 22, 1, 0, '2019-08-28 16:22:24');
INSERT INTO `cq_route` VALUES (77, '财务机器人查看', '', '/admin/vadilate/listView', '', '', 'view', 1, 22, 1, 0, '2019-08-28 16:22:24');
INSERT INTO `cq_route` VALUES (78, '编辑', '', '/admin/vadilate/editView', '', '', 'view', 0, 58, 0, 0, '2019-09-04 16:16:16');
INSERT INTO `cq_route` VALUES (79, '提币记录', '', '/admin/transfer_out/listView', '', '', 'view', 1, 10, 1, 0, '2020-03-02 14:57:32');
INSERT INTO `cq_route` VALUES (99, '系统参数', '', '/admin/system_param/listView', '', '', 'view', 1, 22, 1, 0, '2019-08-28 16:22:24');
INSERT INTO `cq_route` VALUES (100, '用户审核', '', '/admin/user/userAuth', '', '', 'view', 1, 3, 1, 0, '2019-08-27 15:32:36');

SET FOREIGN_KEY_CHECKS = 1;
