<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $user app\modules\admin\models\User */

$resetLink = Url::to(['merchant/common/reset-password','token'=>$password_reset_token], true);
?>
Hello <?= $name ?>,

Follow the link below to reset your password:

<?= $resetLink ?>
