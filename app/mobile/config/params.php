<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

$params = [];
//短信签名、模板配置
//1.预约通知
$params['call_price_notify'] = [
    'signName' => '亚桥机械租赁',
    'templateCode' => 'SMS_178451425',
];
//2.忘记密码验证码
$params['forget_code'] = [
    'signName' => '亚桥机械租赁',
    'templateCode' => 'SMS_178456491',
];
//3.用户注册验证码
$params['signup_code'] = [
    'signName' => '亚桥机械租赁',
    'templateCode' => 'SMS_178575120',
];
//4.快捷登录验证码
$params['quick_code'] = [
    'signName' => '亚桥机械租赁',
    'templateCode' => 'SMS_178575122',
];
//5.第三方绑定验证码
$params['bind_code'] = [
    'signName' => '亚桥机械租赁',
    'templateCode' => 'SMS_178451427',
];
//6.更新安全配置
$params['update_code'] = [
    'signName' => '亚桥机械租赁',
    'templateCode' => 'SMS_178575118',
];
//7.预约成功短信
$params['call_success_tips'] = [
    'signName' => '亚桥机械租赁',
    'templateCode' => 'SMS_178466497',
];

return $params;
