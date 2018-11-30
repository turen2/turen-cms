<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\tool\NotifyFrom;

/* @var $this yii\web\View */
/* @var $model app\models\tool\NotifyUserSearch */
/* @var $form yii\widgets\ActiveForm */

$isAll = true;
foreach ($model->attributes as $key => $value) {
    if(!is_null($value)) {
        $isAll = false;
    }
}
?>

<div class="notify-user-search toolbar-tab">
	<div class="fl">
    	<a class="op-btn" href="">导入</a>
    	<a class="op-btn" href="">导出</a>
	</div>
	
	<?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'id' => 'searchform',
    ]); ?>
    	
    	<span><?= Html::activeCheckbox($model, 'nu_is_sms_white', ['label' => '可发短信', 'uncheck' => null]) ?></span>
    	<span><?= Html::activeCheckbox($model, 'nu_is_notify_white', ['label' => '可发站内信', 'uncheck' => null]) ?></span>
    	<span><?= Html::activeCheckbox($model, 'nu_is_email_white', ['label' => '可发邮件', 'uncheck' => null]) ?></span>
    	<span><?= Html::activeInput('text', $model, 'nu_last_order_time', ['class' => 'input w80', 'placeholder' => '下单时间']) ?></span>
    	<span><?= Html::activeInput('text', $model, 'nu_last_send_time', ['class' => 'input w80', 'placeholder' => '发送时间']) ?></span>
    	<span><?= Html::activeInput('text', $model, 'nu_order_total', ['class' => 'input w80', 'placeholder' => '最低订单额']) ?></span>
    	<span><?= Html::activeDropDownList($model, 'nu_star', [null => '选择星级', '1' => '1星', '2' => '2星', '3' => '3星', '4' => '4星', '5' => '5星']) ?></span>
    	<span><?= Html::activeDropDownList($model, 'nu_fr_id', ArrayHelper::merge([null => '选择发送组'], ArrayHelper::map(NotifyFrom::find()->asArray()->all(), 'fr_id', 'fr_title'))) ?></span>
    	<span><?= Html::activeInput('text', $model, 'keyword', ['class' => 'input', 'placeholder' => '用户名/手机/邮箱/地址']) ?></span>
    	<a class="op-btn" href="javascript:;" onclick="searchform.submit();">查询</a>
	<?php ActiveForm::end(); ?>
</div>