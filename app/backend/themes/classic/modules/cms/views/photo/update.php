<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
/* @var $this yii\web\View */
/* @var $model app\models\cms\Photo */

$this->title = '编辑图片信息';
?>
<div class="photo-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>