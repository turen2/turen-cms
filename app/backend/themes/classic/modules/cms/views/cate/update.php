<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model backend\models\cms\Cate */

$this->title = '编辑类别';
?>
<div class="cate-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>