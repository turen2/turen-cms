<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\models\user\Feedback */

$this->title = '添加新反馈';
?>
<div class="feedback-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>