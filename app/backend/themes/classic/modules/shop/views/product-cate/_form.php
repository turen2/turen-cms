<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\widgets\Tips;
use app\assets\ValidationAsset;
use app\widgets\fileupload\JQueryFileUploadWidget;
use yii\web\JsExpression;
use app\models\shop\ProductCate;
use common\helpers\BuildHelper;

/* @var $this yii\web\View */
/* @var $model app\models\shop\ProductCate */
/* @var $form yii\widgets\ActiveForm */

ValidationAsset::register($this);

$this->registerJs('
var validator = $("#createform").validate({
	rules: {
		"'.Html::getInputName($model, 'cname').'": {
			required: true,
		}
	},
    errorElement: "p",
	errorPlacement: function(error, element) {
		error.appendTo(element.parent());
	}
});
');
?>

<?= Tips::widget([
    'type' => 'error',
    'model' => $model,
    'closeBtn' => false,
]) ?>

<?php $form = ActiveForm::begin([
    'enableClientScript' => false,
    'options' => ['id' => 'createform'],
]); ?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="cate-form form-table">
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('cname')?><?php if($model->isAttributeRequired('cname')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeInput('text', $model, 'cname', ['class' => 'input']) ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('parentid')?><?php if($model->isAttributeRequired('parentid')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeDropDownList($model, 'parentid', BuildHelper::buildSelectorData(ProductCate::find()->current()->orderBy(['orderid' => SORT_DESC])->all(), ProductCate::class, 'id', 'parentid', 'cname', true), ['encode' => false, 'class' => '']) ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('ctext')?><?php if($model->isAttributeRequired('ctext')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeTextarea($model, 'ctext', ['class' => 'textarea']) ?>
    			<span class="cnote">注意：请填写HTML原生代码，可以<a target="_blank" href="">查看帮助</a></span>
    		</td>
    	</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('picurl')?><?php if($model->isAttributeRequired('picurl')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= JQueryFileUploadWidget::widget([
                    'model' => $model,
                    'attribute' => 'picurl',
                    'options' => ['class' => 'input', 'readonly' => true],
                    'url' => ['fileupload', 'param' => 'value'],
                    'uploadName' => 'picurl',
                    'fileOptions' => [
                        'accept' => '*',//选择文件时的windows过滤器
                        'multiple' => false,//单图
                        'isImage' => true,//图片文件
                    ],//单图
                    'clientOptions' => [
                        'acceptFileTypes' => new JsExpression('/(\.|\/)(gif|jpe?g|png|ai|txt|xls|xlsx|docx|doc|pdf|zip|rar|tar)$/i'),//限制上传的后缀名
                    ],
                ]) ?>
    		</td>
    	</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('linkurl')?><?php if($model->isAttributeRequired('linkurl')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeInput('text', $model, 'linkurl', ['class' => 'input']) ?>
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
			        ProductCate::STATUS_ON => '显示',
				    ProductCate::STATUS_OFF => '隐藏',
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