<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\widgets\Tips;
use app\assets\ValidationAsset;
use yii\helpers\Json;
use common\helpers\BuildHelper;
use app\models\cms\Column;
use app\models\cms\Cate;
use app\assets\ColorPickerAsset;
use app\models\cms\DiyModel;
use app\widgets\laydate\LaydateWidget;
use app\widgets\fileupload\JQueryFileUploadWidget;
use yii\web\JsExpression;
use app\widgets\diyfield\DiyFieldWidget;
use app\models\cms\DiyField;
use yii\helpers\ArrayHelper;
use app\models\cms\MasterModel;
use app\models\cms\Flag;
use common\helpers\Functions;

/* @var $this yii\web\View */
/* @var $model app\models\cms\MasterModel */
/* @var $form yii\widgets\ActiveForm */

ValidationAsset::register($this);
ColorPickerAsset::register($this);

$rules = $messages = [];
$rules[Html::getInputName($model, 'columnid')] = ['required' => true];
$rules[Html::getInputName($model, 'title')] = ['required' => true];
$rules[Html::getInputName($model, 'slug')] = ['required' => true];

//自定义字段部分
$diyFieldRules = DiyField::DiyFieldRuleClient($model, $diyModel);
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
    'action' => [$model->isNewRecord?'create':'update', 'id' => $model->id, 'mid' => $diyModel->dm_id],
]); ?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="master-model-form form-table">
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('columnid')?><?php if($model->isAttributeRequired('columnid')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= BuildHelper::buildSelector($model, 'columnid', Column::find()->current()->orderBy(['orderid' => SORT_DESC])->all(), Column::class, 'id', 'parentid', 'cname', true, MasterModel::$DiyModelId, ['onchange' => 'turen.com.filterField(this);'])?>
    			<span class="cnote">带<span class="maroon">*</span>号表示为必填项</span>
    		</td>
    	</tr>
    	<?php if(Yii::$app->params['config.openCate']) { ?>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('cateid')?><?php if($model->isAttributeRequired('cateid')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= BuildHelper::buildSelector($model, 'cateid', Cate::find()->current()->orderBy(['orderid' => SORT_DESC])->all(), Cate::class, 'id', 'parentid', 'catename', false)?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	<?php } ?>
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
    		<td class="first-column"><?= $model->getAttributeLabel('slug')?><?php if($model->isAttributeRequired('slug')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<strong><?= Functions::SlugUrl($model, 'slug', 'article') ?></strong>
    			<div class="slug-input">
        			<?= Html::activeInput('text', $model, 'slug', ['class' => 'input', 'onKeyup' => '$(this).parent().prev().find(".slug-url").html($(this).val());']) ?>
        			<span onclick="turen.com.pinyin(this, document.getElementById('mastermodel-title').value);" class="gray-btn slug-btn">推荐值</span>
    			</div>
    		</td>
    	</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('flag')?><?php if($model->isAttributeRequired('flag')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column attr-area">
    			<?= Html::hiddenInput(Html::getInputName($model, 'flag'), '') ?>
    			<?= Html::checkboxList(Html::getInputName($model, 'flag'), array_keys($model->activeFlagList($modelid)), Flag::FlagList($modelid, true), ['tag' => 'span', 'separator' => '&nbsp;&nbsp;&nbsp;']) ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('picurl')?><?php if($model->isAttributeRequired('picurl')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= JQueryFileUploadWidget::widget([
                    'model' => $model,
                    'attribute' => 'picurl',
                    'options' => ['class' => 'input', 'readonly' => true],
                    'url' => ['fileupload', 'mid' => $diyModel->dm_id],
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
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	<?= DiyFieldWidget::widget([
		    'model' => $model,
		]) ?>
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
			        DiyModel::STATUS_ON => '显示',
    			    DiyModel::STATUS_OFF => '隐藏',
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
            		<?= Html::input('button', 'backName', '返回', ['class' => 'back', 'onclick' => 'location.href="'.Url::to(['index', 'mid' => $diyModel->dm_id]).'"']) ?>
            	</div>
    		</td>
    	</tr>
	</table>
<?php ActiveForm::end(); ?>