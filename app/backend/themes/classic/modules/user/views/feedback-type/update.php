<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model app\models\user\FeedbackType */

$this->title = '编辑 Feedback Type: ' . $model->fkt_id;
?>
<div class="feedback-type-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>