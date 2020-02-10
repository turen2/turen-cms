<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\components\ActiveRecord;

$isAll = true;
foreach ($model->attributes as $key => $value) {
    if(in_array($key, ['id', 'status', 'keyword']) && !is_null($value) && (!empty($value) || $value === '0')) {
        $isAll = false;
    }
}

$addRoutes = [
    Html::getInputName($model, 'keyword') => $model->keyword
];
?>

<div class="toolbar-tab">
    <ul class="fl">
        <li class="<?= $isAll?'on':''?>"><?= Html::a('全部', ['index']) ?></li>
        <li class="line">-</li>
        <li class="<?= (!is_null($model->status) && $model->status == ActiveRecord::STATUS_ON)?'on':''?>"><?= Html::a('已审', ArrayHelper::merge(['index', Html::getInputName($model, 'status') => ActiveRecord::STATUS_ON], $addRoutes)) ?></li>
        <li class="line">-</li>
        <li class="<?= (!is_null($model->status) && $model->status == ActiveRecord::STATUS_OFF)?'on':''?>"><?= Html::a('未审', ArrayHelper::merge(['index', Html::getInputName($model, 'status') => ActiveRecord::STATUS_OFF], $addRoutes)) ?></li>
    </ul>

	<?php $form = ActiveForm::begin([
        'action' => ['index', Html::getInputName($model, 'status') => $model->status],
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