<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use common\helpers\BuildHelper;
use common\helpers\Functions;
use yii\web\JsExpression;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use backend\widgets\Tips;
use backend\assets\ValidationAsset;
use backend\models\cms\Column;
use backend\models\cms\Video;
use backend\models\cms\Src;
use backend\models\cms\Cate;
use backend\widgets\select2\Select2Widget;
use backend\widgets\laydate\LaydateWidget;
use backend\assets\ColorPickerAsset;
use backend\widgets\fileupload\JQueryFileUploadWidget;
use backend\widgets\ueditor\UEditorWidget;
use backend\widgets\diyfield\DiyFieldWidget;
use backend\models\cms\DiyField;
use backend\models\cms\Flag;

/* @var $this yii\web\View */
/* @var $model backend\models\cms\Video */
/* @var $form yii\widgets\ActiveForm */

ValidationAsset::register($this);
ColorPickerAsset::register($this);

$rules = $messages = [];
$rules[Html::getInputName($model, 'columnid')] = ['required' => true];
$rules[Html::getInputName($model, 'title')] = ['required' => true];
$rules[Html::getInputName($model, 'videolink')] = ['required' => true];
$rules[Html::getInputName($model, 'slug')] = ['required' => true];

//自定义字段部分
$diyFieldRules = DiyField::DiyFieldRuleClient($model);
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

$srcModels = Src::find()->current()->orderBy(['orderid' => SORT_DESC])->all();
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
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="video-form form-table">
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('columnid')?><?php if($model->isAttributeRequired('columnid')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= BuildHelper::buildSelector($model, 'columnid', Column::find()->current()->orderBy(['orderid' => SORT_DESC])->all(), Column::class, 'id', 'parentid', 'cname', true, Column::COLUMN_TYPE_VIDEO, ['onchange' => 'turen.com.filterField(this);'])?>
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
    			<strong><?= Functions::SlugUrl($model, 'slug', 'page') ?></strong>
    			<div class="slug-input">
        			<?= Html::activeInput('text', $model, 'slug', ['class' => 'input', 'onKeyup' => '$(this).parent().prev().find(".slug-url").html($(this).val());']) ?>
        			<span onclick="turen.com.pinyin(this, document.getElementById('video-title').value);" class="gray-btn slug-btn">推荐值</span>
    			</div>
    		</td>
    	</tr>
        <?php /* ?>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('flag')?><?php if($model->isAttributeRequired('flag')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column attr-area">
    			<?= Html::hiddenInput(Html::getInputName($model, 'flag'), '') ?>
    			<?= Html::checkboxList(Html::getInputName($model, 'flag'), array_keys($model->activeFlagList(Column::COLUMN_TYPE_PRODUCT)), Flag::FlagList(Column::COLUMN_TYPE_PRODUCT, true), ['tag' => 'span', 'separator' => '&nbsp;&nbsp;&nbsp;']) ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
        <?php */ ?>
        <tr>
            <td class="first-column"><?= $model->getAttributeLabel('flag')?><?php if($model->isAttributeRequired('flag')) { ?><span class="maroon">*</span><?php } ?></td>
            <td class="second-column attr-area">
                <?= Html::hiddenInput(Html::getInputName($model, 'flag'), '') ?>
                <span id="flag-checkbox-list"><?= Html::checkboxList(Html::getInputName($model, 'flag'), array_keys($model->activeFlagList($model->columnid)), Flag::ColumnFlagList($model->columnid, true), ['tag' => 'span', 'separator' => '&nbsp;&nbsp;&nbsp;']) ?></span>
                <span class="cnote">注意：选择栏目后自动加载</span>
            </td>
        </tr>
    	<tr class="nb">
    		<td class="first-column"><?= $model->getAttributeLabel('tags')?><?php if($model->isAttributeRequired('tags')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
        		<?= Select2Widget::widget([
        		    'model' => $model,
        		    'attribute' => 'tagNames',
        		    'route' => 'video/get-tags',
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
    		<td class="first-column"><?= $model->getAttributeLabel('source')?><?php if($model->isAttributeRequired('source')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeInput('text', $model, 'source', ['class' => 'input']) ?>
    			<span class="srcArea">
        			<span class="infosrc">选择
    					<ul>
    					<?php foreach ($srcModels as $srcModel) { ?>
    						<li><a href="javascript:;" data-name="<?=$srcModel->srcname?>" data-url="<?=$srcModel->linkurl?>" title="<?=$srcModel->srcname?>"><?=$srcModel->srcname?></a></li>
						<?php } ?>
    					</ul>
    				</span>
				</span>
    			<span class="cnote"></span>
    		</td>
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
    			<?= Html::activeInput('text', $model, 'keywords', ['class' => 'input seo-input']) ?>
    			<span class="cnote"></span>
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
    	<?= DiyFieldWidget::widget([
		    'model' => $model,
		]) ?>
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
    		<td class="first-column"><?= $model->getAttributeLabel('videolink')?><?php if($model->isAttributeRequired('videolink')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeInput('text', $model, 'videolink', ['class' => 'input']) ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	<tr class="nb">
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
    	<tr class="nb">
			<td colspan="2" class="td-line"><div class="line"> </div></td>
		</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('base_hits')?><?php if($model->isAttributeRequired('base_hits')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeInput('text', $model, 'base_hits', ['class' => 'inputs']) ?>
    			<span class="cnote">前台展示=虚拟点击量+真实点击量</span>
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
			        Video::STATUS_ON => '显示',
				    Video::STATUS_OFF => '隐藏',
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