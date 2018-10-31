/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 100125
Source Host           : localhost:3306
Source Database       : turen_cms

Target Server Type    : MYSQL
Target Server Version : 100125
File Encoding         : 65001

Date: 2018-10-31 18:57:30
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ss_cascade
-- ----------------------------
DROP TABLE IF EXISTS `ss_cascade`;
CREATE TABLE `ss_cascade` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '级联组id',
  `groupname` varchar(30) NOT NULL COMMENT '级联组名称',
  `groupsign` varchar(30) NOT NULL COMMENT '级联组标识',
  `orderid` smallint(5) unsigned NOT NULL COMMENT '排列排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ss_cascade_data
-- ----------------------------
DROP TABLE IF EXISTS `ss_cascade_data`;
CREATE TABLE `ss_cascade_data` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '级联数据id',
  `dataname` char(30) NOT NULL COMMENT '级联数据名称',
  `datavalue` char(20) NOT NULL COMMENT '级联数据值',
  `datagroup` char(20) NOT NULL COMMENT '所属级联组',
  `orderid` smallint(5) unsigned NOT NULL COMMENT '排列排序',
  `level` tinyint(1) unsigned NOT NULL COMMENT '级联数据层次',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ss_cms_article
-- ----------------------------
DROP TABLE IF EXISTS `ss_cms_article`;
CREATE TABLE `ss_cms_article` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '列表信息id',
  `columnid` int(11) unsigned NOT NULL COMMENT '所属栏目id',
  `parentid` int(11) unsigned NOT NULL COMMENT '所属栏目上级id',
  `parentstr` varchar(80) NOT NULL COMMENT '所属栏目上级id字符串',
  `cateid` int(11) unsigned DEFAULT NULL COMMENT '类别id',
  `catepid` int(11) unsigned DEFAULT NULL COMMENT '类别父id',
  `catepstr` varchar(80) DEFAULT NULL COMMENT '所属类别上级id字符串',
  `title` varchar(80) NOT NULL COMMENT '标题',
  `colorval` char(10) NOT NULL COMMENT '字体颜色',
  `boldval` char(10) NOT NULL COMMENT '字体加粗',
  `flag` varchar(30) NOT NULL COMMENT '属性',
  `source` varchar(50) NOT NULL COMMENT '文章来源',
  `author` varchar(50) NOT NULL COMMENT '作者编辑',
  `linkurl` varchar(255) NOT NULL COMMENT '跳转链接',
  `keywords` varchar(50) NOT NULL COMMENT '关键词',
  `description` varchar(255) NOT NULL COMMENT '摘要',
  `content` mediumtext NOT NULL COMMENT '详细内容',
  `picurl` varchar(100) NOT NULL COMMENT '缩略图片',
  `picarr` text NOT NULL COMMENT '组图',
  `hits` mediumint(8) unsigned NOT NULL COMMENT '点击次数',
  `orderid` int(10) unsigned NOT NULL COMMENT '排列排序',
  `posttime` int(10) NOT NULL COMMENT '更新时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '审核状态',
  `delstate` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '删除状态',
  `deltime` int(10) unsigned NOT NULL COMMENT '删除时间',
  `lang` varchar(8) NOT NULL,
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '编辑时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ss_cms_block
-- ----------------------------
DROP TABLE IF EXISTS `ss_cms_block`;
CREATE TABLE `ss_cms_block` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '碎片数据id',
  `title` varchar(30) NOT NULL COMMENT '碎片数据名称',
  `picurl` varchar(80) NOT NULL COMMENT '碎片数据缩略图',
  `linkurl` varchar(80) NOT NULL COMMENT '碎片数据连接',
  `content` mediumtext NOT NULL COMMENT '碎片数据内容',
  `posttime` int(10) unsigned NOT NULL COMMENT '发布时间',
  `lang` varchar(8) NOT NULL,
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '编辑时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ss_cms_cate
-- ----------------------------
DROP TABLE IF EXISTS `ss_cms_cate`;
CREATE TABLE `ss_cms_cate` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '二级类别id',
  `parentid` int(11) unsigned NOT NULL COMMENT '类别上级id',
  `parentstr` varchar(50) NOT NULL COMMENT '类别上级id字符串',
  `catename` varchar(30) NOT NULL COMMENT '类别名称',
  `linkurl` varchar(255) NOT NULL COMMENT '跳转链接',
  `seotitle` varchar(80) NOT NULL COMMENT 'SEO标题',
  `keywords` varchar(50) NOT NULL COMMENT 'SEO关键词',
  `description` varchar(255) NOT NULL COMMENT 'SEO描述',
  `orderid` int(11) unsigned NOT NULL COMMENT '排列排序',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '审核状态',
  `lang` varchar(8) NOT NULL COMMENT '多语言',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '编辑时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ss_cms_column
