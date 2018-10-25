<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model app\models\sys\MultilangTpl */

$this->title = '编辑: ' . $model->lang_name;
?>
<div class="multilang-tpl-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>