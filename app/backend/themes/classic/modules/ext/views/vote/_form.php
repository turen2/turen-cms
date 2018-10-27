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
use app\models\ext\Vote;
use app\widgets\laydate\LaydateWidget;
use app\widgets\ueditor\UEditorWidget;

/* @var $this yii\web\View */
/* @var $model app\models\ext\Vote */
/* @var $form yii\widgets\ActiveForm */

ValidationAsset::register($this);

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

$js = <<<EOF
    //
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
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="vote-form form-table">
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('title')?><?php if($model->isAttributeRequired('title')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeInput('text', $model, 'title', ['class' => 'input']) ?>
    			<span class="cnote">带<span class="maroon">*</span>号表示为必填项</span>
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
    	<?php if($model->isNewRecord || empty(count($optionModels))) { ?>
        	<tr class="option-item">
        		<td class="first-column">投票项目：</td>
        		<td class="second-column">
        			<?= Html::input('text', 'options[new][]', $optionModel->options, ['class' => 'input']) ?>
        			<span class="cnote"><a href="javascript:;" class="addNewTr" onclick="turen.ext.addNewOption()" title="新增一行"></a></span>
        		</td>
        	</tr>
    	<?php } else { ?>
    		<?php $ii = 0 ?>
        	<?php foreach ($optionModels as $optionModel) { ?>
        	<tr class="option-item">
        		<td class="first-column"><?php if(empty($ii)) { ?>投票项目：<?php } else { ?><span class="del-vote-txt"><a href="javascript:;" onclick="turen.ext.delOption(this)">删</a></span>：<?php } ?></td>
        		<td class="second-column">
        			<?= Html::input('text', 'options[old]['.$optionModel->id.']', $optionModel->options, ['class' => 'input']) ?>
        			<?php if(empty($ii)) { ?>
        			<span class="cnote"><a href="javascript:;" class="addNewTr" onclick="turen.ext.addNewOption(this)" title="新增一行"></a></span>
        			<?php } ?>
        		</td>
        	</tr>
        	<?php $ii++ ?>
        	<?php } ?>
    	<?php } ?>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('starttime')?><?php if($model->isAttributeRequired('starttime')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= LaydateWidget::widget([
    			    'model' => $model,
    			    'attribute' => 'starttime',
    			    'options' => ['class' => 'inputms'],
    			]) ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('endtime')?><?php if($model->isAttributeRequired('endtime')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= LaydateWidget::widget([
    			    'model' => $model,
    			    'attribute' => 'endtime',
    			    'options' => ['class' => 'inputms'],
    			]) ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('isguest')?><?php if($model->isAttributeRequired('isguest')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeRadioList($model, 'isguest', [
    			    Vote::VIEW_YES => '允许',
    			    Vote::VIEW_NO => '不允许',
				], ['tag' => 'span', 'separator' => '&nbsp;&nbsp;&nbsp;']);
				?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('isview')?><?php if($model->isAttributeRequired('isview')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeRadioList($model, 'isview', [
    			    Vote::VIEW_YES => '允许',
    			    Vote::VIEW_NO => '不允许',
				], ['tag' => 'span', 'separator' => '&nbsp;&nbsp;&nbsp;']);
				?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('intval')?><?php if($model->isAttributeRequired('intval')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeInput('text', $model, 'intval', ['class' => 'inputos']) ?>
    			<span class="cnote">分钟为单位，0 表示此IP地址只能投一次</span>
    		</td>
    	</tr>
    	<tr class="nb">
    		<td class="first-column"><?= $model->getAttributeLabel('isradio')?><?php if($model->isAttributeRequired('isradio')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeRadioList($model, 'isradio', [
    			    Vote::RADIO_SINGLE => '单选',
    			    Vote::RADIO_MULTI => '多选',
				], ['tag' => 'span', 'separator' => '&nbsp;&nbsp;&nbsp;']);
				?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	<tr class="nb">
			<td colspan="2" class="td-line"><div class="line"></div></td>
		</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('orderid')?><?php if($model->isAttributeRequired('orderid')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeInput('text', $model, 'orderid', ['class' => 'inputos']) ?>
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
			        Vote::STATUS_ON => '显示',
				    Vote::STATUS_OFF => '隐藏',
				], ['tag' => 'span', 'separator' => '&nbsp;&nbsp;&nbsp;']);
				?>
				<span class="cnote">选择“否”则该信息不会显示在前台。</span>
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