<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model backend\models\cms\DiyModel */

$this->title = '编辑模型: ' . $model->dm_title;
?>
<div class="diy-model-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>