/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50611
Source Host           : localhost:3306
Source Database       : cms_admin

Target Server Type    : MYSQL
Target Server Version : 50611
File Encoding         : 65001

Date: 2016-02-29 14:22:25
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for admin
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(32) NOT NULL DEFAULT '',
  `nick` varchar(10) DEFAULT '' COMMENT '真实姓名',
  `byname` varchar(50) DEFAULT '' COMMENT 'support需要的别名',
  `email` varchar(50) DEFAULT '' COMMENT 'email',
  `phone` varchar(20) DEFAULT '' COMMENT '电话',
  `gid` varchar(250) DEFAULT '',
  `project_id` varchar(250) DEFAULT '' COMMENT '项目ID',
  `login_ip` varchar(15) DEFAULT '' COMMENT '登录IP',
  `logintime` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '管理员状态 1 - 有效 0 - 无效',
  `createtime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_username_password` (`username`,`password`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='管理员';

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES ('1', 'admin', 'c0e024d9200b5705bc4804722636378a', '', '', '', '', '2,1', null, '127.0.0.1', '2016-02-29 11:29:24', '1', '2015-04-21 19:15:35');
INSERT INTO `admin` VALUES ('3', 'zhangsan', '', '', '', '', '', '2,1', '', '', '2015-04-21 21:48:44', '1', '2015-04-21 21:48:44');

-- ----------------------------
-- Table structure for admin_group
-- ----------------------------
DROP TABLE IF EXISTS `admin_group`;
CREATE TABLE `admin_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(50) NOT NULL,
  `menu_id` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_group
-- ----------------------------
INSERT INTO `admin_group` VALUES ('1', '管理组', ',17,30,37,36,35,33,31,28,29,18,22,27,26,24,19,25,23,21,20,1,11,16,12,15,14,13,2,7,10,9,8,3,6,5,4,', '1');
INSERT INTO `admin_group` VALUES ('2', '空权限', '', '1');

-- ----------------------------
-- Table structure for admin_log_new
-- ----------------------------
DROP TABLE IF EXISTS `admin_log_new`;
CREATE TABLE `admin_log_new` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL,
  `server_ip` varchar(13) NOT NULL,
  `database` varchar(100) NOT NULL,
  `tablename` varchar(100) NOT NULL,
  `act_type` varchar(15) NOT NULL,
  `before_content` varchar(5000) NOT NULL,
  `last_content` varchar(5000) NOT NULL,
  `rongyu_key` int(11) NOT NULL,
  `where` varchar(200) NOT NULL,
  `create_username` varchar(100) NOT NULL,
  `create_userid` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  `create_ip` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='日志';

-- ----------------------------
-- Records of admin_log_new
-- ----------------------------

-- ----------------------------
-- Table structure for admin_menu
-- ----------------------------
DROP TABLE IF EXISTS `admin_menu`;
CREATE TABLE `admin_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `url` varchar(250) NOT NULL,
  `modle` varchar(20) NOT NULL COMMENT '功能模块',
  `action` varchar(250) NOT NULL COMMENT '方法',
  `par` varchar(20) NOT NULL COMMENT '参数',
  `ajax` varchar(50) NOT NULL COMMENT '浮动框',
  `orders` smallint(6) NOT NULL,
  `hidden` int(11) NOT NULL,
  `target` tinyint(4) NOT NULL COMMENT '是否新窗口',
  `top` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `parent_no_verify` tinyint(4) NOT NULL,
  `no_verify` tinyint(4) NOT NULL COMMENT '不需要权限',
  PRIMARY KEY (`id`),
  KEY `orders` (`orders`),
  KEY `idx_modle_action` (`modle`,`action`,`orders`),
  KEY `idx_parent_id_top` (`parent_id`,`top`,`orders`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8 COMMENT='后台菜单';

-- ----------------------------
-- Records of admin_menu
-- ----------------------------
INSERT INTO `admin_menu` VALUES ('1', '0', '设置', '', 'admin', '', '', '0', '1000', '0', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('2', '1', '管理员设置', '', 'admin', '', '', '', '0', '0', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('3', '2', '帐号管理', '/admin/user/list', 'admin/user', 'list', '', '0', '0', '0', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('4', '3', '添加帐号', '/admin/user/edit?height=230&width=550', 'admin/user', 'edit', '', '0', '0', '1', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('5', '3', '帐号入库', '/admin/user/insert', 'admin/user', 'insert', '', '0', '0', '1', '0', '1', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('6', '3', '帐号删除', '/admin/user/delete', 'admin/user', 'delete', '', '0', '0', '1', '0', '1', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('7', '2', '帐号组', '/admin/group/list', 'admin/group', 'list', '', '0', '0', '0', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('8', '7', '添加帐号组', '/admin/group/edit', 'admin/group', 'edit', '', '0', '0', '1', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('9', '7', '账号组入库', '/admin/group/info', 'admin/group', 'info', '', '0', '0', '1', '0', '1', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('10', '7', '删除账号组', '/admin/group/delete', 'admin/group', 'delete', '', '0', '0', '1', '0', '1', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('11', '1', '插件', '', 'admin', '', '', '', '999', '0', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('12', '11', '后台菜单', '/admin/menu/list', 'admin/menu', 'list', '', '0', '0', '0', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('13', '12', '添加菜单', '/admin/menu/edit?height=350', 'admin/meun', 'edit', '', '1', '1', '1', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('14', '12', '菜单入库', '/admin/menu/info', 'admin/menu', 'info', '', '0', '0', '1', '0', '1', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('15', '12', '菜单删除', '/admin/menu/delete', 'admin/menu', 'delete', '', '0', '0', '1', '0', '1', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('16', '11', '操作日志', '/zpadmin/admin/log', 'admin', 'log', '', '0', '0', '0', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('17', '0', '教师后台', '', 'admin', '', '', '0', '0', '0', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('18', '17', '课程管理', '', 'admin', '', '', '0', '0', '0', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('19', '18', '科目管理', '/admin/subject/list', 'admin/subject', 'list', '', '0', '0', '0', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('20', '19', '添加科目', '/admin/subject/edit?height=230&width=550', 'admin/subject', 'edit', '', '0', '0', '0', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('21', '19', '课程管理', '/admin/classes/list', 'admin/classes', 'list', '', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `admin_menu` VALUES ('22', '18', '课程管理', '/admin/classes/list', 'admin/classes', 'list', '', '0', '0', '0', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('23', '19', '删除科目', '/admin/subject/delete', 'admin/subject', 'delete', '', '0', '0', '1', '0', '1', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('24', '22', '课程入库', '/admin/classes/info', 'admin/classes', 'info', '', '0', '0', '1', '0', '1', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('25', '19', '科目入库', '/admin/subject/info', 'admin/subject', 'info', '', '0', '0', '1', '0', '1', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('26', '22', '添加课程', '/admin/classes/edit', 'admin/classes', 'edit', '', '0', '0', '0', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('27', '22', '删除课程', '/admin/classes/delete', 'admin/classes', 'delete', '', '0', '0', '0', '0', '1', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('28', '17', '交易管理', '', 'admin', '', '', '0', '0', '0', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('29', '28', '交易列表', '/admin/transaction/list', 'admin/transaction', 'list', '', '0', '0', '0', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('30', '17', '学员管理', '', 'admin', '', '', '0', '0', '0', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('31', '30', '学员管理', '/admin/member/list', 'admin/member', 'list', '', '0', '0', '0', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('37', '30', '取消推荐', '/admin/recommend/delete', 'admin/recommend', 'delete', '', '0', '0', '1', '0', '1', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('35', '30', '推荐课程', '/admin/recommend/list', 'admin/recommend', 'list', '', '0', '0', '1', '0', '1', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('33', '30', '选课查询', '/admin/chosen/list', 'admin/chosen', 'list', '', '0', '0', '0', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('36', '30', '推荐课程入库', '/admin/recommend/info', 'admin/recommend', 'info', '', '0', '0', '1', '0', '1', '1', '0', '0');

-- ----------------------------
-- Table structure for project
-- ----------------------------
DROP TABLE IF EXISTS `project`;
CREATE TABLE `project` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_name` varchar(50) NOT NULL COMMENT '项目名称',
  `project_url` varchar(250) NOT NULL COMMENT '项目URL',
  `status` tinyint(2) NOT NULL COMMENT '项目状态',
  `create_uid` int(11) NOT NULL COMMENT '创建人',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `update_uid` int(11) NOT NULL COMMENT '修改人',
  `update_time` datetime NOT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='项目表';

-- ----------------------------
-- Records of project
-- ----------------------------
