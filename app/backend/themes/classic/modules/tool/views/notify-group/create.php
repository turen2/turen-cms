<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\models\tool\NotifyGroup */

$this->title = '添加新队列';
?>
<div class="notify-group-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>