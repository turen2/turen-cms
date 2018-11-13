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
use app\components\ActiveRecord;
use app\assets\ValidationAsset;
use app\widgets\ueditor\UEditorWidget;
use app\widgets\laydate\LaydateWidget;
use yii\helpers\Json;

/* @var $this yii\web\View */
/* @var $model app\models\sys\Devlog */
/* @var $form yii\widgets\ActiveForm */

ValidationAsset::register($this);

$rules = [];
$rules[Html::getInputName($model, 'log_name')] = ['required' => true];
$rules[Html::getInputName($model, 'log_code')] = ['required' => true];
$rules[Html::getInputName($model, 'log_note')] = ['required' => true];
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
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="devlog-form form-table">
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('log_name')?><?php if($model->isAttributeRequired('log_name')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeInput('text', $model, 'log_name', ['class' => 'input']) ?>
    			<span class="cnote">命名以功能模块为主体</span>
    		</td>
    	</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('log_code')?><?php if($model->isAttributeRequired('log_code')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeInput('text', $model, 'log_code', ['class' => 'input', 'readonly' => 'readonly']) ?>
    			<span class="cnote">只读：自动生成并不允许修改</span>
    		</td>
    	</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('log_note')?><?php if($model->isAttributeRequired('log_note')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= UEditorWidget::widget([
    			    'model' => $model,
    			    'attribute' => 'log_note',
                    'clientOptions' => [
                        'serverUrl' => Url::to(['ueditor']),
                        'initialContent' => '',
                        'initialFrameWidth' => '738',
                        'initialFrameHeight' => '280',
                    ],
                    //'readyEvent' => 'alert(\'abc\');console.log(ue);',
                ]); ?>
    			<span class="cnote">表述前缀必须是：新增、修复、优化、删除</span>
    		</td>
    	</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('log_time')?><?php if($model->isAttributeRequired('log_time')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= LaydateWidget::widget([
    			    'model' => $model,
    			    'attribute' => 'log_time',
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