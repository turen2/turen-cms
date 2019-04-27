DROP TABLE IF EXISTS `ss_user_feedback_type`;
CREATE TABLE `ss_user_feedback_type` (
  `fkt_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fkt_form_name` varchar(50) NOT NULL DEFAULT '' COMMENT '表单显示名',
  `fkt_form_show` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否显示在提交表单',
  `fkt_list_name` varchar(50) NOT NULL DEFAULT '' COMMENT '展示列表标题',
  `fkt_list_show` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否展示在展示列表',
  `lang` varchar(8) NOT NULL DEFAULT '' COMMENT '多语言',
  `orderid` int(10) unsigned NOT NULL DEFAULT '10' COMMENT '排序',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '启用状态',
  `is_default` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为默认组',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`fkt_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ss_user_feedback`;
CREATE TABLE `ss_user_feedback` (
  `fk_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '留言id',
  `fk_user_id` int(11) unsigned DEFAULT NULL COMMENT '关联用户id',
  `fk_nickname` varchar(30) NOT NULL DEFAULT '' COMMENT '用户昵称',
  `fk_contact` varchar(50) NOT NULL DEFAULT '' COMMENT '联系方式',
  `fk_content` text COMMENT '留言内容',
  `fk_show` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否置顶在前台展示',
  `fk_type_id` tinyint(6) unsigned NOT NULL,
  `fk_ip` varchar(50) NOT NULL COMMENT '留言IP',
  `fk_review` text NOT NULL COMMENT '回复内容',
  `fk_retime` int(10) unsigned NOT NULL COMMENT '回复时间',
  `fk_sms` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否自动给客户发短信',
  `fk_email` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否自动给客户发邮件',
  `lang` varchar(8) NOT NULL DEFAULT '' COMMENT '多语言',
  `orderid` int(11) unsigned NOT NULL DEFAULT '10' COMMENT '排列排序',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`fk_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='联系我们';