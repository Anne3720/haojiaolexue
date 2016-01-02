/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50520
Source Host           : localhost:3306
Source Database       : db

Target Server Type    : MYSQL
Target Server Version : 50520
File Encoding         : 65001

Date: 2015-11-30 22:26:27
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tbl_member
-- ----------------------------
DROP TABLE IF EXISTS `tbl_member`;
CREATE TABLE `tbl_member` (
  `MemberID` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增长用户ID',
  `Mobile` char(15) CHARACTER SET utf8 NOT NULL COMMENT '手机号码',
  `Email` varchar(50) CHARACTER SET utf8 NOT NULL,
  `Name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `Gender` tinyint(1) DEFAULT NULL COMMENT '1男 2女',
  `Grade` int(5) DEFAULT NULL,
  `School` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `Balance` double(32,0) DEFAULT '0',
  `Activated` tinyint(1) DEFAULT '0' COMMENT '0未激活 1已激活',
  `Password` varchar(50) CHARACTER SET utf8 DEFAULT '' COMMENT '密码',
  PRIMARY KEY (`MemberID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
