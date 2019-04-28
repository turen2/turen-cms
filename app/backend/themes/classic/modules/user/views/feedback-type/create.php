<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\models\user\FeedbackType */

$this->title = '添加反馈类型';
?>
<div class="feedback-type-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>