<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\models\shop\Attribute */

$this->title = '添加新属性';
?>
<div class="attribute-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>