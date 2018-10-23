<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\models\user\UserComment */

$this->title = '添加新评论';
?>
<div class="user-comment-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>