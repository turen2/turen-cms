<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use common\helpers\BuildHelper;
use backend\widgets\Tips;
use backend\assets\ValidationAsset;
use backend\models\cms\Column;
use backend\models\cms\DiyModel;

ValidationAsset::register($this);

$rules = $messages = [];
$rules[Html::getInputName($model, 'flagname')] = ['required' => true];
$rules[Html::getInputName($model, 'flag')] = ['required' => true];
$rules[Html::getInputName($model, 'columnid')] = ['required' => true];

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

// 栏目类型集合
$types = [];
foreach (DiyModel::find()->select('dm_id')->asArray()->all() as $dm) {
    $types[] = $dm['dm_id'];
}
$types = ArrayHelper::merge(array_values($types), [Column::COLUMN_TYPE_ARTICLE, Column::COLUMN_TYPE_FILE, Column::COLUMN_TYPE_PHOTO, Column::COLUMN_TYPE_PRODUCT, Column::COLUMN_TYPE_VIDEO]);
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
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="flag-form form-table">
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('flagname')?><?php if($model->isAttributeRequired('flagname')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeInput('text', $model, 'flagname', ['class' => 'input']) ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('flag')?><?php if($model->isAttributeRequired('flag')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeInput('text', $model, 'flag', ['class' => 'input']) ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
        <tr>
            <td class="first-column"><?= $model->getAttributeLabel('columnid')?><?php if($model->isAttributeRequired('columnid')) { ?><span class="maroon">*</span><?php } ?></td>
            <td class="second-column">
                <?= BuildHelper::buildSelector($model, 'columnid', Column::find()->current()->orderBy(['orderid' => SORT_DESC])->all(), Column::class, 'id', 'parentid', 'cname', true, $types, ['onchange' => 'turen.com.filterField(this);'])?>
                <span class="cnote">带<span class="maroon">*</span>号表示为必填项</span>
            </td>
        </tr>
        <?php /* ?>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('type')?><?php if($model->isAttributeRequired('type')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeDropDownList($model, 'type', Column::ColumnConvert('id2name', null), ['encode' => false, 'class' => '']) ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
        <?php */?>
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