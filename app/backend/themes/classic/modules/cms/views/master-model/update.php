<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model app\models\cms\MasterModel */

$this->title = '编辑: ' . $diyModel->dm_title;
?>
<div class="master-model-update">
    <?= $this->render('_form', [
        'model' => $model,
        'diyModel' => $diyModel,
    ]) ?>
</div>