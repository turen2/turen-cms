<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model app\models\site\HelpCate */

$this->title = '编辑帮助分类';
?>
<div class="help-cate-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>