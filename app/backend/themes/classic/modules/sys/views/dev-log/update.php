<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model app\models\sys\Devlog */

$this->title = '编辑开发日志';
?>
<div class="devlog-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>