<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model app\models\user\UserFavorite */

$this->title = '编辑: ' . $model->ufid;
?>
<div class="user-favorite-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>