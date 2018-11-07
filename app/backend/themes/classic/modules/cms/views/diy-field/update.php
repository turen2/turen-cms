<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model app\models\cms\DiyField */

$this->title = '编辑: ' . $model->fd_title;
?>
<div class="diy-field-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>