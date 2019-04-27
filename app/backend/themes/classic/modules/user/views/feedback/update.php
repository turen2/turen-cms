<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model app\models\user\Feedback */

$this->title = '编辑 Feedback: ' . $model->fk_id;
?>
<div class="feedback-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>