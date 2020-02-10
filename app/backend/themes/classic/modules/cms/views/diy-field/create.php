<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model backend\models\cms\DiyField */

$this->title = '添加新字段';
?>
<div class="diy-field-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>