/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50611
Source Host           : localhost:3306
Source Database       : db

Target Server Type    : MYSQL
Target Server Version : 50611
File Encoding         : 65001

Date: 2016-01-28 17:27:21
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tbl_chosenclass
-- ----------------------------
DROP TABLE IF EXISTS `tbl_chosenclass`;
CREATE TABLE `tbl_chosenclass` (
  `ChosenID` int(11) NOT NULL AUTO_INCREMENT,
  `MemberID` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `ClassID` int(11) NOT NULL DEFAULT '0' COMMENT '课程ID',
  `CreateTime` datetime DEFAULT NULL,
  PRIMARY KEY (`ChosenID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for tbl_class
-- ----------------------------
DROP TABLE IF EXISTS `tbl_class`;
CREATE TABLE `tbl_class` (
  `ClassID` int(11) NOT NULL AUTO_INCREMENT COMMENT '课程编号',
  `ClassNo` int(11) DEFAULT NULL COMMENT '课程编号',
  `Grade` int(11) DEFAULT NULL,
  `Image` char(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '图片',
  `Video` char(50) CHARACTER SET utf8 DEFAULT '' COMMENT '视频',
  `SubjectID` int(11) DEFAULT NULL COMMENT '所属科目',
  `Price` int(11) DEFAULT NULL COMMENT '价格',
  `CreateTime` datetime DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  PRIMARY KEY (`ClassID`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

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
  `CreateTime` datetime DEFAULT NULL,
  `Status` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`MemberID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for tbl_recommendclass
-- ----------------------------
DROP TABLE IF EXISTS `tbl_recommendclass`;
CREATE TABLE `tbl_recommendclass` (
  `RecommendID` int(11) NOT NULL AUTO_INCREMENT,
  `MemberID` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `ClassID` int(11) NOT NULL DEFAULT '0' COMMENT '课程ID',
  `CreateTime` datetime DEFAULT NULL,
  `TeacherID` int(11) DEFAULT NULL,
  PRIMARY KEY (`RecommendID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for tbl_subject
-- ----------------------------
DROP TABLE IF EXISTS `tbl_subject`;
CREATE TABLE `tbl_subject` (
  `SubjectID` int(11) NOT NULL AUTO_INCREMENT COMMENT '科目ID',
  `Title` char(20) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '科目名',
  `Grade` int(11) NOT NULL DEFAULT '0' COMMENT '年级',
  `CreateTime` datetime DEFAULT NULL,
  PRIMARY KEY (`SubjectID`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;
