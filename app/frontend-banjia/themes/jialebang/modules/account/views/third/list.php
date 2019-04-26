<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

$this->title = '第三方登录';
$this->params['breadcrumbs'][] = $this->title;

use yii\helpers\Html;
use yii\helpers\Url;
use yii\authclient\widgets\AuthChoice;

$userModel = Yii::$app->getUser()->getIdentity();
?>

<div class="user-center">
    <div class="container clearfix">
        <?= $this->render('../_account_sidebox') ?>
        <div class="user-content card info">
            <div class="user-content-head">
                <div class="title"><?= $this->title ?></div>
            </div>
            <div class="user-content-body" style="margin-bottom: 60px;padding-top: 16px;">
                <?= $this->render('../_alert') ?>
                <?php $authAuthChoice = AuthChoice::begin([
                    'baseAuthUrl' => ['/account/passport/auth', 'action' => 'bind'],//绑定类型
                    'popupMode' => true,
                    'options' => ['class' => 'third-clients'],
                ]); ?>
                <?php foreach ($authAuthChoice->getClients() as $client): ?>
                    <?php $clientId = $client->getId() ?>
                    <?php $field = $userModel->{$clientId.'_id'}; ?>
                    <div class="setting">
                        <span class="icon"><i class="iconfont jia-<?= $clientId ?>"></i></span>
                        <span class="title"><?= $client->getTitle() ?></span>
                        <span class="action">
                            <?= empty($field)?'<span class="status">未绑定</span>':'<span class="status status-done">已绑定</span>' ?>
                            <?php
                            $htmlOptions = [];
                            $htmlOptions['popupWidth'] = 627;
                            $htmlOptions['popupHeight'] = 400;
                            $htmlOptions['class'] = 'default-btn br5 '.$clientId;
                            $link = $authAuthChoice->clientLink($client, '绑定', $htmlOptions);
                            ?>
                            <?= empty($field)?$link:'<a class="default-btn br5" href="'.Url::to(['/account/third/unbind', 'authclientid' => $clientId]).'">取消绑定</a>' ?>
                        </span>
                    </div>
                <?php endforeach; ?>
                <?php AuthChoice::end(); ?>
            </div>
        </div>
    </div>
</div>