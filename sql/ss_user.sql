/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : turen_cms

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-02-11 23:17:48
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ss_user
-- ----------------------------
DROP TABLE IF EXISTS `ss_user`;
CREATE TABLE `ss_user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `username` varchar(32) NOT NULL COMMENT '用户名',
  `email` varchar(40) NOT NULL COMMENT '电子邮件',
  `mobile` varchar(20) NOT NULL COMMENT '手机',
  `password` varchar(32) DEFAULT NULL COMMENT '密码（明文）',
  `password_hash` varchar(255) DEFAULT NULL COMMENT '密文',
  `password_reset_token` varchar(255) DEFAULT NULL COMMENT '改密码token',
  `auth_key` varchar(32) DEFAULT NULL,
  `level_id` tinyint(5) NOT NULL DEFAULT '-1' COMMENT '会员等级',
  `ug_id` tinyint(5) NOT NULL DEFAULT '-1' COMMENT '会员组',
  `avatar` varchar(100) NOT NULL COMMENT '头像',
  `sex` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '性别',
  `company` varchar(100) NOT NULL COMMENT '公司名称',
  `trade` varchar(10) NOT NULL DEFAULT '-1' COMMENT '行业',
  `license` varchar(150) NOT NULL COMMENT '公司执照',
  `telephone` varchar(20) NOT NULL COMMENT '公司固定电话',
  `intro` text NOT NULL COMMENT '备注说明',
  `address_prov` varchar(10) NOT NULL DEFAULT '-1' COMMENT '通信地址_省',
  `address_city` varchar(10) NOT NULL DEFAULT '-1' COMMENT '通信地址_市',
  `address_country` varchar(15) NOT NULL DEFAULT '-1' COMMENT '通信地址_区',
  `address` varchar(100) NOT NULL COMMENT '通信地址',
  `zipcode` varchar(10) NOT NULL COMMENT '邮编',
  `point` int(10) unsigned NOT NULL COMMENT '积分',
  `reg_ip` varchar(20) NOT NULL COMMENT '注册IP',
  `login_ip` varchar(20) NOT NULL COMMENT '登录IP',
  `qq_id` varchar(32) NOT NULL COMMENT '绑定QQ',
  `weibo_id` varchar(32) NOT NULL COMMENT '绑定微博',
  `wx_id` varchar(32) NOT NULL COMMENT '绑定微信',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态，1为正常，0为黑名单',
  `delstate` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '删除状态',
  `deltime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间',
  `login_time` int(10) unsigned NOT NULL COMMENT '登录时间',
  `reg_time` int(10) unsigned NOT NULL COMMENT '注册时间',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ss_user
-- ----------------------------
INSERT INTO `ss_user` VALUES ('1', 'testuser', 'webmaster@phpmywind.com', '', '85f0fb9cc2792a9b87e3b3facccedc40', null, null, '', '4', '8', '', '0', '', '-1', '', '', '', '-1', '-1', '-1', '', '', '0', '127.0.0.1', '127.0.0.1', '', '', '', '1', '0', '0', '1540380454', '1540742400');
INSERT INTO `ss_user` VALUES ('3', '测试用户', '', '', '', null, null, '', '5', '6', '', '0', '', '-1', '', '', '', '-1', '-1', '-1', '', '', '0', '', '', '', '', '', '1', '0', '1540785148', '0', '1540742400');
