<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model backend\models\shop\Brand */

$this->title = '编辑: ' . $model->bname;
?>
<div class="brand-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>