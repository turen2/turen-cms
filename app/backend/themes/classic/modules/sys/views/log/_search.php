<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

$isAll = true;
foreach ($model->attributes as $key => $value) {
    if(in_array($key, ['id', 'method', 'keyword']) && !is_null($value) && (!empty($value))) {
        $isAll = false;
    }
}

$addRoutes = [
    Html::getInputName($model, 'keyword') => $model->keyword
];
?>

<div class="log-search toolbar-tab">
    <ul class="fl">
        <li class="<?= $isAll?'on':''?>"><?= Html::a('全部', ['index']) ?></li>
        <li class="line">-</li>
        <li class="<?= (!is_null($model->method) && $model->method == 'POST')?'on':''?>"><?= Html::a('POST', ArrayHelper::merge(['index', Html::getInputName($model, 'method') => 'POST'], $addRoutes)) ?></li>
        <li class="line">-</li>
        <li class="<?= (!is_null($model->method) && $model->method == 'GET')?'on':''?>"><?= Html::a('GET', ArrayHelper::merge(['index', Html::getInputName($model, 'method') => 'GET'], $addRoutes)) ?></li>
    </ul>

    <?php $form = ActiveForm::begin([
        'action' => ['index', Html::getInputName($model, 'method') => $model->method],
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