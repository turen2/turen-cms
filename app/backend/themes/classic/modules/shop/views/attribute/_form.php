<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Json;
use common\helpers\BuildHelper;
use backend\widgets\Tips;
use backend\assets\ValidationAsset;
use backend\models\shop\Attribute;
use backend\models\shop\ProductCate;

/* @var $this yii\web\View */
/* @var $model backend\models\shop\Attribute */
/* @var $form yii\widgets\ActiveForm */

ValidationAsset::register($this);

$rules = $messages = [];
$rules[Html::getInputName($model, 'attrname')] = ['required' => true];
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
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="attribute-form form-table">
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('attrname')?><?php if($model->isAttributeRequired('attrname')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeInput('text', $model, 'attrname', ['class' => 'input']) ?>
    			<span class="cnote">带<span class="maroon">*</span>号表示为必填项</span>
    		</td>
    	</tr>
    	<tr class="nb">
    		<td class="first-column"><?= $model->getAttributeLabel('pcateid')?><?php if($model->isAttributeRequired('pcateid')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeDropDownList($model, 'pcateid', BuildHelper::buildSelectorData(ProductCate::find()->current()->orderBy(['orderid' => SORT_DESC])->all(), ProductCate::class, 'id', 'parentid', 'cname', false), ['encode' => false, 'class' => '']) ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	<tr class="nb">
			<td colspan="2" class="td-line"><div class="line"> </div></td>
		</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('type')?><?php if($model->isAttributeRequired('type')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeDropDownList($model, 'type', Attribute::TypeList()) ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	<tr class="nb">
    		<td class="first-column"><?= $model->getAttributeLabel('typetext')?><?php if($model->isAttributeRequired('typetext')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeTextarea($model, 'typetext', ['class' => 'textarea']) ?>
    			<span class="cnote">注意：如果是有多个值请用 | 分隔。</span>
    		</td>
    	</tr>
    	<tr class="nb">
			<td colspan="2" class="td-line"><div class="line"> </div></td>
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
				    Attribute::STATUS_ON => '显示',
				    Attribute::STATUS_OFF => '隐藏',
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