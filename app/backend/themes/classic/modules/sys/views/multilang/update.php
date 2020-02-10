<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model backend\models\sys\Multilang */

$this->title = '编辑: ' . $model->lang_name;
?>
<div class="multilang-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>