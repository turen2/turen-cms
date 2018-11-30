<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\models\tool\NotifyFrom */

$this->title = '添加新来源';
?>
<div class="notify-from-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>