-- ----------------------------
DROP TABLE IF EXISTS `ss_cms_column`;
CREATE TABLE `ss_cms_column` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '栏目id',
  `parentid` int(11) unsigned NOT NULL COMMENT '栏目上级id',
  `parentstr` varchar(50) NOT NULL COMMENT '栏目上级id字符串',
  `type` tinyint(1) unsigned NOT NULL COMMENT '栏目类型',
  `cname` varchar(30) NOT NULL COMMENT '栏目名称',
  `linkurl` varchar(255) NOT NULL COMMENT '跳转链接',
  `picurl` varchar(100) NOT NULL COMMENT '缩略图片',
  `picwidth` varchar(5) NOT NULL COMMENT '缩略图宽度',
  `picheight` varchar(5) NOT NULL COMMENT '缩略图高度',
  `seotitle` varchar(80) NOT NULL COMMENT 'SEO标题',
  `keywords` varchar(50) NOT NULL COMMENT 'SEO关键词',
  `description` varchar(255) NOT NULL COMMENT 'SEO描述',
  `orderid` int(11) unsigned NOT NULL COMMENT '排列排序',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '审核状态',
  `lang` varchar(8) NOT NULL,
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '编辑时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ss_cms_file
-- ----------------------------
DROP TABLE IF EXISTS `ss_cms_file`;
CREATE TABLE `ss_cms_file` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '软件信息id',
  `columnid` int(11) unsigned NOT NULL COMMENT '所属栏目id',
  `parentid` int(11) unsigned NOT NULL COMMENT '所属栏目上级id',
  `parentstr` varchar(80) NOT NULL COMMENT '所属栏目上级id字符串',
  `cateid` int(11) unsigned DEFAULT NULL COMMENT '类别id',
  `catepid` int(11) unsigned DEFAULT NULL COMMENT '类别父id',
  `catepstr` varchar(80) DEFAULT NULL COMMENT '多级父id',
  `title` varchar(80) NOT NULL COMMENT '标题',
  `colorval` char(10) NOT NULL COMMENT '字体颜色',
  `boldval` char(10) NOT NULL COMMENT '字体加粗',
  `flag` varchar(30) NOT NULL COMMENT '属性',
  `source` varchar(50) NOT NULL COMMENT '文章来源',
  `author` varchar(50) NOT NULL COMMENT '作者编辑',
  `filetype` char(4) NOT NULL COMMENT '文件类型',
  `filesize` varchar(10) NOT NULL COMMENT '软件大小',
  `website` varchar(255) NOT NULL COMMENT '官方网站',
  `demourl` varchar(255) NOT NULL COMMENT '演示地址',
  `dlurl` varchar(255) NOT NULL COMMENT '下载地址',
  `linkurl` varchar(255) NOT NULL COMMENT '跳转链接',
  `keywords` varchar(50) NOT NULL COMMENT '关键字',
  `description` varchar(255) NOT NULL COMMENT '描述',
  `content` mediumtext NOT NULL COMMENT '内容',
  `picurl` varchar(100) NOT NULL COMMENT '缩略图片',
  `picarr` text NOT NULL COMMENT '截图展示',
  `hits` mediumint(8) unsigned NOT NULL COMMENT '点击次数',
  `orderid` int(11) unsigned NOT NULL COMMENT '排列排序',
  `posttime` int(11) NOT NULL COMMENT '更新时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '审核状态',
  `delstate` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '删除状态',
  `deltime` int(10) unsigned NOT NULL COMMENT '删除时间',
  `lang` varchar(8) NOT NULL,
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '编辑时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ss_cms_flag
-- ----------------------------
DROP TABLE IF EXISTS `ss_cms_flag`;
CREATE TABLE `ss_cms_flag` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '信息标记id',
  `flag` varchar(30) NOT NULL DEFAULT '' COMMENT '标记值',
  `flagname` varchar(30) NOT NULL DEFAULT '' COMMENT '标记名称',
  `orderid` int(11) unsigned NOT NULL DEFAULT '10' COMMENT '排列排序',
  `type` tinyint(2) NOT NULL COMMENT '所属栏目类型',
  `lang` varchar(8) NOT NULL DEFAULT '',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '编辑时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ss_cms_info
-- ----------------------------
DROP TABLE IF EXISTS `ss_cms_info`;
CREATE TABLE `ss_cms_info` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '单页id',
  `columnid` int(11) unsigned NOT NULL COMMENT '所属栏目id',
  `picurl` varchar(100) NOT NULL COMMENT '缩略图片',
  `content` mediumtext NOT NULL COMMENT '内容',
  `posttime` int(10) unsigned NOT NULL COMMENT '发布时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ss_cms_photo
