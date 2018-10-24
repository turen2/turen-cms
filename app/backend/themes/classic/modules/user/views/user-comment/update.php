<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\components\ActiveRecord;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $model app\models\user\UserComment */

$this->title = '编辑评论: ' . StringHelper::truncate(strip_tags(($model->uc_pid == ActiveRecord::DEFAULT_NULL)?$model->uc_note:$model->uc_reply), 12, '...');//$model->uc_note;
?>
<div class="user-comment-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>