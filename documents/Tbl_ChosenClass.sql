/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50520
Source Host           : localhost:3306
Source Database       : db

Target Server Type    : MYSQL
Target Server Version : 50520
File Encoding         : 65001

Date: 2015-12-20 16:47:36
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
  PRIMARY KEY (`ChosenID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
