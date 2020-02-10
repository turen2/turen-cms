<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $user backend\modules\admin\models\User */

$resetLink = Url::to(['merchant/common/reset-password','token'=>$password_reset_token], true);
?>
Hello <?= $name ?>,

Follow the link below to reset your password:

<?= $resetLink ?>
