<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\models\shop\Product */

$this->title = '添加新产品';
?>
<div class="product-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>