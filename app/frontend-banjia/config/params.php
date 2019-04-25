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
    'signName' => '嘉乐邦通知',
    'templateCode' => 'SMS_163845186',
];
//2.忘记密码验证码
$params['forget_code'] = [
    'signName' => '嘉乐邦100',
    'templateCode' => 'SMS_163720487',
];
//3.用户注册验证码
$params['signup_code'] = [
    'signName' => '嘉乐邦100',
    'templateCode' => 'SMS_163725422',
];
//4.快捷登录验证码
$params['quick_code'] = [
    'signName' => '嘉乐邦100',
    'templateCode' => 'SMS_163720482',
];
//5.第三方绑定验证码
$params['bind_code'] = [
    'signName' => '嘉乐邦100',
    'templateCode' => 'SMS_163845334',
];
//6.更新安全配置
$params['update_code'] = [
    'signName' => '嘉乐邦100',
    'templateCode' => 'SMS_164266521',
];

return $params;
