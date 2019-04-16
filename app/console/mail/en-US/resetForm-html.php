<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Html;
?>
<div class="password-reset">
    <p>Hello <?= Html::encode($params['username']) ?>,</p>
    <p>Please click the following link to complete the password update operation, please do not leak this link:</p>
    <p><?= Html::a(Html::encode($params['resetLink']), $params['resetLink']) ?></p>
</div>