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
use common\helpers\BuildHelper;
use backend\widgets\Tips;
use backend\components\ActiveRecord;
use backend\assets\ValidationAsset;
use backend\models\ext\LinkType;

/* @var $this yii\web\View */
/* @var $model backend\models\ext\LinkType */
/* @var $form yii\widgets\ActiveForm */

ValidationAsset::register($this);

$rules = $messages = [];
$rules[Html::getInputName($model, 'parentid')] = ['required' => true];
$rules[Html::getInputName($model, 'typename')] = ['required' => true];
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
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="link-type-form form-table">
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('parentid')?><?php if($model->isAttributeRequired('parentid')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeDropDownList($model, 'parentid', BuildHelper::buildSelectorData(LinkType::find()->current()->orderBy(['orderid' => SORT_DESC])->all(), LinkType::class, 'id', 'parentid', 'typename'), ['encode' => false, 'class' => '']) ?>
    			<span class="cnote">带<span class="maroon">*</span>号表示为必填项</span>
    		</td>
    	</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('typename')?><?php if($model->isAttributeRequired('typename')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeInput('text', $model, 'typename', ['class' => 'input']) ?>
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
			        LinkType::STATUS_ON => '显示',
				    LinkType::STATUS_OFF => '隐藏',
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