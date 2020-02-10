<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use backend\components\ActiveRecord;

/* @var $this yii\web\View */
/* @var $model backend\models\cms\DiyFieldSearch */
/* @var $form yii\widgets\ActiveForm */

$isAll = true;
foreach ($model->attributes as $key => $value) {
    if(in_array($key, ['id', 'status', 'keyword']) && !is_null($value) && (!empty($value) || $value === '0')) {
        $isAll = false;
    }
}

$addRoutes = [
    Html::getInputName($model, 'fd_column_type') => $model->fd_column_type,
    Html::getInputName($model, 'keyword') => $model->keyword
];
?>

<div class="diy-field-search toolbar-tab">
	<ul class="fl">
        <li class="<?= $isAll?'on':''?>"><?= Html::a('全部', ['index']) ?></li>
        <li class="line">-</li>
        <li class="<?= (!is_null($model->status) && $model->status == ActiveRecord::STATUS_ON)?'on':''?>"><?= Html::a('启用', ArrayHelper::merge(['index', Html::getInputName($model, 'status') => ActiveRecord::STATUS_ON], $addRoutes)) ?></li>
        <li class="line">-</li>
        <li class="<?= (!is_null($model->status) && $model->status == ActiveRecord::STATUS_OFF)?'on':''?>"><?= Html::a('禁用', ArrayHelper::merge(['index', Html::getInputName($model, 'status') => ActiveRecord::STATUS_OFF], $addRoutes)) ?></li>
	</ul>
	
    <?php $form = ActiveForm::begin([
        'action' => ArrayHelper::merge(['index', Html::getInputName($model, 'status') => $model->status], $addRoutes),
        'method' => 'get',
        'id' => 'searchform',
        'options' => ['class' => 'fr'],
    ]); ?>
		<span class="keyword">
			<?= Html::activeInput('text', $model, 'keyword', ['class' => 'input', 'placeholder' => '关键词']) ?>
		</span>
		<a class="op-btn" href="javascript:;" onclick="searchform.submit();">查询</a>
	<?php ActiveForm::end(); ?>
</div>