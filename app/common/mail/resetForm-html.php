<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Html;

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['account/user/reset', 'token' => $user->password_reset_token]);
?>
<div class="password-reset">
    <p>您好 <?= Html::encode($user->username) ?>,</p>
    <p>请点击以下链接以完成密码更新操作，请不要泄漏此链接：</p>
    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>