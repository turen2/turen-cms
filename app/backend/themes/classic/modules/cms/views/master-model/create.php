<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\models\cms\MasterModel */

$this->title = '添加新'.$diyModel->dm_title;
?>
<div class="master-model-create">
    <?= $this->render('_form', [
        'model' => $model,
        'diyModel' => $diyModel,
    ]) ?>
</div>