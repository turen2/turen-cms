<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\widgets\Tips;
use app\assets\ValidationAsset;
use app\models\sys\MultilangTpl;
use yii\helpers\ArrayHelper;
use app\models\sys\Template;
use yii\helpers\Json;

/* @var $this yii\web\View */
/* @var $model app\models\sys\MultilangTpl */
/* @var $form yii\widgets\ActiveForm */

ValidationAsset::register($this);

$rules = [];
$rules[Html::getInputName($model, 'lang_name')] = ['required' => true];
$rules[Html::getInputName($model, 'template_id')] = ['required' => true];
$rules[Html::getInputName($model, 'lang_sign')] = ['required' => true];
$rules[Html::getInputName($model, 'key')] = ['required' => true];
$rules = Json::encode($rules);
$js = <<<EOF
var validator = $("#createform").validate({
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
    'options' => ['id' => 'createform'],
]); ?>

<div class="alert alert-warning">注意：同一套模板应该包括 -> 移动端模板和PC端模板两者必须同名且开通相同的语言包。</div>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="multilang-tpl-form form-table">
	<tr>
		<td class="first-column"><?= $model->getAttributeLabel('lang_name')?><?php if($model->isAttributeRequired('lang_name')) { ?><span class="maroon">*</span><?php } ?></td>
		<td class="second-column">
			<?= Html::activeInput('text', $model, 'lang_name', ['class' => 'input']) ?>
			<span class="cnote">多语言站点名称，比如：简体中文站、English。</span>
		</td>
	</tr>
	<tr>
		<td class="first-column"><?= $model->getAttributeLabel('template_id')?><?php if($model->isAttributeRequired('template_id')) { ?><span class="maroon">*</span><?php } ?></td>
		<td class="second-column">
			<?= Html::activeDropDownList($model, 'template_id', ArrayHelper::merge([null => '选择一个模板'], ArrayHelper::map(Template::find()->all(), 'temp_id', 'temp_name')), ['onchange' => 'turen.sys.getTemplate(this);']) ?>
			<span class="cnote">模板是否支持对应语言，由模板自身决定。</span>
		</td>
	</tr>
	<tr>
		<td class="first-column"><?= $model->getAttributeLabel('lang_sign')?><?php if($model->isAttributeRequired('lang_sign')) { ?><span class="maroon">*</span><?php } ?></td>
		<td class="second-column">
			<?= Html::activeDropDownList($model, 'lang_sign', ArrayHelper::merge([null => '--请选择--'], (isset($model->template)?$model->template->tempLangList():[]))) ?>
			<span class="cnote"></span>
		</td>
	</tr>
	<tr>
		<td class="first-column"><?= $model->getAttributeLabel('key')?><?php if($model->isAttributeRequired('key')) { ?><span class="maroon">*</span><?php } ?></td>
		<td class="second-column">
			<?= Html::activeInput('text', $model, 'key', ['class' => 'inputs']) ?>
			<span class="cnote">可以改善url样式，如：英文网站，语言包为en-US，对应标识为en，那么访问地址就是：http://sss.com/en/。</span>
		</td>
	</tr>
	<tr>
		<td class="first-column"><?= $model->getAttributeLabel('back_default')?><?php if($model->isAttributeRequired('back_default')) { ?><span class="maroon">*</span><?php } ?></td>
		<td class="second-column">
			<?= Html::activeRadioList($model, 'back_default', [
			    MultilangTpl::STATUS_ON => '是',
			    MultilangTpl::STATUS_OFF => '否',
			], ['tag' => 'span', 'separator' => '&nbsp;&nbsp;&nbsp;']);
			?>
			<span class="cnote"></span>
		</td>
	</tr>
	<tr>
		<td class="first-column"><?= $model->getAttributeLabel('front_default')?><?php if($model->isAttributeRequired('front_default')) { ?><span class="maroon">*</span><?php } ?></td>
		<td class="second-column">
			<?= Html::activeRadioList($model, 'front_default', [
			    MultilangTpl::STATUS_ON => '是',
			    MultilangTpl::STATUS_OFF => '否',
			], ['tag' => 'span', 'separator' => '&nbsp;&nbsp;&nbsp;']);
			?>
			<span class="cnote">&nbsp;&nbsp;注意：默认站点为主语言站点，不会显示url的网站标识。</span>
		</td>
	</tr>
	<tr>
		<td class="first-column"><?= $model->getAttributeLabel('is_visible')?><?php if($model->isAttributeRequired('is_visible')) { ?><span class="maroon">*</span><?php } ?></td>
		<td class="second-column">
			<?= Html::activeRadioList($model, 'is_visible', [
			    MultilangTpl::STATUS_ON => '显示',
			    MultilangTpl::STATUS_OFF => '隐藏',
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