<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
/* @var $this yii\web\View */
/* @var $model app\models\cms\Info */

$this->title = '编辑单页信息';
?>
<div class="info-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>