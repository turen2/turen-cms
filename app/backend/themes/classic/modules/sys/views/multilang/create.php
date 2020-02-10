<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model backend\models\sys\Multilang */

$this->title = '添加新语言';
?>
<div class="multilang-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>