<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use yii\helpers\Url;
use common\models\user\User;

$route = (isset($route) && !empty($route))?$route:Yii::$app->controller->getRoute();

$links = [
    [
        'route' => 'account/center/info',
        'activeRoute' => 'account/center',
        'label' => '<i class="iconfont jia-aboutus"></i> 基本资料',
        'isPost' => false,
    ],
    [
        'route' => 'account/order/list',
        'activeRoute' => 'account/order',
        'label' => '<i class="iconfont jia-i-order"></i> 服务订单',
        'isPost' => false,
    ],
    [
        'route' => 'account/ticket/list',
        'activeRoute' => 'account/ticket',
        'label' => '<i class="iconfont jia-File"></i> 工单管理',
        'isPost' => false,
    ],
    [
        'route' => 'account/msg/list',
        'activeRoute' => 'account/msg',
        'label' => '<i class="iconfont jia-task"></i> 消息中心',
        'isPost' => false,
    ],
    [
        'route' => 'account/company/info',
        'activeRoute' => 'account/company',
        'label' => '<i class="iconfont jia-identityauthentication"></i> 企业资质',
        'isPost' => false,
    ],
    [
        'route' => 'account/safe/info',
        'activeRoute' => 'account/safe',
        'label' => '<i class="iconfont jia-windcontrol"></i> 账户安全',
        'isPost' => false,
    ],
    [
        'route' => 'account/third/list',
        'activeRoute' => 'account/third',
        'label' => '<i class="iconfont jia-disanfangdenglu"></i> 第三方登录',
        'isPost' => false,
    ],
    [
        'route' => 'account/'.(Yii::$app->params['config_login_mode'] == User::USER_PHONE_MODE?'passport':'user').'/logout',
        'activeRoute' => 'account/'.(Yii::$app->params['config_login_mode'] == User::USER_PHONE_MODE?'passport':'user'),
        'label' => '<i class="iconfont jia-ico-exit"></i> 退出',
        'isPost' => true,
    ],
];
?>
<div class="user-side card">
    <div class="menu-head">
        <h3>客户中心</h3>
    </div>
    <div class="menu-list">
        <ul>
            <?php foreach ($links as $link) { ?>
                <li><a href="<?= Url::to(['/'.$link['route']]) ?>" class="<?=  (strpos($route, $link['activeRoute']) === 0)?'on':'' ?>" data-method="<?= $link['isPost']?'post':'' ?>"><?= $link['label'] ?></a></li>
            <?php } ?>
        </ul>
    </div>
</div>
