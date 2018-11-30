<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\tool\NotifyGroupSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="notify-group-search toolbar-tab">
	<ul class="fl">
        <li class="<?= empty($model->type)?'on':''?>"><?= Html::a('全部', ['index']) ?></li>
	</ul>
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'id' => 'searchform',
        'options' => ['class' => 'fr'],
    ]); ?>
    	<span><?= Html::activeDropDownList($model, 'type_1', [
    	    null => '--完成/未完--',
    	    '0' => '发送完成',
    	    '1' => '未发送完成',
    	]) ?></span>
    	<span><?= Html::activeDropDownList($model, 'type_2', [
    	    null => '--发送/暂停--',
    	    '1' => '发送中',
    	    '0' => '暂停中',
    	]) ?></span>
    	<span><?= Html::activeDropDownList($model, 'type_3', [
    	    null => '--定时发送--',
    	    '0' => '时间未到',
    	    '1' => '时间已到',
    	    '2' => '没有定时',
    	]) ?></span>
		<span class="keyword">
			<?= Html::activeInput('text', $model, 'keyword', ['class' => 'input', 'placeholder' => '关键词']) ?>
		</span>
		<a class="op-btn" href="javascript:;" onclick="searchform.submit();">查询</a>
	<?php ActiveForm::end(); ?>
</div>
