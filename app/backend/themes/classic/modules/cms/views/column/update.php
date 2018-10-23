<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model app\models\cms\Column */

$this->title = '编辑栏目';
?>
<div class="column-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>