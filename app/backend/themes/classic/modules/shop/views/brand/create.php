<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model backend\models\shop\Brand */

$this->title = '添加新品牌';
?>
<div class="brand-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>