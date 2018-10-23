<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model app\models\shop\ProductCate */

$this->title = '编辑: ' . $model->cname;
?>
<div class="cate-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>