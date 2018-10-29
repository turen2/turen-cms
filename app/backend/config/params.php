<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

// 原理：有些参数是跟随系统本身的，这类配置项不需要在系统后台进行配置，直接配置在此文件中即可、
// 配置在系统后台可管理的所有参数，在配置文件中必须要有一一对应的值，而且数据库配置优先级最高。
return [
    // 不列入config后台管理的配置项【更新不够频次】
    'config.adminEmail' => 'xiayouqiao2008@163.com',
    'config.supportEmail' => 'xiayouqiao2008@163.com',
    'config.userPasswordResetTokenExpire' => '3600', // 找回密码的token值有效期为1小时
    
    // 创始人列表
    'config.founderList' => [10],
    
    // 后台默认分页
    'config.defaultPageSize' => 15,
    
    // 自动记录访问路由，以下设置是忽略的路由
    'config.autoReturnRoute' => [
        '*/ueditor',
        'site/home/menu',//菜单不记
        'site/home/index',//框架不记
        'site/admin/*',//外部登录注册更新不记
        
        'debug/*',
        'gii/*',
    ],
    
    // 未登录无条件访问路由
    'config.notLoginNotaccessRoute' => [
        'site/admin/*', // 登录注册改密码
        'site/other/*', // 统一错误处理/无权界面// 维护页面
        
        'debug/*',
        'gii/*'
    ],
    
    // 已登录无条件访问路由
    'config.loginNotAccessRoute' => [
        'site/home/*', // 登录注册改密码
    ],
    
    // 默认点击量
    'config.hits' => 100,
    'config.orderid' => 10,
    
    // 多语言相关配置//国际标准码(所有主题必须支持以下语言)
    'config.languages' => [
        'zh-CN' => '简体中文',
        'zh-TW' => '繁体中文',
        'en-US' => 'English'
    ],
    
    //登录安全问题
    'config.safeQuestion' => [
        null => '无安全提问',
        2 => '手机号码后4位',
        3 => '身份证号码后4位',
        4 => '父亲出生的城市',
        5 => '你其中一位老师的名字',
        6 => '你个人计算机的型号',
        7 => '你最喜欢的餐馆名称',
        8 => '驾驶执照最后四位数字'
    ],
    
    //是否开启问题验证
    'config.loginSafeProblem' => false,
    
    //此配置与整个系统有关
    'config.openCate' => true,//是否开启类别管理
];