-- ----------------------------
DROP TABLE IF EXISTS `ss_cms_photo`;
CREATE TABLE `ss_cms_photo` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '图片信息id',
  `columnid` int(11) unsigned NOT NULL COMMENT '所属栏目id',
  `parentid` int(11) unsigned NOT NULL COMMENT '所属栏目上级id',
  `parentstr` varchar(80) NOT NULL COMMENT '所属栏目上级id字符串',
  `cateid` int(11) unsigned DEFAULT NULL COMMENT '类别id',
  `catepid` int(11) unsigned DEFAULT NULL COMMENT '类别父id',
  `catepstr` varchar(80) DEFAULT NULL COMMENT '所属类别上级id字符串',
  `title` varchar(80) NOT NULL COMMENT '标题',
  `colorval` char(10) NOT NULL COMMENT '字体颜色',
  `boldval` char(10) NOT NULL COMMENT '字体加粗',
  `flag` varchar(30) NOT NULL COMMENT '属性',
  `source` varchar(50) NOT NULL COMMENT '文章来源',
  `author` varchar(50) NOT NULL COMMENT '作者编辑',
  `linkurl` varchar(255) NOT NULL COMMENT '跳转链接',
  `keywords` varchar(50) NOT NULL COMMENT '关键词',
  `description` varchar(255) NOT NULL COMMENT '摘要',
  `content` mediumtext NOT NULL COMMENT '详细内容',
  `picurl` varchar(100) NOT NULL COMMENT '缩略图片',
  `picarr` text NOT NULL COMMENT '组图',
  `hits` int(11) unsigned NOT NULL COMMENT '点击次数',
  `orderid` int(11) unsigned NOT NULL COMMENT '排列排序',
  `posttime` int(11) NOT NULL COMMENT '更新时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '审核状态',
  `delstate` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '删除状态',
  `deltime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间',
  `lang` varchar(8) NOT NULL,
  `created_at` int(10) unsigned NOT NULL DEFAULT '0',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ss_cms_src
-- ----------------------------
DROP TABLE IF EXISTS `ss_cms_src`;
CREATE TABLE `ss_cms_src` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '来源id',
  `srcname` varchar(50) NOT NULL COMMENT '来源名称',
  `linkurl` varchar(150) NOT NULL COMMENT '来源地址',
  `orderid` int(11) unsigned NOT NULL COMMENT '来源排序',
  `lang` varchar(8) NOT NULL,
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '编辑时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ss_cms_tag
-- ----------------------------
DROP TABLE IF EXISTS `ss_cms_tag`;
CREATE TABLE `ss_cms_tag` (
  `tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL DEFAULT '',
  `frequency` int(11) unsigned NOT NULL DEFAULT '0',
  `slug` varchar(128) NOT NULL DEFAULT '',
  `lang` varchar(8) NOT NULL DEFAULT '' COMMENT '简体中文',
  PRIMARY KEY (`tag_id`),
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ss_cms_tag_assign
-- ----------------------------
DROP TABLE IF EXISTS `ss_cms_tag_assign`;
CREATE TABLE `ss_cms_tag_assign` (
  `class` varchar(128) NOT NULL DEFAULT '',
  `item_id` int(11) unsigned DEFAULT NULL,
  `tag_id` int(11) unsigned DEFAULT NULL,
  KEY `class` (`class`) USING BTREE,
  KEY `item_tag` (`item_id`,`tag_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='标签应用';

-- ----------------------------
-- Table structure for ss_cms_video
-- ----------------------------
DROP TABLE IF EXISTS `ss_cms_video`;
CREATE TABLE `ss_cms_video` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '视频信息id',
  `columnid` int(11) unsigned NOT NULL COMMENT '所属栏目id',
  `parentid` int(11) unsigned NOT NULL COMMENT '所属栏目上级id',
  `parentstr` varchar(80) NOT NULL COMMENT '所属栏目上级id字符串',
  `cateid` int(11) unsigned DEFAULT NULL COMMENT '所属类别id',
  `catepid` int(11) unsigned DEFAULT NULL COMMENT '所属类别上级id',
  `catepstr` varchar(80) DEFAULT NULL COMMENT '所属类别上级id字符串',
  `title` varchar(80) NOT NULL COMMENT '标题',
  `colorval` char(10) NOT NULL COMMENT '字体颜色',
  `boldval` char(10) NOT NULL COMMENT '字体加粗',
  `flag` varchar(30) NOT NULL COMMENT '属性',
  `source` varchar(50) NOT NULL COMMENT '文章来源',
  `author` varchar(50) NOT NULL COMMENT '作者编辑',
  `linkurl` varchar(255) NOT NULL COMMENT '跳转链接',
  `keywords` varchar(50) NOT NULL COMMENT '关键词',
  `description` varchar(255) NOT NULL COMMENT '摘要',
  `content` mediumtext NOT NULL COMMENT '详细内容',
  `picurl` varchar(100) NOT NULL COMMENT '缩略视频',
  `videolink` text NOT NULL COMMENT '视频地址',
  `hits` int(11) unsigned NOT NULL COMMENT '点击次数',
  `orderid` int(11) unsigned NOT NULL COMMENT '排列排序',
  `posttime` int(10) unsigned NOT NULL COMMENT '更新时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '审核状态',
  `delstate` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '删除状态',
  `deltime` int(10) unsigned NOT NULL COMMENT '删除时间',
  `lang` varchar(8) NOT NULL,
  `created_at` int(10) unsigned NOT NULL DEFAULT '0',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ss_diy_field
-- ----------------------------
DROP TABLE IF EXISTS `ss_diy_field`;
CREATE TABLE `ss_diy_field` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自定义字段id',
  `infotype` tinyint(1) unsigned NOT NULL COMMENT '所属模型',
  `catepriv` varchar(255) NOT NULL COMMENT '所属栏目',
  `fieldname` varchar(30) NOT NULL COMMENT '字段名称',
  `fieldtitle` varchar(30) NOT NULL COMMENT '字段标题',
  `fielddesc` varchar(255) NOT NULL COMMENT '字段提示',
  `fieldtype` varchar(30) NOT NULL COMMENT '字段类型',
  `fieldlong` varchar(10) NOT NULL COMMENT '字段长度',
  `fieldsel` varchar(255) NOT NULL COMMENT '字段选项值',
  `fieldcheck` varchar(80) NOT NULL COMMENT '校验正则',
  `fieldcback` varchar(30) NOT NULL COMMENT '未通过提示',
  `orderid` int(11) unsigned NOT NULL COMMENT '排列排序',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '审核状态',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '编辑时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ss_diy_menu
-- ----------------------------
DROP TABLE IF EXISTS `ss_diy_menu`;
CREATE TABLE `ss_diy_menu` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '自定义菜单id',
  `parentid` smallint(5) unsigned NOT NULL COMMENT '所属菜单id',
  `name` varchar(30) NOT NULL COMMENT '菜单项名称',
  `linkurl` varchar(255) NOT NULL COMMENT '跳转链接',
  `orderid` smallint(5) unsigned NOT NULL COMMENT '排列排序',
  `checkinfo` enum('true','false') NOT NULL COMMENT '审核状态',
  `lang` varchar(8) NOT NULL,
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '编辑时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ss_diy_model
-- ----------------------------
DROP TABLE IF EXISTS `ss_diy_model`;
CREATE TABLE `ss_diy_model` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自定义模型id',
  `modeltitle` varchar(30) NOT NULL COMMENT '模型标题',
  `modelname` varchar(30) NOT NULL COMMENT '模型名称',
  `modeltbname` varchar(30) NOT NULL COMMENT '模型表名',
  `defaultfield` varchar(80) NOT NULL COMMENT '预设栏目',
  `orderid` int(11) NOT NULL COMMENT '排列排序',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '审核状态',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ss_ext_ad
-- ----------------------------
DROP TABLE IF EXISTS `ss_ext_ad`;
CREATE TABLE `ss_ext_ad` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '信息id',
  `ad_type_id` int(5) unsigned NOT NULL COMMENT '投放范围(广告位)',
  `parentid` int(5) unsigned NOT NULL COMMENT '所属广告位父id',
  `parentstr` varchar(80) NOT NULL COMMENT '所属广告位父id字符串',
  `title` varchar(30) NOT NULL COMMENT '广告标识',
  `admode` char(10) NOT NULL COMMENT '展示模式',
  `picurl` varchar(100) NOT NULL COMMENT '上传内容地址',
  `adtext` text NOT NULL COMMENT '展示内容',
  `linkurl` varchar(255) NOT NULL COMMENT '跳转链接',
  `orderid` int(5) unsigned NOT NULL COMMENT '排列排序',
  `posttime` int(10) unsigned NOT NULL COMMENT '提交时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '审核状态',
  `lang` varchar(8) NOT NULL,
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '编辑时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ss_ext_ad_type
-- ----------------------------
DROP TABLE IF EXISTS `ss_ext_ad_type`;
CREATE TABLE `ss_ext_ad_type` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '广告位id',
  `parentid` int(11) unsigned NOT NULL COMMENT '上级id',
  `parentstr` varchar(50) NOT NULL COMMENT '上级id字符串',
  `typename` varchar(30) NOT NULL COMMENT '广告位名称',
  `width` smallint(5) unsigned NOT NULL DEFAULT '100' COMMENT '广告位宽度',
  `height` smallint(5) unsigned NOT NULL DEFAULT '100' COMMENT '广告位高度',
  `orderid` int(11) unsigned NOT NULL COMMENT '排列顺序',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '审核状态',
  `lang` varchar(8) NOT NULL,
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '编辑时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ss_ext_job
-- ----------------------------
DROP TABLE IF EXISTS `ss_ext_job`;
CREATE TABLE `ss_ext_job` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '招聘信息id',
  `title` varchar(50) NOT NULL COMMENT '位岗名称',
  `jobplace` varchar(80) NOT NULL COMMENT '工作地点',
  `jobdescription` varchar(50) NOT NULL COMMENT '工作性质',
  `employ` smallint(5) unsigned NOT NULL COMMENT '招聘人数',
  `jobsex` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '性别要求，1为男',
  `treatment` varchar(50) NOT NULL COMMENT '工资待遇',
  `usefullife` varchar(50) NOT NULL COMMENT '有效期',
  `experience` varchar(50) NOT NULL COMMENT '工作经验',
  `education` varchar(80) NOT NULL COMMENT '学历要求',
  `joblang` varchar(50) NOT NULL COMMENT '言语能力',
  `workdesc` mediumtext NOT NULL COMMENT '职位描述',
  `content` mediumtext NOT NULL COMMENT '职位要求',
  `orderid` mediumint(8) unsigned NOT NULL COMMENT '排列排序',
  `posttime` int(10) unsigned NOT NULL COMMENT '更新时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '审核状态',
  `lang` varchar(8) NOT NULL,
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '编辑时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ss_ext_link
-- ----------------------------
DROP TABLE IF EXISTS `ss_ext_link`;
CREATE TABLE `ss_ext_link` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '友情链接id',
  `link_type_id` int(11) unsigned NOT NULL COMMENT '所属类别id',
  `parentid` int(11) unsigned NOT NULL COMMENT '所属类别父id',
  `parentstr` varchar(80) NOT NULL COMMENT '所属类别父id字符串',
  `webname` varchar(30) NOT NULL COMMENT '网站名称',
  `webnote` varchar(200) NOT NULL COMMENT '网站描述',
  `picurl` varchar(100) NOT NULL COMMENT '缩略图片',
  `linkurl` varchar(255) NOT NULL COMMENT '跳转链接',
  `orderid` int(11) unsigned NOT NULL COMMENT '排列排序',
  `posttime` int(10) unsigned NOT NULL COMMENT '更新时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '审核状态',
  `lang` varchar(8) NOT NULL,
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '编辑时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ss_ext_link_type
-- ----------------------------
DROP TABLE IF EXISTS `ss_ext_link_type`;
CREATE TABLE `ss_ext_link_type` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '友情链接类型id',
  `parentid` int(11) unsigned NOT NULL COMMENT '类别父id',
  `parentstr` varchar(50) NOT NULL COMMENT '类别父id字符串',
  `typename` varchar(30) NOT NULL COMMENT '类别名称',
  `orderid` int(11) unsigned NOT NULL COMMENT '排列顺序',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '审核状态',
  `lang` varchar(8) NOT NULL,
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '编辑时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

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
  `orderid` int(11) unsigned NOT NULL COMMENT '排列排序',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '导航状态',
  `lang` varchar(8) NOT NULL,
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '编辑时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ss_ext_vote
-- ----------------------------
DROP TABLE IF EXISTS `ss_ext_vote`;
CREATE TABLE `ss_ext_vote` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '投票id',
  `title` varchar(30) NOT NULL COMMENT '投票标题',
  `content` text NOT NULL COMMENT '投票描述',
  `starttime` int(10) unsigned NOT NULL COMMENT '开始时间',
  `endtime` int(10) unsigned NOT NULL COMMENT '结束时间',
  `isguest` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '游客投票',
  `isview` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '查看投票',
  `intval` int(10) unsigned NOT NULL COMMENT '投票间隔',
  `isradio` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否多选',
  `orderid` int(11) unsigned NOT NULL COMMENT '排列排序',
  `posttime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '审核状态',
  `lang` varchar(8) NOT NULL,
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '编辑时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ss_ext_vote_data
-- ----------------------------
DROP TABLE IF EXISTS `ss_ext_vote_data`;
CREATE TABLE `ss_ext_vote_data` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '投票数据id',
  `voteid` int(11) unsigned NOT NULL COMMENT '投票id',
  `optionid` text NOT NULL COMMENT '选票id',
  `memberid` int(11) unsigned NOT NULL COMMENT '投票人id',
  `posttime` int(10) unsigned NOT NULL COMMENT '投票时间',
  `ip` varchar(30) NOT NULL COMMENT '投票ip',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ss_ext_vote_option
-- ----------------------------
DROP TABLE IF EXISTS `ss_ext_vote_option`;
CREATE TABLE `ss_ext_vote_option` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '投票选项id',
  `voteid` int(11) unsigned NOT NULL COMMENT '投票id',
  `options` varchar(30) NOT NULL COMMENT '投票选项',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ss_migration
-- ----------------------------
DROP TABLE IF EXISTS `ss_migration`;
CREATE TABLE `ss_migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ss_session
-- ----------------------------
DROP TABLE IF EXISTS `ss_session`;
CREATE TABLE `ss_session` (
  `id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) unsigned DEFAULT NULL COMMENT '管理员id',
  `ip` varchar(128) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '访客ip',
  `is_trusted` tinyint(1) DEFAULT '1' COMMENT '是否受信',
  `expire` int(11) DEFAULT NULL,
  `data` blob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for ss_shop_attribute
-- ----------------------------
DROP TABLE IF EXISTS `ss_shop_attribute`;
CREATE TABLE `ss_shop_attribute` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品属性id',
  `pcateid` int(11) unsigned NOT NULL COMMENT '所属分类',
  `attrname` varchar(30) NOT NULL COMMENT '属性名称',
  `type` varchar(12) NOT NULL DEFAULT 'text' COMMENT '值有：text、select、checkbox、radio',
  `typetext` varchar(255) NOT NULL DEFAULT '' COMMENT '默认可选值',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '审核状态',
  `lang` varchar(8) NOT NULL COMMENT '多语言',
  `orderid` int(11) unsigned NOT NULL COMMENT '排列排序',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '编辑时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ss_shop_brand
-- ----------------------------
DROP TABLE IF EXISTS `ss_shop_brand`;
CREATE TABLE `ss_shop_brand` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '品牌id',
  `bname` varchar(30) NOT NULL COMMENT '品牌名称',
  `picurl` varchar(100) NOT NULL COMMENT '品牌图片',
  `bnote` text NOT NULL COMMENT '品牌介绍',
  `linkurl` varchar(255) NOT NULL COMMENT '跳转链接',
  `orderid` int(11) unsigned NOT NULL COMMENT '排列排序',
  `lang` varchar(8) NOT NULL COMMENT '多语言',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '审核状态',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '编辑时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ss_shop_getmode
-- ----------------------------
DROP TABLE IF EXISTS `ss_shop_getmode`;
CREATE TABLE `ss_shop_getmode` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '货到方式id',
  `classname` varchar(30) NOT NULL COMMENT '货到方式名称',
  `orderid` smallint(5) unsigned NOT NULL COMMENT '排列排序',
  `checkinfo` enum('true','false') NOT NULL COMMENT '审核状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ss_shop_order
-- ----------------------------
DROP TABLE IF EXISTS `ss_shop_order`;
CREATE TABLE `ss_shop_order` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品订单id',
  `siteid` int(11) unsigned NOT NULL COMMENT '站点id',
  `username` varchar(30) NOT NULL COMMENT '会员用户名',
  `attrstr` text NOT NULL COMMENT '商品列表',
  `truename` varchar(30) NOT NULL COMMENT '收货人姓名',
  `telephone` varchar(30) NOT NULL COMMENT '电话',
  `idcard` varchar(30) NOT NULL COMMENT '证件号码',
  `zipcode` varchar(30) NOT NULL COMMENT '邮编',
  `postarea_prov` varchar(10) NOT NULL COMMENT '配送地区_省',
  `postarea_city` varchar(10) NOT NULL COMMENT '配送地区_市',
  `postarea_country` varchar(10) NOT NULL COMMENT '配送地区_县',
  `address` varchar(80) NOT NULL COMMENT '地址',
  `postmode` smallint(5) NOT NULL COMMENT '配送方式',
  `paymode` smallint(5) NOT NULL COMMENT '支付方式',
  `getmode` smallint(5) NOT NULL COMMENT '货到方式',
  `ordernum` varchar(30) NOT NULL COMMENT '订单号',
  `postid` varchar(30) NOT NULL COMMENT '运单号',
  `weight` varchar(10) NOT NULL COMMENT '物品重量',
  `cost` varchar(10) NOT NULL COMMENT '商品运费',
  `amount` varchar(10) NOT NULL COMMENT '订单金额',
  `integral` int(8) unsigned NOT NULL COMMENT '积分点数',
  `buyremark` text NOT NULL COMMENT '购物备注',
  `sendremark` text NOT NULL COMMENT '发货方备注',
  `posttime` int(10) unsigned NOT NULL COMMENT '订单时间',
  `orderid` int(11) unsigned NOT NULL COMMENT '排列排序',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '审核状态',
  `core` set('true') NOT NULL COMMENT '是否加星',
  `delstate` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '删除状态',
  `deltime` int(10) unsigned NOT NULL COMMENT '删除时间',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '编辑时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ss_shop_payment
-- ----------------------------
DROP TABLE IF EXISTS `ss_shop_payment`;
CREATE TABLE `ss_shop_payment` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '支付方式id',
  `classname` varchar(30) NOT NULL COMMENT '支付方式名称',
  `orderid` smallint(5) unsigned NOT NULL COMMENT '排列排序',
  `checkinfo` enum('true','false') NOT NULL COMMENT '审核状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ss_shop_product
-- ----------------------------
DROP TABLE IF EXISTS `ss_shop_product`;
CREATE TABLE `ss_shop_product` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品id',
  `columnid` int(11) unsigned NOT NULL COMMENT '所属栏目',
  `pcateid` int(11) unsigned NOT NULL COMMENT '产品分类id',
  `pcatepid` int(11) unsigned NOT NULL COMMENT '产品分类父id',
  `pcatepstr` varchar(80) NOT NULL COMMENT '所有产品分类的上级id字符串',
  `attrtext` text NOT NULL COMMENT '属性json值',
  `brand_id` int(11) NOT NULL COMMENT '商品品牌id',
  `title` varchar(100) NOT NULL COMMENT '商品名称',
  `colorval` char(10) NOT NULL COMMENT '标题颜色',
  `boldval` char(10) NOT NULL COMMENT '标题加粗',
  `subtitle` varchar(150) DEFAULT '' COMMENT '副标题',
  `keywords` varchar(30) NOT NULL COMMENT '关键词',
  `description` varchar(255) NOT NULL COMMENT '摘要',
  `flag` varchar(30) NOT NULL COMMENT '属性',
  `sku` varchar(100) NOT NULL DEFAULT '' COMMENT '产品SKU',
  `product_sn` varchar(30) NOT NULL DEFAULT '' COMMENT '货号',
  `weight` decimal(10,2) NOT NULL COMMENT '重量',
  `market_price` float(10,2) NOT NULL COMMENT '市场价格',
  `sales_price` float(10,2) NOT NULL COMMENT '销售价格',
  `is_promote` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否促销',
  `promote_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '促销价',
  `promote_start_date` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '促销开始日期',
  `promote_end_date` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '促销结束日期',
  `stock` smallint(5) unsigned NOT NULL COMMENT '库存数量',
  `warn_num` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '警告数量，如果为0则不警告',
  `is_shipping` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否配送',
  `point` int(8) NOT NULL DEFAULT '0' COMMENT '返点积分',
  `linkurl` varchar(255) NOT NULL COMMENT '跳转链接',
  `content` mediumtext NOT NULL COMMENT '详细内容',
  `picurl` varchar(100) NOT NULL COMMENT '缩略图片',
  `picarr` text NOT NULL COMMENT '组图',
  `is_best` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '最爱',
  `is_new` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '新品',
  `is_hot` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '最热',
  `hits` int(11) unsigned NOT NULL COMMENT '点击次数',
  `author` varchar(20) NOT NULL DEFAULT '',
  `orderid` int(11) unsigned NOT NULL COMMENT '排列排序',
  `posttime` int(10) unsigned NOT NULL COMMENT '上架时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '上下架状态',
  `delstate` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '删除状态',
  `deltime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间',
  `lang` varchar(8) NOT NULL COMMENT '多语言',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '编辑时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ss_shop_product_cate
-- ----------------------------
DROP TABLE IF EXISTS `ss_shop_product_cate`;
CREATE TABLE `ss_shop_product_cate` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品类型id',
  `parentid` int(11) unsigned NOT NULL COMMENT '类型上级id',
  `parentstr` varchar(50) NOT NULL COMMENT '类型上级id字符串',
  `cname` varchar(30) NOT NULL COMMENT '类别名称',
  `ctext` text COMMENT '链接集合',
  `picurl` varchar(255) DEFAULT NULL COMMENT '缩略图片',
  `linkurl` varchar(255) DEFAULT NULL COMMENT '跳转链接',
  `orderid` int(11) unsigned NOT NULL DEFAULT '10' COMMENT '排列顺序',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否显示',
  `lang` varchar(8) NOT NULL,
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '编辑时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ss_shop_shipping
-- ----------------------------
DROP TABLE IF EXISTS `ss_shop_shipping`;
CREATE TABLE `ss_shop_shipping` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '配送方式id',
  `classname` varchar(30) NOT NULL COMMENT '配送方式',
  `postprice` varchar(10) NOT NULL COMMENT '配送价格',
  `orderid` smallint(5) unsigned NOT NULL COMMENT '排列排序',
  `checkinfo` enum('true','false') NOT NULL COMMENT '审核状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ss_site_help
-- ----------------------------
DROP TABLE IF EXISTS `ss_site_help`;
CREATE TABLE `ss_site_help` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '列表信息id',
  `parentid` int(11) unsigned NOT NULL COMMENT '所属栏目上级id',
  `parentstr` varchar(80) NOT NULL COMMENT '所属栏目上级id字符串',
  `cateid` int(11) unsigned DEFAULT NULL COMMENT '类别id',
  `catepid` int(11) unsigned DEFAULT NULL COMMENT '类别父id',
  `catepstr` varchar(80) DEFAULT NULL COMMENT '所属类别上级id字符串',
  `title` varchar(80) NOT NULL COMMENT '标题',
  `colorval` char(10) NOT NULL COMMENT '字体颜色',
  `boldval` char(10) NOT NULL COMMENT '字体加粗',
  `flag` varchar(30) NOT NULL COMMENT '属性',
  `author` varchar(50) NOT NULL COMMENT '作者编辑',
  `linkurl` varchar(255) NOT NULL COMMENT '跳转链接',
  `keywords` varchar(50) NOT NULL COMMENT '关键词',
  `description` varchar(255) NOT NULL COMMENT '摘要',
  `content` mediumtext NOT NULL COMMENT '详细内容',
  `picurl` varchar(100) NOT NULL COMMENT '缩略图片',
  `picarr` text NOT NULL COMMENT '组图',
  `hits` mediumint(8) unsigned NOT NULL COMMENT '点击次数',
  `orderid` int(10) unsigned NOT NULL COMMENT '排列排序',
  `posttime` int(10) NOT NULL COMMENT '更新时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '审核状态',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '编辑时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ss_site_help_cate
-- ----------------------------
DROP TABLE IF EXISTS `ss_site_help_cate`;
CREATE TABLE `ss_site_help_cate` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '二级类别id',
  `parentid` int(11) unsigned NOT NULL COMMENT '类别上级id',
  `parentstr` varchar(50) NOT NULL COMMENT '类别上级id字符串',
  `catename` varchar(30) NOT NULL COMMENT '类别名称',
  `linkurl` varchar(255) NOT NULL COMMENT '跳转链接',
  `seotitle` varchar(80) NOT NULL COMMENT 'SEO标题',
  `keywords` varchar(50) NOT NULL COMMENT 'SEO关键词',
  `description` varchar(255) NOT NULL COMMENT 'SEO描述',
  `orderid` int(11) unsigned NOT NULL COMMENT '排列排序',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '审核状态',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '编辑时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ss_site_help_flag
-- ----------------------------
DROP TABLE IF EXISTS `ss_site_help_flag`;
CREATE TABLE `ss_site_help_flag` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '信息标记id',
  `flag` varchar(30) NOT NULL DEFAULT '' COMMENT '标记值',
  `flagname` varchar(30) NOT NULL DEFAULT '' COMMENT '标记名称',
  `orderid` int(11) unsigned NOT NULL DEFAULT '10' COMMENT '排列排序',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '编辑时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ss_site_lnk
-- ----------------------------
DROP TABLE IF EXISTS `ss_site_lnk`;
CREATE TABLE `ss_site_lnk` (
  `lnk_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '快捷方式id',
  `lnk_name` varchar(30) NOT NULL COMMENT '快捷方式名称',
  `lnk_link` varchar(100) NOT NULL COMMENT '跳转链接',
  `lnk_ico` varchar(50) NOT NULL COMMENT 'ico地址',
  `orderid` smallint(5) unsigned NOT NULL COMMENT '排列排序',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`lnk_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='管理者的快捷键';

-- ----------------------------
-- Table structure for ss_site_topic
-- ----------------------------
DROP TABLE IF EXISTS `ss_site_topic`;
CREATE TABLE `ss_site_topic` (
  `topic_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`topic_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ss_sys_admin
-- ----------------------------
DROP TABLE IF EXISTS `ss_sys_admin`;
CREATE TABLE `ss_sys_admin` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '信息id',
  `username` varchar(30) NOT NULL COMMENT '用户名',
  `nickname` char(32) NOT NULL COMMENT '昵称',
  `question` tinyint(1) unsigned DEFAULT NULL COMMENT '登录提问',
  `answer` varchar(50) DEFAULT NULL COMMENT '登录回答',
  `loginip` char(20) NOT NULL COMMENT '登录IP',
  `logintime` int(10) unsigned NOT NULL COMMENT '登录时间',
  `auth_key` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `password_hash` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '手机号码',
  `status` tinyint(5) NOT NULL DEFAULT '1',
  `role_id` tinyint(5) unsigned DEFAULT NULL COMMENT '角色',
  `favorite_menu` text NOT NULL COMMENT '快捷菜单',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ss_sys_config
-- ----------------------------
DROP TABLE IF EXISTS `ss_sys_config`;
CREATE TABLE `ss_sys_config` (
  `cfg_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `varname` varchar(50) NOT NULL COMMENT '变量名称',
  `varinfo` varchar(80) NOT NULL COMMENT '参数说明',
  `vargroup` tinyint(5) NOT NULL COMMENT '所属组',
  `vartype` char(12) NOT NULL DEFAULT 'string' COMMENT '变量类型',
  `varvalue` text NOT NULL COMMENT '变量值',
  `vardefault` varchar(150) NOT NULL COMMENT '默认参考值',
  `orderid` smallint(5) unsigned NOT NULL DEFAULT '10' COMMENT '排列排序',
  `lang` varchar(8) NOT NULL COMMENT '多语言',
  `visible` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否直接可视操作',
  PRIMARY KEY (`cfg_id`)
) ENGINE=InnoDB AUTO_INCREMENT=197 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ss_sys_devlog
-- ----------------------------
DROP TABLE IF EXISTS `ss_sys_devlog`;
CREATE TABLE `ss_sys_devlog` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `log_name` varchar(50) NOT NULL DEFAULT '' COMMENT '更新描述',
  `log_code` varchar(50) NOT NULL DEFAULT '' COMMENT '更新编码，与v版本号有关V+T',
  `log_note` text NOT NULL COMMENT '更新详情',
  `log_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间，手动选择，用于展示',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '实际增加时间',
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ss_sys_face
-- ----------------------------
DROP TABLE IF EXISTS `ss_sys_face`;
CREATE TABLE `ss_sys_face` (
  `face_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`face_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ss_sys_log
-- ----------------------------
DROP TABLE IF EXISTS `ss_sys_log`;
CREATE TABLE `ss_sys_log` (
  `log_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) unsigned DEFAULT NULL COMMENT '管理员id',
  `username` varchar(80) NOT NULL DEFAULT '' COMMENT '管理员名',
  `route` varchar(100) NOT NULL DEFAULT '' COMMENT '操作的路由',
  `name` varchar(150) NOT NULL DEFAULT '' COMMENT '记录详情',
  `method` varchar(10) NOT NULL DEFAULT '' COMMENT '操作方法',
  `get_data` text NOT NULL COMMENT 'get数据',
  `post_data` text NOT NULL COMMENT '改变的数据',
  `ip` varchar(50) NOT NULL COMMENT '操作IP地址',
  `agent` text NOT NULL,
  `md5` varchar(40) NOT NULL DEFAULT '',
  `lang` varchar(8) NOT NULL COMMENT '多语言',
  `created_at` varchar(50) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7679 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ss_sys_multilang_tpl
-- ----------------------------
DROP TABLE IF EXISTS `ss_sys_multilang_tpl`;
CREATE TABLE `ss_sys_multilang_tpl` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '站点ID',
  `lang_name` varchar(30) NOT NULL COMMENT '站点名称：简体中文、English、xxx子网站',
  `template_id` int(11) NOT NULL DEFAULT '-1' COMMENT '模板id',
  `lang_sign` varchar(50) NOT NULL DEFAULT '' COMMENT '站点语言包，此语言包必须要有模板的支持',
  `key` varchar(30) NOT NULL DEFAULT '' COMMENT '站点标识，用于站点访问链接优化标识',
  `back_default` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否后台默认',
  `front_default` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否前台默认',
  `orderid` int(10) unsigned NOT NULL DEFAULT '10' COMMENT '排序',
  `is_visible` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否显示在前台站点切换',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ss_sys_role
-- ----------------------------
DROP TABLE IF EXISTS `ss_sys_role`;
CREATE TABLE `ss_sys_role` (
  `role_id` tinyint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '角色id',
  `role_name` varchar(30) NOT NULL DEFAULT '' COMMENT '角色名称',
  `note` text NOT NULL COMMENT '角色描述',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '角色状态',
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ss_sys_role_item
-- ----------------------------
DROP TABLE IF EXISTS `ss_sys_role_item`;
CREATE TABLE `ss_sys_role_item` (
  `role_id` int(10) unsigned NOT NULL COMMENT '所属管理组id',
  `route` varchar(50) NOT NULL DEFAULT '',
  `column_id` int(10) unsigned DEFAULT NULL COMMENT '类型id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ss_sys_template
-- ----------------------------
DROP TABLE IF EXISTS `ss_sys_template`;
CREATE TABLE `ss_sys_template` (
  `temp_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '模板id',
  `temp_name` varchar(100) NOT NULL COMMENT '模板名称',
  `temp_code` varchar(50) NOT NULL COMMENT '模板编码',
  `picurl` varchar(150) NOT NULL COMMENT '模板缩略图',
  `picarr` text NOT NULL COMMENT '模板图片组',
  `note` text NOT NULL COMMENT '模板说明',
  `langs` varchar(180) NOT NULL COMMENT '支持哪些语言，json格式',
  `design_name` varchar(30) NOT NULL COMMENT '设计师',
  `developer_name` varchar(30) NOT NULL COMMENT '模板开发者',
  `posttime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '开发的发布时间',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '编辑时间',
  PRIMARY KEY (`temp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='站点管理表\r\n\r\n1.一个站点包含多个语言\r\n2.语言可以自由增加和删除\r\n3.一个站点只有一个管理员\r\n3.管理员及以上的身份可以创建作者';

-- ----------------------------
-- Table structure for ss_uploads
-- ----------------------------
DROP TABLE IF EXISTS `ss_uploads`;
CREATE TABLE `ss_uploads` (
  `id` mediumint(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '上传信息id',
  `name` varchar(30) NOT NULL COMMENT '文件名称',
  `path` varchar(100) NOT NULL COMMENT '文件路径',
  `size` int(10) NOT NULL COMMENT '文件大小',
  `type` enum('image','soft','media') NOT NULL COMMENT '文件类型',
  `posttime` int(10) NOT NULL COMMENT '上传日期',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ss_user
-- ----------------------------
DROP TABLE IF EXISTS `ss_user`;
CREATE TABLE `ss_user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `username` varchar(32) NOT NULL COMMENT '用户名',
  `email` varchar(40) NOT NULL COMMENT '电子邮件',
  `mobile` varchar(20) NOT NULL COMMENT '手机',
  `password` varchar(32) NOT NULL COMMENT '密码',
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
-- Table structure for ss_user_comment
-- ----------------------------
DROP TABLE IF EXISTS `ss_user_comment`;
CREATE TABLE `ss_user_comment` (
  `uc_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '评论id',
  `uc_pid` int(10) NOT NULL DEFAULT '-1' COMMENT '回复的主评论id，自己是主评论时，值为-1',
  `uc_typeid` tinyint(5) unsigned NOT NULL COMMENT '信息类型',
  `uc_model_id` int(11) unsigned NOT NULL COMMENT '信息id',
  `uid` int(11) NOT NULL DEFAULT '-1' COMMENT '用户id',
  `username` varchar(30) NOT NULL COMMENT '用户名',
  `uc_note` varchar(255) NOT NULL COMMENT '评论内容',
  `uc_reply` varchar(255) NOT NULL COMMENT '回复内容',
  `uc_link` varchar(130) NOT NULL COMMENT '评论网址',
  `uc_ip` varchar(30) NOT NULL COMMENT '评论ip',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否前台显示',
  `lang` varchar(8) NOT NULL COMMENT '多语言',
  `reply_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '回复时间',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发表评论的时间',
  PRIMARY KEY (`uc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2724 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ss_user_contact
-- ----------------------------
DROP TABLE IF EXISTS `ss_user_contact`;
CREATE TABLE `ss_user_contact` (
  `uc_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '留言id',
  `uc_nickname` varchar(30) NOT NULL COMMENT '昵称',
  `uc_contact` varchar(50) NOT NULL COMMENT '联系方式',
  `uc_content` text NOT NULL COMMENT '留言内容',
  `uc_htop` set('true') NOT NULL COMMENT '置顶',
  `uc_rtop` set('true') NOT NULL COMMENT '推荐',
  `uc_ip` char(20) NOT NULL COMMENT '留言IP',
  `uc_recont` text NOT NULL COMMENT '回复内容',
  `uc_retime` int(10) unsigned NOT NULL COMMENT '回复时间',
  `orderid` mediumint(8) unsigned NOT NULL COMMENT '排列排序',
  `posttime` int(10) unsigned NOT NULL COMMENT '更新时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '审核状态',
  PRIMARY KEY (`uc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ss_user_failed_login
-- ----------------------------
DROP TABLE IF EXISTS `ss_user_failed_login`;
CREATE TABLE `ss_user_failed_login` (
  `u_name` char(30) NOT NULL COMMENT '用户名',
  `ip` char(15) NOT NULL COMMENT '登录IP',
  `time` int(10) unsigned NOT NULL COMMENT '登录时间',
  `num` tinyint(1) NOT NULL COMMENT '失败次数',
  `isadmin` tinyint(1) NOT NULL COMMENT '是否是管理员',
  PRIMARY KEY (`u_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ss_user_favorite
-- ----------------------------
DROP TABLE IF EXISTS `ss_user_favorite`;
CREATE TABLE `ss_user_favorite` (
  `uf_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '收藏ID',
  `uf_typeid` tinyint(5) unsigned NOT NULL COMMENT '对象类型',
  `uf_model_id` int(10) unsigned NOT NULL COMMENT '收藏对象',
  `uf_data` varchar(255) NOT NULL COMMENT '附加数据，如：产品降价至多少提醒',
  `uid` int(10) NOT NULL DEFAULT '-1' COMMENT '用户id',
  `uf_link` varchar(200) NOT NULL COMMENT '当前网址',
  `uf_star` tinyint(2) unsigned NOT NULL DEFAULT '5' COMMENT '收藏的星级：1~5星',
  `uf_ip` varchar(30) NOT NULL COMMENT 'IP地址',
  `lang` varchar(8) NOT NULL COMMENT '多语言',
  `created_at` int(10) unsigned NOT NULL COMMENT '收藏时间',
  PRIMARY KEY (`uf_id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ss_user_group
-- ----------------------------
DROP TABLE IF EXISTS `ss_user_group`;
CREATE TABLE `ss_user_group` (
  `ug_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户组id',
  `ug_name` varchar(50) NOT NULL COMMENT '用户组名称',
  `orderid` int(11) unsigned NOT NULL DEFAULT '10',
  `lang` varchar(8) NOT NULL COMMENT '多语言',
  `is_default` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`ug_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ss_user_level
-- ----------------------------
DROP TABLE IF EXISTS `ss_user_level`;
CREATE TABLE `ss_user_level` (
  `level_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户组id',
  `level_name` varchar(30) NOT NULL DEFAULT '' COMMENT '用户组名称',
  `level_expval_min` int(11) unsigned NOT NULL COMMENT '用户组经验介于a',
  `level_expval_max` int(11) unsigned NOT NULL COMMENT '用户组经验介于b',
  `lang` varchar(8) NOT NULL COMMENT '多语言',
  `orderid` int(11) unsigned NOT NULL DEFAULT '10' COMMENT '排序',
  `is_default` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否默认',
  PRIMARY KEY (`level_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
