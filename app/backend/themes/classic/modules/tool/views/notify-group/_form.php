<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\widgets\Tips;
use app\components\ActiveRecord;
use app\assets\ValidationAsset;
use yii\helpers\Json;
use app\models\tool\NotifyGroup;
use yii\helpers\ArrayHelper;
use app\models\tool\NotifyContent;
use app\widgets\datetimepicker\DatetimePickerWidget;

/* @var $this yii\web\View */
/* @var $model app\models\tool\NotifyGroup */
/* @var $form yii\widgets\ActiveForm */

ValidationAsset::register($this);

$rules = $messages = [];

$rules[Html::getInputName($model, 'ng_title')] = ['required' => true];
$rules[Html::getInputName($model, 'ng_nc_id')] = ['required' => true];

$rules = Json::encode($rules);
$messages = Json::encode($messages);
$js = <<<EOF
var validator = $("#submitform").validate({
	rules: {$rules},
	messages: {$messages},
    errorElement: "p",
	errorPlacement: function(error, element) {
		error.appendTo(element.parent());
	}
});
EOF;
$this->registerJs($js);
?>

<?= Tips::widget([
    'type' => 'error',
    'model' => $model,
    'closeBtn' => false,
]) ?>

<?php $form = ActiveForm::begin([
    'enableClientScript' => false,
    'options' => ['id' => 'submitform'],
]); ?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="notify-group-form form-table">
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('ng_title')?><?php if($model->isAttributeRequired('ng_title')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeInput('text', $model, 'ng_title', ['class' => 'input']) ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('ng_comment')?><?php if($model->isAttributeRequired('ng_comment')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeTextarea($model, 'ng_comment', ['class' => 'textdesc']) ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('ng_nc_id')?><?php if($model->isAttributeRequired('ng_nc_id')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeDropDownList($model, 'ng_nc_id', ArrayHelper::merge([null => '请选择内容'], ArrayHelper::map(NotifyContent::find()->active('nc_status')->all(), 'nc_id', 'nc_title'))); ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('ng_clock_time')?><?php if($model->isAttributeRequired('ng_clock_time')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= DatetimePickerWidget::widget([
            	    'model' => $model,
            	    'attribute' => 'ng_clock_time',
            	    'clientOptions' => [
            	        'format' => 'Y-m-d H:i:s',
            	        'timepicker' => true,
            	        'value' => $model->dateTimeValue(),
            	    ],
            	    'options' => [
            	        'autocomplete' => 'off',
            	        'class' => 'inputms',
            	        'placeholder' => '发送结束日期',
                    ],
            	]) ?>
    			<span class="cnote">如果定时发送不为空，则队列由状态和时间共同决定是否执行。</span>
    		</td>
    	</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('ng_status')?><?php if($model->isAttributeRequired('ng_status')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeRadioList($model, 'ng_status', [
			        NotifyGroup::STATUS_ON => '开始',
    			    NotifyGroup::STATUS_OFF => '暂停',
				], ['tag' => 'span', 'separator' => '&nbsp;&nbsp;&nbsp;']);
				?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	<tr class="nb">
    		<td></td>
    		<td>
    			<div class="form-sub-btn">
            		<?= Html::submitButton('提交', ['class' => 'submit', 'id' => 'submit-btn']) ?>
            		<?= Html::input('button', 'backName', '返回', ['class' => 'back', 'onclick' => 'location.href="'.Url::to(['index']).'"']) ?>
            	</div>
    		</td>
    	</tr>
	</table>
<?php ActiveForm::end(); ?>