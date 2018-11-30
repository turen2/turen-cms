<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\components\ActiveRecord;

/* @var $this yii\web\View */
/* @var $model app\models\tool\NotifyContentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="notify-content-search toolbar-tab">
	<ul class="fl">
		<li class="<?= (empty($model->keyword) && is_null($model->nc_status))?'on':''?>"><?= Html::a('全部', ['index']) ?></li>
	</ul>
	
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