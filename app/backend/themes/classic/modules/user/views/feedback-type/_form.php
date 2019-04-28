<?php

use yii\helpers\Json;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\widgets\Tips;
use app\components\ActiveRecord;
use app\assets\ValidationAsset;
use app\models\user\FeedbackType;

/* @var $this yii\web\View */
/* @var $model app\models\user\FeedbackType */
/* @var $form yii\widgets\ActiveForm */

ValidationAsset::register($this);

$rules = $messages = [];
$rules[Html::getInputName($model, 'fkt_form_name')] = ['required' => true];
$rules[Html::getInputName($model, 'fkt_list_name')] = ['required' => true];

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
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="feedback-type-form form-table">
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('fkt_form_name')?><?php if($model->isAttributeRequired('fkt_form_name')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeInput('text', $model, 'fkt_form_name', ['class' => 'input']) ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
        <tr>
            <td class="first-column"><?= $model->getAttributeLabel('fkt_form_show')?><?php if($model->isAttributeRequired('fkt_form_show')) { ?><span class="maroon">*</span><?php } ?></td>
            <td class="second-column">
                <?= Html::activeRadioList($model, 'fkt_form_show', [
                    FeedbackType::SHOW_YES => '启用',
                    FeedbackType::SHOW_NO => '关闭',
                ], ['tag' => 'span', 'separator' => '&nbsp;&nbsp;&nbsp;']);
                ?>
                <span class="cnote"></span>
            </td>
        </tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('fkt_list_name')?><?php if($model->isAttributeRequired('fkt_list_name')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeInput('text', $model, 'fkt_list_name', ['class' => 'input']) ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
        <tr>
            <td class="first-column"><?= $model->getAttributeLabel('fkt_list_show')?><?php if($model->isAttributeRequired('fkt_list_show')) { ?><span class="maroon">*</span><?php } ?></td>
            <td class="second-column">
                <?= Html::activeRadioList($model, 'fkt_list_show', [
                    FeedbackType::SHOW_YES => '启用',
                    FeedbackType::SHOW_NO => '关闭',
                ], ['tag' => 'span', 'separator' => '&nbsp;&nbsp;&nbsp;']);
                ?>
                <span class="cnote"></span>
            </td>
        </tr>
        <tr>
            <td class="first-column"><?= $model->getAttributeLabel('orderid')?><?php if($model->isAttributeRequired('orderid')) { ?><span class="maroon">*</span><?php } ?></td>
            <td class="second-column">
                <?= Html::activeInput('text', $model, 'orderid', ['class' => 'inputs']) ?>
                <span class="cnote"></span>
            </td>
        </tr>
        <tr>
            <td class="first-column"><?= $model->getAttributeLabel('status')?><?php if($model->isAttributeRequired('status')) { ?><span class="maroon">*</span><?php } ?></td>
            <td class="second-column">
                <?= Html::activeRadioList($model, 'status', [
                    FeedbackType::STATUS_ON => '显示',
                    FeedbackType::STATUS_OFF => '隐藏',
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