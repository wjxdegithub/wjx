/*
Navicat MySQL Data Transfer

Source Server         : feng
Source Server Version : 50547
Source Host           : 127.0.0.1:3306
Source Database       : wechart

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2016-07-11 14:42:42
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for we_admin
-- ----------------------------
DROP TABLE IF EXISTS `we_admin`;
CREATE TABLE `we_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) DEFAULT NULL,
  `pwd` varchar(32) DEFAULT NULL,
  `addtime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of we_admin
-- ----------------------------
INSERT INTO `we_admin` VALUES ('1', '123@qq.com', '123', '2016-07-08 19:34:26');
INSERT INTO `we_admin` VALUES ('2', 'admin2', 'e10adc3949ba59abbe56e057f20f883e', '2016-07-11 13:37:47');

-- ----------------------------
-- Table structure for we_limit_ip
-- ----------------------------
DROP TABLE IF EXISTS `we_limit_ip`;
CREATE TABLE `we_limit_ip` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of we_limit_ip
-- ----------------------------
INSERT INTO `we_limit_ip` VALUES ('2', '127.0.0.1');
INSERT INTO `we_limit_ip` VALUES ('3', '::1');
