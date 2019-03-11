<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['account/user/reset', 'token' => $user->password_reset_token]);
?>
您好 <?= $user->username ?>,请点击以下链接以完成密码更新操作，请不要泄漏此链接：<?= $resetLink ?>