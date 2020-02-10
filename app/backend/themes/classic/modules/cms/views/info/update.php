<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
/* @var $this yii\web\View */
/* @var $model backend\models\cms\Info */

$this->title = '编辑单页信息';
?>
<div class="info-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>