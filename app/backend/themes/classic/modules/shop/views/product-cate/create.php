<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model backend\models\shop\ProductCate */

$this->title = '添加新产品分类';
?>
<div class="cate-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>