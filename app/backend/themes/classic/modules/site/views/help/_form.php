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
use common\helpers\BuildHelper;
use app\models\site\Help;
use app\models\site\Src;
use app\models\site\HelpCate;
use yii\base\Widget;
use app\widgets\select2\Select2Widget;
use app\models\site\Tag;
use app\widgets\laydate\LaydateWidget;
use app\assets\ColorPickerAsset;
use app\widgets\fileupload\JQueryFileUploadWidget;
use yii\web\JsExpression;
use app\widgets\ueditor\UEditorWidget;

/* @var $this yii\web\View */
/* @var $model app\models\site\Help */
/* @var $form yii\widgets\ActiveForm */

ValidationAsset::register($this);
ColorPickerAsset::register($this);

$this->registerJs('
var validator = $("#submitform").validate({
	rules: {
		"'.Html::getInputName($model, 'title').'": {
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
    'options' => ['id' => 'submitform'],
]); ?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="help-form form-table">
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('cateid')?><?php if($model->isAttributeRequired('cateid')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= BuildHelper::buildSelector($model, 'cateid', HelpCate::find()->orderBy(['orderid' => SORT_DESC])->all(), HelpCate::class, 'id', 'parentid', 'catename', false)?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('title')?><?php if($model->isAttributeRequired('title')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeInput('text', $model, 'title', ['class' => 'input', 'style' => 'color:'.$model->colorval.';font-weight:'.$model->boldval]) ?>
    			<div class="titlePanel">
					<?= Html::activeInput('hidden', $model, 'colorval', ['class' => '']) ?>
    				<?= Html::activeInput('hidden', $model, 'boldval', ['class' => '']) ?>
					<span onclick="colorpicker('colorpanel-1','<?= Html::getInputId($model, 'colorval') ?>','<?= Html::getInputId($model, 'title') ?>');" class="color" title="标题颜色"> </span>
					<span id="colorpanel-1"></span>
					<span onclick="blodpicker('<?= Html::getInputId($model, 'boldval') ?>','<?= Html::getInputId($model, 'title') ?>');" class="blod" title="标题加粗"> </span>
					<span onclick="clearpicker('<?= Html::getInputId($model, 'colorval') ?>', '<?= Html::getInputId($model, 'boldval') ?>','<?= Html::getInputId($model, 'title') ?>')" class="clear" title="清除属性">[#]</span> &nbsp; 
				</div>
    		</td>
    	</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('flag')?><?php if($model->isAttributeRequired('flag')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column attr-area">
    			<?php $model->flag = array_keys($model->getAllHelpFlag())//获取选择的标签数组?>
    			<?= Html::activeCheckboxList($model, 'flag', $model->getAllHelpFlag(true, true), ['tag' => 'span', 'separator' => '&nbsp;&nbsp;&nbsp;']) ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	<tr class="nb">
    		<td class="first-column"><?= $model->getAttributeLabel('tags')?><?php if($model->isAttributeRequired('tags')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
        		<?= Select2Widget::widget([
        		    'model' => $model,
        		    'attribute' => 'tagNames',
        		    'route' => 'help/get-tags',
        		    //初始化关联表对象
        		    'primaryKey' => 'tag_id',
        		    'showField' => 'name',
        		    
        		    'clientOptions' => ['width' => '285px'],
        		    'options' => ['multiple' => 'multiple'],//开启多选
        		]) ?>
    			<span class="cnote">输入逗号，时系统将自动分词</span>
    		</td>
    	</tr>
    	<tr class="nb">
			<td colspan="2" class="td-line"><div class="line"> </div></td>
		</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('author')?><?php if($model->isAttributeRequired('author')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeInput('text', $model, 'author', ['class' => 'input']) ?>
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
    		<td class="first-column"><?= $model->getAttributeLabel('keywords')?><?php if($model->isAttributeRequired('keywords')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeInput('text', $model, 'keywords', ['class' => 'input']) ?>
    			<span class="cnote">多关键词之间用空格或者“,”隔开</span>
    		</td>
    	</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('description')?><?php if($model->isAttributeRequired('description')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeTextarea($model, 'description', ['class' => 'textdesc']) ?>
				<div class="hr_5"></div>
				最多能输入 <strong>255</strong> 个字符 
    			<span class="cnote"></span>
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
    	<tr class="nb">
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
			<td colspan="2" class="td-line"><div class="line"> </div></td>
		</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('hits')?><?php if($model->isAttributeRequired('hits')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeInput('text', $model, 'hits', ['class' => 'inputos']) ?>
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
    			    'options' => ['class' => 'inputms'],
    			]) ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	<tr>
			<td class="first-column"><?= $model->getAttributeLabel('status')?><?php if($model->isAttributeRequired('status')) { ?><span class="maroon">*</span><?php } ?></td>
			<td class="second-column">
				<?= Html::activeRadioList($model, 'status', [
			        Help::STATUS_ON => '显示',
				    Help::STATUS_OFF => '隐藏',
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