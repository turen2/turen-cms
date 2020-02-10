<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model backend\models\shop\Product */

$this->title = '编辑: ' . $model->title;
?>
<div class="product-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>