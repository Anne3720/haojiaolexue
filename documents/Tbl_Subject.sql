/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50520
Source Host           : localhost:3306
Source Database       : db

Target Server Type    : MYSQL
Target Server Version : 50520
File Encoding         : 65001

Date: 2015-12-20 16:48:03
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tbl_subject
-- ----------------------------
DROP TABLE IF EXISTS `tbl_subject`;
CREATE TABLE `tbl_subject` (
  `SubjectID` int(11) NOT NULL AUTO_INCREMENT COMMENT '科目ID',
  `Title` char(20) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '科目名',
  `Grade` int(11) NOT NULL DEFAULT '0' COMMENT '年级',
  PRIMARY KEY (`SubjectID`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_subject
-- ----------------------------
INSERT INTO `tbl_subject` VALUES ('1', '语文', '1');
INSERT INTO `tbl_subject` VALUES ('2', '语文', '2');
INSERT INTO `tbl_subject` VALUES ('3', '语文', '3');
INSERT INTO `tbl_subject` VALUES ('4', '语文', '4');
INSERT INTO `tbl_subject` VALUES ('5', '语文', '5');
INSERT INTO `tbl_subject` VALUES ('6', '语文', '6');
INSERT INTO `tbl_subject` VALUES ('7', '语文', '7');
INSERT INTO `tbl_subject` VALUES ('8', '语文', '8');
INSERT INTO `tbl_subject` VALUES ('9', '语文', '9');
INSERT INTO `tbl_subject` VALUES ('10', '语文', '10');
INSERT INTO `tbl_subject` VALUES ('11', '语文', '11');
INSERT INTO `tbl_subject` VALUES ('12', '数学', '2');
INSERT INTO `tbl_subject` VALUES ('13', '数学', '3');
INSERT INTO `tbl_subject` VALUES ('14', '数学', '4');
INSERT INTO `tbl_subject` VALUES ('15', '数学', '5');
INSERT INTO `tbl_subject` VALUES ('16', '数学', '6');
INSERT INTO `tbl_subject` VALUES ('17', '数学', '7');
INSERT INTO `tbl_subject` VALUES ('18', '数学', '8');
INSERT INTO `tbl_subject` VALUES ('19', '数学', '9');
INSERT INTO `tbl_subject` VALUES ('20', '数学', '10');
INSERT INTO `tbl_subject` VALUES ('21', '数学', '11');
INSERT INTO `tbl_subject` VALUES ('22', '英语', '2');
INSERT INTO `tbl_subject` VALUES ('23', '英语', '3');
INSERT INTO `tbl_subject` VALUES ('24', '英语', '4');
INSERT INTO `tbl_subject` VALUES ('25', '英语', '5');
INSERT INTO `tbl_subject` VALUES ('26', '英语', '6');
INSERT INTO `tbl_subject` VALUES ('27', '英语', '7');
INSERT INTO `tbl_subject` VALUES ('28', '英语', '8');
INSERT INTO `tbl_subject` VALUES ('29', '英语', '9');
INSERT INTO `tbl_subject` VALUES ('30', '英语', '10');
INSERT INTO `tbl_subject` VALUES ('31', '英语', '11');
INSERT INTO `tbl_subject` VALUES ('32', '美术', '2');
INSERT INTO `tbl_subject` VALUES ('33', '美术', '3');
INSERT INTO `tbl_subject` VALUES ('34', '美术', '4');
INSERT INTO `tbl_subject` VALUES ('35', '美术', '5');
INSERT INTO `tbl_subject` VALUES ('36', '美术', '6');
INSERT INTO `tbl_subject` VALUES ('37', '美术', '7');
INSERT INTO `tbl_subject` VALUES ('38', '化学', '8');
INSERT INTO `tbl_subject` VALUES ('39', '化学', '9');
INSERT INTO `tbl_subject` VALUES ('40', '化学', '10');
INSERT INTO `tbl_subject` VALUES ('41', '化学', '11');
