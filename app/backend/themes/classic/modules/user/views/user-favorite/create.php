<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\models\user\UserFavorite */

$this->title = '添加';
?>
<div class="user-favorite-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>