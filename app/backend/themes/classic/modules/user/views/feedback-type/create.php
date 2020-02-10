<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model backend\models\user\FeedbackType */

$this->title = '添加反馈类型';
?>
<div class="feedback-type-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>