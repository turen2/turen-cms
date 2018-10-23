<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model app\models\user\UserComment */

$this->title = '编辑评论: ' . $model->uc_id;
?>
<div class="user-comment-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>