<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model app\models\user\FeedbackType */

$this->title = '编辑: ' .(empty($model->fkt_form_name)?'':$model->fkt_form_name).(empty($model->fkt_list_name)?'':'|'.$model->fkt_list_name);
?>
<div class="feedback-type-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>