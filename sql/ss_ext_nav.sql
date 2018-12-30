/*
Navicat MySQL Data Transfer

Source Server         : 本地连接
Source Server Version : 100137
Source Host           : localhost:3306
Source Database       : turen_cms

Target Server Type    : MYSQL
Target Server Version : 100137
File Encoding         : 65001

Date: 2018-12-30 21:21:24
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ss_ext_nav
-- ----------------------------
DROP TABLE IF EXISTS `ss_ext_nav`;
CREATE TABLE `ss_ext_nav` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '导航id',
  `parentid` int(11) unsigned NOT NULL COMMENT '导航分类',
  `parentstr` varchar(80) NOT NULL COMMENT '导航分类父id字符串',
  `menuname` varchar(30) NOT NULL COMMENT '导航名称',
  `linkurl` varchar(255) NOT NULL COMMENT '跳转链接',
  `picurl` varchar(100) NOT NULL COMMENT '导航图片',
  `target` varchar(30) NOT NULL COMMENT '打开方式',
  `orderid` int(11) unsigned NOT NULL DEFAULT '10' COMMENT '排列排序',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '导航状态',
  `lang` varchar(8) NOT NULL,
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '编辑时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ss_ext_nav
-- ----------------------------
INSERT INTO `ss_ext_nav` VALUES ('1', '0', '0,', '主站点菜单', '#', '', '', '200', '1', 'zh-CN', '0', '1545643107');
INSERT INTO `ss_ext_nav` VALUES ('31', '1', '0,1,', '关于我们', '#', '', '', '100', '1', 'zh-CN', '1545466840', '1545466840');
INSERT INTO `ss_ext_nav` VALUES ('32', '1', '0,1,', '服务中心', '#', '', '', '90', '1', 'zh-CN', '1545467097', '1545467214');
INSERT INTO `ss_ext_nav` VALUES ('33', '32', '0,1,32,', '家政服务', '#', '', '', '12', '1', 'zh-CN', '1545467130', '1545467192');
INSERT INTO `ss_ext_nav` VALUES ('34', '32', '0,1,32,', '管道疏通', '#', '', '', '10', '1', 'zh-CN', '1545467139', '1545467192');
INSERT INTO `ss_ext_nav` VALUES ('35', '32', '0,1,32,', '环保除虫', '#', '', '', '8', '1', 'zh-CN', '1545467149', '1545467192');
INSERT INTO `ss_ext_nav` VALUES ('36', '32', '0,1,32,', '搬家搬运', '#', '', '', '6', '1', 'zh-CN', '1545467159', '1545467192');
INSERT INTO `ss_ext_nav` VALUES ('37', '1', '0,1,', '嘉乐邦案例', '#', '', '', '80', '1', 'zh-CN', '1545467483', '1545467590');
INSERT INTO `ss_ext_nav` VALUES ('38', '1', '0,1,', '在线帮助', '#', '', '', '70', '1', 'zh-CN', '1545467551', '1545467590');
INSERT INTO `ss_ext_nav` VALUES ('39', '1', '0,1,', '行业百科', '#', '', '', '60', '1', 'zh-CN', '1545467627', '1545467627');
INSERT INTO `ss_ext_nav` VALUES ('40', '1', '0,1,', '下单有礼', '#', '', '', '50', '1', 'zh-CN', '1545467679', '1545467687');
INSERT INTO `ss_ext_nav` VALUES ('41', '0', '0,', '搬家业务菜单', '#', '', '', '120', '1', 'zh-CN', '1545467804', '1545643129');
INSERT INTO `ss_ext_nav` VALUES ('42', '41', '0,41,', '计价器', 'http://turen.com/banjia/calculator/index.html', 'cms-images/nav/2018_12_30/38b4c95b47fefc3209ed5e1eb471704e.png', '', '100', '1', 'zh-CN', '1545643155', '1546168293');
INSERT INTO `ss_ext_nav` VALUES ('43', '41', '0,41,', '业务范围', 'http://turen.com/banjia/service/detail.html?name=居民搬家', 'cms-images/nav/2018_12_30/af8b8103b1ac43abaaf092052d6efc0b.gif', '', '90', '1', 'zh-CN', '1545643172', '1546160120');
INSERT INTO `ss_ext_nav` VALUES ('44', '41', '0,41,', '服务流程', 'http://turen.com/banjia/page/info.html?name=服务流程', '', '_blank', '80', '1', 'zh-CN', '1545643244', '1546161060');
INSERT INTO `ss_ext_nav` VALUES ('45', '41', '0,41,', '案例展示', 'http://turen.com/banjia/case/list.html', '', '', '70', '1', 'zh-CN', '1545643259', '1545643352');
INSERT INTO `ss_ext_nav` VALUES ('46', '41', '0,41,', '资讯中心', 'http://turen.com/banjia/baike/list.html', '', '', '60', '1', 'zh-CN', '1545643273', '1545643352');
INSERT INTO `ss_ext_nav` VALUES ('47', '46', '0,41,46,', '搬家百科', 'http://turen.com/banjia/baike/list.html', 'cms-images/nav/2018_12_30/a8729d797998b805aefbb7ac7aea9eb5.jpg', '', '5', '1', 'zh-CN', '1545643287', '1545643383');
INSERT INTO `ss_ext_nav` VALUES ('48', '46', '0,41,46,', '行业动态', 'http://turen.com/banjia/news/list.html', 'cms-images/nav/2018_12_30/a8729d797998b805aefbb7ac7aea9eb5.jpg', '', '3', '1', 'zh-CN', '1545643295', '1545643383');
INSERT INTO `ss_ext_nav` VALUES ('49', '41', '0,41,', '在线客服', 'http://turen.com/banjia/page/info.html?name=在线客服', '', '', '50', '1', 'zh-CN', '1545643314', '1545643352');
INSERT INTO `ss_ext_nav` VALUES ('50', '43', '0,41,43,', '居民搬家', 'http://turen.com/banjia/service/detail.html?name=居民搬家', 'cms-images/nav/2018_12_30/a8729d797998b805aefbb7ac7aea9eb5.jpg', '', '50', '1', 'zh-CN', '1545647034', '1546160624');
INSERT INTO `ss_ext_nav` VALUES ('51', '43', '0,41,43,', '办公室搬迁', 'http://turen.com/banjia/service/detail.html?name=办公室搬迁', 'cms-images/nav/2018_12_30/a8729d797998b805aefbb7ac7aea9eb5.jpg', '', '45', '1', 'zh-CN', '1545647044', '1545647204');
INSERT INTO `ss_ext_nav` VALUES ('52', '43', '0,41,43,', '厂房搬迁', 'http://turen.com/banjia/service/detail.html?name=厂房搬迁', 'cms-images/nav/2018_12_30/a8729d797998b805aefbb7ac7aea9eb5.jpg', '', '40', '1', 'zh-CN', '1545647051', '1546160900');
INSERT INTO `ss_ext_nav` VALUES ('53', '43', '0,41,43,', '学校搬迁', 'http://turen.com/banjia/service/detail.html?name=学校搬迁', 'cms-images/nav/2018_12_30/a8729d797998b805aefbb7ac7aea9eb5.jpg', '', '35', '1', 'zh-CN', '1545647065', '1545647204');
INSERT INTO `ss_ext_nav` VALUES ('54', '43', '0,41,43,', '钢琴搬运', 'http://turen.com/banjia/service/detail.html?name=钢琴搬运', 'cms-images/nav/2018_12_30/a8729d797998b805aefbb7ac7aea9eb5.jpg', '', '30', '1', 'zh-CN', '1545647072', '1545647168');
INSERT INTO `ss_ext_nav` VALUES ('55', '43', '0,41,43,', '仓库搬迁', 'http://turen.com/banjia/service/detail.html?name=仓库搬迁', 'cms-images/nav/2018_12_30/a8729d797998b805aefbb7ac7aea9eb5.jpg', '', '25', '1', 'zh-CN', '1545647078', '1545647204');
INSERT INTO `ss_ext_nav` VALUES ('56', '43', '0,41,43,', '服务器搬迁', 'http://turen.com/banjia/service/detail.html?name=服务器搬迁', 'cms-images/nav/2018_12_30/a8729d797998b805aefbb7ac7aea9eb5.jpg', '', '20', '1', 'zh-CN', '1545647083', '1545647204');
INSERT INTO `ss_ext_nav` VALUES ('57', '43', '0,41,43,', '空调移机', 'http://turen.com/banjia/service/detail.html?name=空调移机', 'cms-images/nav/2018_12_30/a8729d797998b805aefbb7ac7aea9eb5.jpg', '', '15', '1', 'zh-CN', '1545647090', '1545647204');
INSERT INTO `ss_ext_nav` VALUES ('58', '43', '0,41,43,', '长途搬家', 'http://turen.com/banjia/service/detail.html?name=长途搬家', 'cms-images/nav/2018_12_30/a8729d797998b805aefbb7ac7aea9eb5.jpg', '', '10', '1', 'zh-CN', '1545647096', '1545647204');
INSERT INTO `ss_ext_nav` VALUES ('59', '46', '0,41,46,', '常见问答', 'http://turen.com/banjia/faqs/index.html', 'cms-images/nav/2018_12_30/a8729d797998b805aefbb7ac7aea9eb5.jpg', '', '1', '1', 'zh-CN', '1546168728', '1546168755');
