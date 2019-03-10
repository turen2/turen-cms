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
use app\assets\ValidationAsset;
use app\models\user\Group;
use yii\helpers\ArrayHelper;
use app\models\user\Level;
use app\widgets\fileupload\JQueryFileUploadWidget;
use yii\web\JsExpression;
use app\models\user\User;
use app\widgets\laydate\LaydateWidget;
use yii\helpers\Json;

/* @var $this yii\web\View */
/* @var $model app\models\user\User */
/* @var $form yii\widgets\ActiveForm */

ValidationAsset::register($this);

$rules = $messages = [];
$rules[Html::getInputName($model, 'username')] = ['required' => true];
$rules[Html::getInputName($model, 'point')] = ['digits' => true];
$rules[Html::getInputName($model, 'email')] = ['email' => true];
$rules[Html::getInputName($model, 'zipcode')] = ['isZipCode' => true];
$rules[Html::getInputName($model, 'phone')] = ['isPhone' => true];
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
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="user-form form-table">
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('username')?><?php if($model->isAttributeRequired('username')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeInput('text', $model, 'username', ['class' => 'input']) ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('avatar')?><?php if($model->isAttributeRequired('avatar')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= JQueryFileUploadWidget::widget([
                    'model' => $model,
                    'attribute' => 'avatar',
                    'options' => ['class' => 'input', 'readonly' => true],
                    'url' => ['fileupload', 'param' => 'value'],
                    'uploadName' => 'avatar',
                    'fileOptions' => [
                        'accept' => '*',//选择文件时的windows过滤器
                        'multiple' => false,//单图
                        'isImage' => true,//图片文件
                    ],//单图
                    'clientOptions' => [
                        'acceptFileTypes' => new JsExpression('/(\.|\/)(gif|jpe?g|png|ai|txt|xls|xlsx|docx|doc|pdf|zip|rar|tar)$/i'),//限制上传的后缀名
                    ],
                ]) ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('sex')?><?php if($model->isAttributeRequired('sex')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeRadioList($model, 'sex', [
			        User::STATUS_ON => '帅哥',
    			    User::STATUS_OFF => '美女',
				], ['tag' => 'span', 'separator' => '&nbsp;&nbsp;&nbsp;']);
				?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('level_id')?><?php if($model->isAttributeRequired('level_id')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeDropDownList($model, 'level_id', ArrayHelper::map(Level::find()->current()->all(), 'level_id', 'level_name'), ['class' => '']) ?>
    			<span>&nbsp;&nbsp;&nbsp;&nbsp;</span>
    			<?= $model->getAttributeLabel('ug_id')?>
    			<span>&nbsp;&nbsp;</span>
    			<?= Html::activeDropDownList($model, 'ug_id', ArrayHelper::map(Group::find()->current()->all(), 'ug_id', 'ug_name'), ['class' => '']) ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('email')?><?php if($model->isAttributeRequired('email')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeInput('text', $model, 'email', ['class' => 'input']) ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('phone')?><?php if($model->isAttributeRequired('phone')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeInput('text', $model, 'phone', ['class' => 'input']) ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('password')?><?php if($model->isAttributeRequired('password')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeInput('text', $model, 'password', ['class' => 'input']) ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('point')?><?php if($model->isAttributeRequired('point')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeInput('text', $model, 'point', ['class' => 'inputs']) ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	<tr class="nb">
    		<td class="first-column"><?= $model->getAttributeLabel('intro')?><?php if($model->isAttributeRequired('intro')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeTextarea($model, 'intro', ['class' => 'textdesc']) ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	
    	<tr class="nb">
			<td colspan="2" class="td-line"><div class="line"> </div></td>
		</tr>
    	
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('company')?><?php if($model->isAttributeRequired('company')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeInput('text', $model, 'company', ['class' => 'input']) ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('trade')?><?php if($model->isAttributeRequired('trade')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeInput('text', $model, 'trade', ['class' => 'input']) ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('license')?><?php if($model->isAttributeRequired('license')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeInput('text', $model, 'license', ['class' => 'input']) ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	<tr class="nb">
    		<td class="first-column"><?= $model->getAttributeLabel('telephone')?><?php if($model->isAttributeRequired('telephone')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeInput('text', $model, 'telephone', ['class' => 'input']) ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	
    	<tr class="nb">
			<td colspan="2" class="td-line"><div class="line"> </div></td>
		</tr>
    	
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('address_prov')?><?php if($model->isAttributeRequired('address_prov')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeInput('text', $model, 'address_prov', ['class' => 'input']) ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('address_city')?><?php if($model->isAttributeRequired('address_city')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeInput('text', $model, 'address_city', ['class' => 'input']) ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('address_country')?><?php if($model->isAttributeRequired('address_country')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeInput('text', $model, 'address_country', ['class' => 'input']) ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('address')?><?php if($model->isAttributeRequired('address')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeInput('text', $model, 'address', ['class' => 'input']) ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('zipcode')?><?php if($model->isAttributeRequired('zipcode')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeInput('text', $model, 'zipcode', ['class' => 'inputs']) ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('reg_time')?><?php if($model->isAttributeRequired('reg_time')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= LaydateWidget::widget([
    			    'model' => $model,
    			    'attribute' => 'reg_time',
    			    'value' => $model->dateTimeValue(),
    			    'options' => ['class' => 'inputms'],
    			]) ?>
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