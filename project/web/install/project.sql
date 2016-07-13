/*
Navicat MySQL Data Transfer

Source Server         : yizu
Source Server Version : 50547
Source Host           : localhost:3307
Source Database       : wechart

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2016-07-13 09:59:25
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
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of we_admin
-- ----------------------------
INSERT INTO `we_admin` VALUES ('1', '123@qq.com', '123', '2016-07-08 19:34:26');
INSERT INTO `we_admin` VALUES ('2', 'admin2', 'e10adc3949ba59abbe56e057f20f883e', '2016-07-11 13:37:47');
INSERT INTO `we_admin` VALUES ('3', 'zsc', '25f9e794323b453885f5181f1b624d0b', '2016-07-11 16:08:13');
INSERT INTO `we_admin` VALUES ('4', '123@qq.com', '123', '2016-07-08 19:34:26');
INSERT INTO `we_admin` VALUES ('6', 'admin2', 'e10adc3949ba59abbe56e057f20f883e', '2016-07-11 13:37:47');
INSERT INTO `we_admin` VALUES ('7', 'zsc', '25f9e794323b453885f5181f1b624d0b', '2016-07-11 16:08:13');
INSERT INTO `we_admin` VALUES ('8', 'admin2', 'e10adc3949ba59abbe56e057f20f883e', '2016-07-11 13:37:47');
INSERT INTO `we_admin` VALUES ('9', 'admin2', 'e10adc3949ba59abbe56e057f20f883e', '2016-07-11 13:37:47');
INSERT INTO `we_admin` VALUES ('10', 'admin2', 'e10adc3949ba59abbe56e057f20f883e', '2016-07-11 13:37:47');

-- ----------------------------
-- Table structure for we_limit_ip
-- ----------------------------
DROP TABLE IF EXISTS `we_limit_ip`;
CREATE TABLE `we_limit_ip` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of we_limit_ip
-- ----------------------------
INSERT INTO `we_limit_ip` VALUES ('2', '127.0.0.1');
INSERT INTO `we_limit_ip` VALUES ('3', '::1');
INSERT INTO `we_limit_ip` VALUES ('4', '192.168.1.162');
INSERT INTO `we_limit_ip` VALUES ('8', '192.168.1.118');
INSERT INTO `we_limit_ip` VALUES ('7', '192.168.1.51');
INSERT INTO `we_limit_ip` VALUES ('9', '192.168.1.131');
