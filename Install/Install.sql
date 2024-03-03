SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for server_config
-- ----------------------------
DROP TABLE IF EXISTS `server_config`;
CREATE TABLE `server_config`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '编号',
  `keyname` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '字段名',
  `value` varchar(400) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '内容',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统配置数据' ROW_FORMAT = Dynamic;
-- ----------------------------
-- Records of server_config
-- ----------------------------
INSERT INTO `server_config` VALUES (1, 'plugin_key', 'code');
INSERT INTO `server_config` VALUES (2, 'admin_username', 'admin');
INSERT INTO `server_config` VALUES (3, 'admin_password', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92');
INSERT INTO `server_config` VALUES (4, 'debug_mode', 'false');

-- ----------------------------
-- Table structure for server_plugin
-- ----------------------------
DROP TABLE IF EXISTS `server_plugin`;
CREATE TABLE `server_plugin`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '编号',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '插件名',
  `info` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '介绍',
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '插件安装目录',
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '插件作者',
  `version` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '插件版本',
  `pluginadmin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '插件是否开启独立后台',
  `pluginadminurl` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '插件后台独立地址',
  `auth_username` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '后台鉴权使用账户',
  `auth_password` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '后台鉴权使用密码',
  `auth_mysql` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '是否授权mysql权限',
  `isopen` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '插件是否开启',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '插件配置数据' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for server_plugin_event
-- ----------------------------
DROP TABLE IF EXISTS `server_plugin_event`;
CREATE TABLE `server_plugin_event`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'n编号',
  `pluginid` int(11) NOT NULL DEFAULT 0 COMMENT '插件ID',
  `event` varchar(400) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '事件',
  `auth` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '是否给予权限',
  `pluginauth` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '插件是否开启',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '插件监听事件配置数据' ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
