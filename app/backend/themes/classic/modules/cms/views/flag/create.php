<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\models\cms\Flag */

$this->title = '添加新标记';
?>
<div class="flag-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>