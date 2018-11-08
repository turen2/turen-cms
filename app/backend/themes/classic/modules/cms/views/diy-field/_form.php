<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\widgets\Tips;
use app\assets\ValidationAsset;
use app\models\cms\DiyField;
use app\models\cms\Column;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\cms\DiyField */
/* @var $form yii\widgets\ActiveForm */

ValidationAsset::register($this);

$this->registerJs('
var validator = $("#createform").validate({
	rules: {
		"'.Html::getInputName($model, 'columnid_list').'": {
			required: true,
		},
        "'.Html::getInputName($model, 'fd_title').'": {
			required: true,
		},
        "'.Html::getInputName($model, 'fd_column_type').'": {
			required: true,
		},
        "'.Html::getInputName($model, 'fd_name').'": {
			required: true,
		},
        "'.Html::getInputName($model, 'fd_type').'": {
			required: true,
		},
        "'.Html::getInputName($model, 'fd_long').'": {
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
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="diy-field-form form-table">
	<tr>
		<td class="first-column"><?= $model->getAttributeLabel('fd_column_type')?><?php if($model->isAttributeRequired('fd_column_type')) { ?><span class="maroon">*</span><?php } ?></td>
		<td class="second-column">
			<?= Html::activeDropDownList($model, 'fd_column_type', ArrayHelper::merge([null => '--请选择类型--'], Column::ColumnConvert('id2name')), ['onchange' => 'turen.cms.getColumnCheckboxList(this);']) ?>
			<span class="cnote"></span>
		</td>
	</tr>
	<tr>
		<td class="first-column"><?= $model->getAttributeLabel('columnid_list')?><?php if($model->isAttributeRequired('columnid_list')) { ?><span class="maroon">*</span><?php } ?></td>
		<td class="second-column">
			<?php $model->columnid_list = is_array($model->columnid_list)?$model->columnid_list:(explode(',', $model->columnid_list)); ?>
			<span id="fd-column-droplist"><?= Html::activeCheckboxList($model, 'columnid_list', Column::ColumnListByType($model->fd_column_type), ['tag' => 'span', 'separator' => '&nbsp;&nbsp;&nbsp;']) ?></span>
			<span class="cnote"></span>
		</td>
	</tr>
	<tr>
		<td class="first-column"><?= $model->getAttributeLabel('fd_name')?><?php if($model->isAttributeRequired('fd_name')) { ?><span class="maroon">*</span><?php } ?></td>
		<td class="second-column">
			<?= Html::activeInput('text', $model, 'fd_name', ['class' => 'input']) ?>
			<span class="cnote">字段名将在对应模型表中创建新字段，且以“diyfield_”开头</span>
		</td>
	</tr>
	<tr>
		<td class="first-column"><?= $model->getAttributeLabel('fd_title')?><?php if($model->isAttributeRequired('fd_title')) { ?><span class="maroon">*</span><?php } ?></td>
		<td class="second-column">
			<?= Html::activeInput('text', $model, 'fd_title', ['class' => 'input']) ?>
			<span class="cnote">例如：文章标题</span>
		</td>
	</tr>
	<tr>
		<td class="first-column"><?= $model->getAttributeLabel('fd_desc')?><?php if($model->isAttributeRequired('fd_desc')) { ?><span class="maroon">*</span><?php } ?></td>
		<td class="second-column">
			<?= Html::activeInput('text', $model, 'fd_desc', ['class' => 'input']) ?>
			<span class="cnote"></span>
		</td>
	</tr>
	<tr>
		<td class="first-column"><?= $model->getAttributeLabel('fd_type')?><?php if($model->isAttributeRequired('fd_type')) { ?><span class="maroon">*</span><?php } ?></td>
		<td class="second-column">
			<?= Html::activeInput('text', $model, 'fd_type', ['class' => 'input']) ?>
			<span class="cnote"></span>
		</td>
	</tr>
	<tr>
		<td class="first-column"><?= $model->getAttributeLabel('fd_long')?><?php if($model->isAttributeRequired('fd_long')) { ?><span class="maroon">*</span><?php } ?></td>
		<td class="second-column">
			<?= Html::activeInput('text', $model, 'fd_long', ['class' => 'input']) ?>
			<span class="cnote"></span>
		</td>
	</tr>
	<tr>
		<td class="first-column"><?= $model->getAttributeLabel('fd_value')?><?php if($model->isAttributeRequired('fd_value')) { ?><span class="maroon">*</span><?php } ?></td>
		<td class="second-column">
			<?= Html::activeInput('text', $model, 'fd_value', ['class' => 'input']) ?>
			<span class="cnote"></span>
		</td>
	</tr>
	<tr>
		<td class="first-column"><?= $model->getAttributeLabel('fd_check')?><?php if($model->isAttributeRequired('fd_check')) { ?><span class="maroon">*</span><?php } ?></td>
		<td class="second-column">
			<?= Html::activeInput('text', $model, 'fd_check', ['class' => 'input']) ?>
			<span class="cnote"></span>
		</td>
	</tr>
	<tr>
		<td class="first-column"><?= $model->getAttributeLabel('fd_tips')?><?php if($model->isAttributeRequired('fd_tips')) { ?><span class="maroon">*</span><?php } ?></td>
		<td class="second-column">
			<?= Html::activeInput('text', $model, 'fd_tips', ['class' => 'input']) ?>
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
		        DiyField::STATUS_ON => '显示',
			    DiyField::STATUS_OFF => '隐藏',
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