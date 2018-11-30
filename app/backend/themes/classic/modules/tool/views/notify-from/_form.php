<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\widgets\Tips;
use app\assets\ValidationAsset;
use yii\helpers\Json;

/* @var $this yii\web\View */
/* @var $model app\models\tool\NotifyFrom */
/* @var $form yii\widgets\ActiveForm */

ValidationAsset::register($this);

$rules = $messages = [];
$rules[Html::getInputName($model, 'fr_title')] = ['required' => true];

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
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="notify-from-form form-table">
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('fr_title')?><?php if($model->isAttributeRequired('fr_title')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeInput('text', $model, 'fr_title', ['class' => 'input']) ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('fr_comment')?><?php if($model->isAttributeRequired('fr_comment')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeTextarea($model, 'fr_comment', ['class' => 'textdesc']) ?>
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