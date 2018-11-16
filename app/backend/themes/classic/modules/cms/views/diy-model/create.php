<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\models\cms\DiyModel */

$this->title = '添加新模型';
?>
<div class="diy-model-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>