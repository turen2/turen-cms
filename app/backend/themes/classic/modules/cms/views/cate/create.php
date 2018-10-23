<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
/* @var $this yii\web\View */
/* @var $model app\models\cms\Cate */

$this->title = '添加类别';
?>
<div class="cate-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>