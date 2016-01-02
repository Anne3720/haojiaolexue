/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50137
Source Host           : localhost:3306
Source Database       : test

Target Server Type    : MYSQL
Target Server Version : 50137
File Encoding         : 65001

Date: 2014-04-18 16:01:00
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `story`
-- ----------------------------
DROP TABLE IF EXISTS `story`;
CREATE TABLE `story` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) CHARACTER SET utf8 NOT NULL,
  `author` varchar(30) CHARACTER SET utf8 NOT NULL,
  `content` varchar(500) CHARACTER SET utf8 NOT NULL,
  `create_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of story
-- ----------------------------
INSERT INTO `story` VALUES ('1', '为友盟消息推送开发的PHP SDK（composer版', 'Ronny', '一、const是什么在 C/C++ 语言中，const关键字是一种修饰符。所谓“修饰符”，就是在编译器进行编译的过程中，给编译器一些“要求”或“提示”，但修饰符本身，并不产生任何实际代码。就 const 修饰符而言，它用来告诉编译器，被修饰的这些东西，具有“只读”的特点。', '2013-02-01 15:57:08');
INSERT INTO `story` VALUES ('2', 'C++ 字符串, 数字 相互转化', '宋桓公 ', '1: strL.Format(\"%x\", 12); //将数字12转换成，16进制字符（C），存于strL 2: strH.Format(\"%x\",12); //将数字12转换成，16进制字符（C），存于strH', '2013-05-18 15:57:22');
INSERT INTO `story` VALUES ('3', 'fgetcsv函数不能读取csv文件中文字符串的解决方法', 'moushu', '读取数据函数： function getData($file) { $arr = array(); if(($handle = fopen($file,\"r\")) !== FALSE) { while(($data = fgetcsv', '2010-01-01 15:57:30');
INSERT INTO `story` VALUES ('4', 'PHP 神盾解密工具', '乱码', '前两天分析了神盾的解密过程所用到的知识点，昨晚我把工具整理了下，顺便用神盾加密了。这都是昨天说好的，下面看下调用方法吧。先下载 decryption.zip然后解压放到一个文件夹里，把你要解密的文件也放进去。然后新建一个 decode.php 代码写', '2014-01-01 15:57:38');
INSERT INTO `story` VALUES ('5', 'jdbc_odbc SQLserver 驱动安装及测试', '谭家泉', '有2次被问到同一个问题，尽管博客园是.net的园子，我还是分享下吧。PS:我现在做的.net，以前学过点java。献丑了。------------------ 原始邮件 ------------------发件人: \"我自己的邮箱\";;发送时间: 2012年4月28日(星期六) 中午12:06收件人.', '2013-04-18 15:57:47');
INSERT INTO `story` VALUES ('6', 'JSP脚本的9个内置对象', 'harryV', 'SP的内置对象都是Servlet API接口的实例，在JSP脚本生成的Servlet中的_jspService方法中创建实例（为什么没有exception对象？因为当页面中page指令的isErrorPage属性为true时，才可以使用exception对象。），所以我们可以在JSP的输出表达式', '2014-02-01 15:58:00');
INSERT INTO `story` VALUES ('7', 'Java开发者应该列入年度计划的5件事', 'SoWeb ', '本文写了我今年计划要做的5件事。为了能跟踪计划执行的进度，就把这些事都列了出来。我觉得这些事对其它Java开发者而言也是不错的参考方向', '2013-10-18 15:58:07');
