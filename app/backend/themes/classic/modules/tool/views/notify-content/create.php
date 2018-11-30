<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\models\tool\NotifyContent */

$this->title = '添加新通知内容';
?>
<div class="notify-content-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>