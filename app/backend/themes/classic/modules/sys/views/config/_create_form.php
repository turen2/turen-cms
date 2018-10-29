<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\widgets\Tips;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\sys\Config */
/* @var $form yii\widgets\ActiveForm */
$this->registerJs("
$('#config-vartype input').on('click', function() {
    var val = $('#config-vartype input:checked').val();
    if(val == 'radio' || val == 'checkbox' || val == 'select') {
        $('#var-default').show();
    } else {
        $('#var-default').hide();
    }
});
");

//设置选项卡项
$configTabArr = ['基本设置', '附件设置', '性能设置', '核心设置', '界面配置', '产品配置'];
//统计当前数组数量
$configTabNum = count($configTabArr);

echo Tips::widget([
    'type' => 'error',
    'model' => $model,
    'closeBtn' => false,
]);
?>

<div class="config-form">
	<div class="toolbar-tab">
    	<ul id="tabs">
    		<?php
    		foreach($configTabArr as $configTabId => $configTabText)
    		{
    			echo '<li><a href="'.Url::to(['setting']).'">'.$configTabText.'</a></li><li class="line">-</li>';	
    		}
    		?>
			<li class="on"><a href="javascript:;">增加新变量</a></li>
    	</ul>
    </div>
    
    <!--addvarname-->
    <?php $form = ActiveForm::begin([
        'options' => [],
        'method' => 'POST',
        'action' => ['/sys/config/create'],
    ]); ?>
	<div>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form-table">
			<tr>
				<td class="first-column"><?= $model->getAttributeLabel('varname')?><?php if($model->isAttributeRequired('varname')) { ?><span class="maroon">*</span><?php } ?></td>
				<td class="second-column">
					<?= Html::activeTextInput($model, 'varname', ['class' => 'input']) ?>
					<span class="cnote">系统会自动为变量添加 '$config_' 前缀</span>
				</td>
			</tr>
			<tr>
				<td class="first-column"><?= $model->getAttributeLabel('varinfo')?><?php if($model->isAttributeRequired('varinfo')) { ?><span class="maroon">*</span><?php } ?></td>
				<td class="second-column">
					<?= Html::activeTextInput($model, 'varinfo', ['class' => 'input']) ?>
					<span class="cnote"></span>
				</td>
			</tr>
			<tr>
				<td class="first-column"><?= $model->getAttributeLabel('varvalue')?><?php if($model->isAttributeRequired('varvalue')) { ?><span class="maroon">*</span><?php } ?></td>
				<td class="second-column">
					<?= Html::activeTextInput($model, 'varvalue', ['class' => 'input']) ?>
					<span class="cnote"></span>
				</td>
			</tr>
			<tr>
				<td class="first-column"><?= $model->getAttributeLabel('vartype')?><?php if($model->isAttributeRequired('vartype')) { ?><span class="maroon">*</span><?php } ?></td>
				<td class="second-column">
					<?= Html::activeRadioList($model, 'vartype', [
					    'text' => '文本控件',
					    'radio' => '单选控件',
					    'checkbox' => '多选控件',
					    'select' => '下拉控件',
					    'textarea' => '多行文本控件',
					], ['tag' => 'span', 'separator' => '&nbsp;&nbsp;&nbsp;', 'value' => 'text']) ?>
					<span class="cnote"></span>
				</td>
			</tr>
			<tr id="var-default" style="display: none;">
				<td class="first-column"><?= $model->getAttributeLabel('vardefault')?><?php if($model->isAttributeRequired('vardefault')) { ?><span class="maroon">*</span><?php } ?></td>
				<td class="second-column">
					<?= Html::activeTextarea($model, 'vardefault', ['class' => 'textdesc', 'style' => 'width: 310px;']) ?>
    				<div class="hr_5"></div>
					<span class="cnote">注意：如果是数组则使用前值后名字符串：1=>abc|2=>def|3=>ghi</span>
				</td>
			</tr>
			<tr>
				<td class="first-column"><?= $model->getAttributeLabel('vargroup')?><?php if($model->isAttributeRequired('vargroup')) { ?><span class="maroon">*</span><?php } ?></td>
				<td class="second-column">
					<?= Html::activeDropDownList($model, 'vargroup', $configTabArr) ?>
					<span class="cnote"></span>
				</td>
			</tr>
			<tr>
				<td class="first-column"><?= $model->getAttributeLabel('orderid')?><?php if($model->isAttributeRequired('orderid')) { ?><span class="maroon">*</span><?php } ?></td>
				<td class="second-column">
					<?= Html::activeTextInput($model, 'orderid', ['class' => 'inputs']) ?>
					<span class="cnote">数值越大，排序越前</span>
				</td>
			</tr>
			<tr class="nb">
				<td></td>
				<td>
    				<div class="form-sub-btn">
    					<input type="submit" class="submit" value="提交" />
    					<input type="button" class="back" value="返回" onclick="location.href='<?= Url::to(['/sys/config/setting']) ?>'" />
    				</div>
				</td>
			</tr>
		</table>
	</div>
    <?php ActiveForm::end(); ?>
</div>