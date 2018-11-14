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
use app\models\ext\Ad;
use common\helpers\BuildHelper;
use app\models\ext\AdType;
use app\widgets\laydate\LaydateWidget;
use app\widgets\fileupload\JQueryFileUploadWidget;
use yii\web\JsExpression;
use yii\helpers\Json;

/* @var $this yii\web\View */
/* @var $model app\models\ext\Ad */
/* @var $form yii\widgets\ActiveForm */

ValidationAsset::register($this);

$rules = [];
$rules[Html::getInputName($model, 'ad_type_id')] = ['required' => true];
$rules[Html::getInputName($model, 'title')] = ['required' => true];
$rules = Json::encode($rules);
$js = <<<EOF
var validator = $("#submitform").validate({
	rules: {$rules},
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
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="ad-form form-table">
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('ad_type_id')?><?php if($model->isAttributeRequired('ad_type_id')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeDropDownList($model, 'ad_type_id', BuildHelper::buildSelectorData(AdType::find()->current()->orderBy(['orderid' => SORT_DESC])->all(), AdType::class, 'id', 'parentid', 'typename'), ['encode' => false, 'class' => '']) ?>
    			<span class="cnote">带<span class="maroon">*</span>号表示为必填项</span>
    		</td>
    	</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('title')?><?php if($model->isAttributeRequired('title')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeInput('text', $model, 'title', ['class' => 'input']) ?>
    			<span class="cnote">例如：某某推广第9期</span>
    		</td>
    	</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('picurl')?><?php if($model->isAttributeRequired('picurl')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<div class="hr_10"></div>
    			<?= Html::activeRadioList($model, 'admode', [
				    'image' => '图片',
    			    'flash' => 'Flash',
    			    'video' => '视频',
    			    'html' => 'HTML',
				], ['tag' => 'span', 'separator' => '&nbsp;&nbsp;&nbsp;']);
				?>
				<div class="hr_10"></div>
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
    		<td class="first-column"><?= $model->getAttributeLabel('adtext')?><?php if($model->isAttributeRequired('adtext')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeInput('text', $model, 'adtext', ['class' => 'input']) ?>
    			<span class="cnote"></span>
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
    		<td class="first-column"><?= $model->getAttributeLabel('posttime')?><?php if($model->isAttributeRequired('posttime')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= LaydateWidget::widget([
    			    'model' => $model,
    			    'attribute' => 'posttime',
    			    'value' => $model->dateTimeValue(),
    			    'options' => ['class' => 'inputms'],
    			]) ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	<tr>
			<td class="first-column"><?= $model->getAttributeLabel('status')?><?php if($model->isAttributeRequired('status')) { ?><span class="maroon">*</span><?php } ?></td>
			<td class="second-column">
				<?= Html::activeRadioList($model, 'status', [
				    Ad::STATUS_ON => '显示',
				    Ad::STATUS_OFF => '隐藏',
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