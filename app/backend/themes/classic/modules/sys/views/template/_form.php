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
use app\models\sys\Template;
use app\widgets\laydate\LaydateWidget;
use app\widgets\ueditor\UEditorWidget;
use app\widgets\fileupload\JQueryFileUploadWidget;
use yii\web\JsExpression;
use yii\helpers\Json;

/* @var $this yii\web\View */
/* @var $model app\models\sys\Template */
/* @var $form yii\widgets\ActiveForm */

ValidationAsset::register($this);

$rules = [];
$rules[Html::getInputName($model, 'temp_name')] = ['required' => true];
$rules[Html::getInputName($model, 'temp_code')] = ['required' => true];
$rules[Html::getInputName($model, 'langs')] = ['required' => true];
$rules = Json::encode($rules);
$js = <<<EOF
var validator = $("#submitform").validate({
	rules: {$rules},
    errorElement: "p",
	errorPlacement: function(error, element) {
        if (element.is(\':radio\') || element.is(\':checkbox\')) { //如果是radio或checkbox
            var eid = element.attr(\'name\');
            error.appendTo(element.parent().parent());
        } else {
            error.appendTo(element.parent());
        }
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
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="template-form form-table">
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('temp_name')?><?php if($model->isAttributeRequired('temp_name')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeInput('text', $model, 'temp_name', ['class' => 'input']) ?>
    			<span class="cnote">带<span class="maroon">*</span>号表示为必填项</span>
    		</td>
    	</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('temp_code')?><?php if($model->isAttributeRequired('temp_code')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeDropDownList($model, 'temp_code', Template::TemplateCodes(), ['class' => 'input']) ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('langs')?><?php if($model->isAttributeRequired('langs')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?php $model->langs = $model->getAttributeToArray() ?>
    			<?= Html::activeCheckboxList($model, 'langs', Yii::$app->params['config.languages'], [
    			    'tag' => 'span',
    			    'separator' => '&nbsp;&nbsp;&nbsp;',
    			]); ?>
    			<span class="cnote">选中的语言必须是模板所支持的，否则前台切换语言无效果</span>
    		</td>
    	</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('design_name')?><?php if($model->isAttributeRequired('design_name')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeInput('text', $model, 'design_name', ['class' => 'input']) ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	<tr class="nb">
    		<td class="first-column"><?= $model->getAttributeLabel('developer_name')?><?php if($model->isAttributeRequired('developer_name')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeInput('text', $model, 'developer_name', ['class' => 'input']) ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	
    	<tr class="nb">
			<td colspan="2" class="td-line"><div class="line"> </div></td>
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
    		<td class="first-column"><?= $model->getAttributeLabel('picarr')?><?php if($model->isAttributeRequired('picarr')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= JQueryFileUploadWidget::widget([
                    'model' => $model,
                    'attribute' => 'picarr',
    			    'pics' => $model->getPics(),//重要
                    'options' => ['class' => 'input', 'readonly' => true],
                    'url' => ['multiple-fileupload', 'param' => 'value'],
                    'uploadName' => 'picarr',
                    'fileOptions' => [
                        'accept' => '*',//选择文件时的windows过滤器
                        'multiple' => true,//多图
                        'isImage' => true,//图片文件
                    ],//多图
                    'clientOptions' => [
                        'acceptFileTypes' => new JsExpression('/(\.|\/)(gif|jpe?g|png|ai|txt|xls|xlsx|docx|doc|pdf|zip|rar|tar)$/i'),//限制上传的后缀名
                    ],
                ]) ?>
    		</td>
    	</tr>
    	<tr class="nb">
    		<td class="first-column"><?= $model->getAttributeLabel('note')?><?php if($model->isAttributeRequired('note')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= UEditorWidget::widget([
    			    'model' => $model,
    			    'attribute' => 'note',
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
    	
    	<tr class="nb">
			<td colspan="2" class="td-line"><div class="line"> </div></td>
		</tr>
		
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('posttime')?><?php if($model->isAttributeRequired('posttime')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= LaydateWidget::widget([
    			    'model' => $model,
    			    'attribute' => 'posttime',
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