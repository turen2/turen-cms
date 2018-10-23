<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model app\models\shop\Attribute */

$this->title = '编辑: ' . $model->attrname;
?>
<div class="attribute-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>