<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Html;

$this->title = '嘉乐邦预约通知';
?>
<div class="password-reset">
    <p>您好 <?= Html::encode($params['username']) ?>,</p>
    <p>请点击以下链接以完成密码更新操作，请不要泄漏此链接：</p>
    <p><?= Html::a(Html::encode($params['resetLink']), $params['resetLink']) ?></p>
</div>