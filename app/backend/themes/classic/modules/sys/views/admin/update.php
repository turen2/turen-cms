<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\sys\Admin */

$this->title = '编辑管理员信息';
$this->params['breadcrumbs'][] = ['label' => 'Admins', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="admin-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
