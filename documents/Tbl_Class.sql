/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50520
Source Host           : localhost:3306
Source Database       : db

Target Server Type    : MYSQL
Target Server Version : 50520
File Encoding         : 65001

Date: 2015-12-20 16:47:50
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tbl_class
-- ----------------------------
DROP TABLE IF EXISTS `tbl_class`;
CREATE TABLE `tbl_class` (
  `ClassID` int(11) NOT NULL AUTO_INCREMENT COMMENT '课程编号',
  `ClassNo` int(11) DEFAULT NULL COMMENT '课程编号',
  `Grade` int(11) DEFAULT NULL,
  `Image` char(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '图片',
  `Video` char(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '视频',
  `SubjectID` int(11) DEFAULT NULL COMMENT '所属科目',
  `Price` int(11) DEFAULT NULL COMMENT '价格',
  PRIMARY KEY (`ClassID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_class
-- ----------------------------
