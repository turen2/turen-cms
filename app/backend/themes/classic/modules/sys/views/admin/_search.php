<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="toolbar-tab">
	<?php $form = ActiveForm::begin([
	    'action' => ['index'],
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