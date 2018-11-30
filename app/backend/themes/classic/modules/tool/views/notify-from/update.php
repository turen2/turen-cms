<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model app\models\tool\NotifyFrom */

$this->title = '编辑新来源: ' . $model->fr_id;
?>
<div class="notify-from-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>