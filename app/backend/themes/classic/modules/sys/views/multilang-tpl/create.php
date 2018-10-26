<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\models\sys\MultilangTpl */

$this->title = '添加新语言';
?>
<div class="multilang-tpl-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>