<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
/* @var $this yii\web\View */
/* @var $model app\models\cms\File */

$this->title = '编辑下载信息';
?>
<div class="file-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>