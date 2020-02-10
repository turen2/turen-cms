<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\base\Widget;
use yii\web\JsExpression;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use common\helpers\Functions;
use backend\widgets\Tips;
use backend\assets\ValidationAsset;
use backend\widgets\laydate\LaydateWidget;
use backend\widgets\fileupload\JQueryFileUploadWidget;
use backend\widgets\ueditor\UEditorWidget;
use backend\widgets\diyfield\DiyFieldWidget;
use backend\models\cms\Info;
use backend\models\cms\DiyField;

/* @var $this yii\web\View */
/* @var $model backend\models\cms\Info */
/* @var $form yii\widgets\ActiveForm */

ValidationAsset::register($this);

$rules = $messages = [];
$rules[Html::getInputName($model, 'slug')] = ['required' => true];

//自定义字段部分
$diyFieldRules = DiyField::DiyFieldRuleClient($model);
$rules = ArrayHelper::merge($diyFieldRules['rules'], $rules);
$messages = ArrayHelper::merge($diyFieldRules['messages'], $messages);

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
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="info-form form-table">
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('columnid')?><?php if($model->isAttributeRequired('columnid')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<strong id="info-title"><?=$model->cname?></strong>
    			<span class="cnote">带<span class="maroon">*</span>号表示为必填项</span>
    		</td>
    	</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('slug')?><?php if($model->isAttributeRequired('slug')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<strong><?= Functions::SlugUrl($model, 'slug', 'page') ?></strong>
    			<div class="slug-input">
        			<?= Html::activeInput('text', $model, 'slug', ['class' => 'input', 'onKeyup' => '$(this).parent().prev().find(".slug-url").html($(this).val());']) ?>
        			<span onclick="turen.com.pinyin(this, document.getElementById('info-title').innerHTML);" class="gray-btn slug-btn">推荐值</span>
    			</div>
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
    		<td class="first-column"><?= $model->getAttributeLabel('content')?><?php if($model->isAttributeRequired('content')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= UEditorWidget::widget([
    			    'model' => $model,
    			    'attribute' => 'content',
                    'clientOptions' => [
                        'serverUrl' => Url::to(['ueditor']),
                        'initialContent' => '',
                        'initialFrameWidth' => '738',
                        'initialFrameHeight' => '280',
                    ],
                    //'readyEvent' => 'alert(\'abc\');console.log(ue);',
                ]); ?>
    		</td>
    	</tr>
    	
    	<?= DiyFieldWidget::widget([
		    'model' => $model,
		]) ?>
		
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