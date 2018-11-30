<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model app\models\tool\NotifyGroup */

$this->title = '编辑队列: ' . $model->ng_title;
?>
<div class="notify-group-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>