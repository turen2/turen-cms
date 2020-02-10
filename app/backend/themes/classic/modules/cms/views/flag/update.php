<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model backend\models\cms\Flag */

$this->title = '编辑: ' . $model->flagname;
?>
<div class="flag-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>