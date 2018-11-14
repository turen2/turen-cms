<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\widgets\Tips;
use app\assets\ValidationAsset;
use app\models\shop\Product;
use app\widgets\laydate\LaydateWidget;
use app\widgets\ueditor\UEditorWidget;
use app\widgets\fileupload\JQueryFileUploadWidget;
use yii\web\JsExpression;
use app\models\cms\Column;
use common\helpers\BuildHelper;
use app\models\shop\ProductCate;
use app\assets\ColorPickerAsset;
use app\models\shop\Brand;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/* @var $this yii\web\View */
/* @var $model app\models\shop\Product */
/* @var $form yii\widgets\ActiveForm */

ValidationAsset::register($this);
ColorPickerAsset::register($this);

$rules = [];
$rules[Html::getInputName($model, 'columnid')] = ['required' => true];
$rules[Html::getInputName($model, 'pcateid')] = ['required' => true];
$rules[Html::getInputName($model, 'brand_id')] = ['required' => true];
$rules[Html::getInputName($model, 'sales_price')] = ['required' => true, 'digits' => true];
$rules[Html::getInputName($model, 'content')] = ['required' => true];
$rules[Html::getInputName($model, 'picurl')] = ['required' => true];
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
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="product-form form-table">
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('columnid')?><?php if($model->isAttributeRequired('columnid')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= BuildHelper::buildSelector($model, 'columnid', Column::find()->current()->orderBy(['orderid' => SORT_DESC])->all(), Column::class, 'id', 'parentid', 'cname', true, Column::COLUMN_TYPE_PRODUCT)?>
    			<span class="cnote">带<span class="maroon">*</span>号表示为必填项</span>
    		</td>
    	</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('pcateid')?><?php if($model->isAttributeRequired('pcateid')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= BuildHelper::buildSelector($model, 'pcateid', ProductCate::find()->current()->orderBy(['orderid' => SORT_DESC])->all(), ProductCate::class, 'id', 'parentid', 'cname', true, null, ['onchange' => 'turen.shop.getAttrForm(this);'])?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('brand_id')?><?php if($model->isAttributeRequired('brand_id')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeDropDownList($model, 'brand_id', ArrayHelper::map(Brand::find()->current()->active()->all(), 'id', 'bname')); ?>
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
    		<td class="first-column"><?= $model->getAttributeLabel('subtitle')?><?php if($model->isAttributeRequired('subtitle')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeInput('text', $model, 'subtitle', ['class' => 'input']) ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('sku')?><?php if($model->isAttributeRequired('sku')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeInput('text', $model, 'sku', ['class' => 'input']) ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('product_sn')?><?php if($model->isAttributeRequired('product_sn')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeInput('text', $model, 'product_sn', ['class' => 'input']) ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	<tr class="nb">
			<td class="first-column">推荐类型</td>
			<td class="second-column">
				<?= $model->getAttributeLabel('is_best')?>
				<?= Html::activeRadioList($model, 'is_best', [
			        Product::STATUS_ON => '是',
				    Product::STATUS_OFF => '否',
				], ['tag' => 'span', 'separator' => '&nbsp;&nbsp;&nbsp;']);
				?>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<?= $model->getAttributeLabel('is_new')?>
				<?= Html::activeRadioList($model, 'is_new', [
			        Product::STATUS_ON => '是',
				    Product::STATUS_OFF => '否',
				], ['tag' => 'span', 'separator' => '&nbsp;&nbsp;&nbsp;']);
				?>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<?= $model->getAttributeLabel('is_hot')?>
				<?= Html::activeRadioList($model, 'is_hot', [
			        Product::STATUS_ON => '是',
				    Product::STATUS_OFF => '否',
				], ['tag' => 'span', 'separator' => '&nbsp;&nbsp;&nbsp;']);
				?>
				<span class="cnote"></span>
			</td>
		</tr>
    	
    	<tr class="nb">
			<td colspan="2" height="10"><div class="line"> </div></td>
		</tr>
		
		<tr class="nb">
    		<td class="first-column"><?= $model->getAttributeLabel('attrtext')?><?php if($model->isAttributeRequired('attrtext')) { ?><span class="maroon">*</span><?php } ?></td>
			<td class="second-column" id="get-attr">
				<?= $model->attributeForm(); ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
		
		<tr class="nb">
			<td colspan="2" height="10"><div class="line"> </div></td>
		</tr>
		
    	<tr>
    		<td class="first-column">产品价格<span class="maroon">*</span></td>
    		<td class="second-column">
    			<?= Html::activeInput('text', $model, 'sales_price', ['class' => 'inputs']) ?>
    			<?= $model->getAttributeLabel('sales_price')?>
    			<span>&nbsp;&nbsp;&nbsp;&nbsp;</span>
    			<?= Html::activeInput('text', $model, 'market_price', ['class' => 'inputs']) ?>
    			<?= $model->getAttributeLabel('market_price')?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	<tr>
			<td class="first-column"><?= $model->getAttributeLabel('is_shipping')?><?php if($model->isAttributeRequired('is_shipping')) { ?><span class="maroon">*</span><?php } ?></td>
			<td class="second-column">
				<?= Html::activeRadioList($model, 'is_shipping', [
			        Product::STATUS_ON => '是',
				    Product::STATUS_OFF => '否',
				], ['tag' => 'span', 'separator' => '&nbsp;&nbsp;&nbsp;']);
				?>
				<span class="cnote"></span>
			</td>
		</tr>
		<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('weight')?><?php if($model->isAttributeRequired('weight')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeInput('text', $model, 'weight', ['class' => 'inputs']) ?> <?= Yii::$app->params['config_weight_unit_name'] ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	<tr class="nb">
    		<td class="first-column"><?= $model->getAttributeLabel('stock')?><?php if($model->isAttributeRequired('stock')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeInput('text', $model, 'stock', ['class' => 'inputs']) ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	
    	<tr class="nb">
			<td colspan="2" height="10"><div class="line"> </div></td>
		</tr>
		
		<tr>
			<td class="first-column"><?= $model->getAttributeLabel('is_promote')?><?php if($model->isAttributeRequired('is_promote')) { ?><span class="maroon">*</span><?php } ?></td>
			<td class="second-column">
				<?= Html::activeRadioList($model, 'is_promote', [
			        Product::STATUS_ON => '是',
				    Product::STATUS_OFF => '否',
				], ['tag' => 'span', 'separator' => '&nbsp;&nbsp;&nbsp;']);
				?>
				<span class="cnote"></span>
			</td>
		</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('promote_price')?><?php if($model->isAttributeRequired('promote_price')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeInput('text', $model, 'promote_price', ['class' => 'inputs']) ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	<tr class="nb">
    		<td class="first-column">促销时间</td>
    		<td class="second-column">
    			<?= LaydateWidget::widget([
    			    'model' => $model,
    			    'attribute' => 'promote_start_date',
    			    'value' => $model->dateTimeValue('promote_start_date'),
    			    'options' => ['class' => 'inputms'],
    			]) ?>
    			<span>~</span>
    			<?= LaydateWidget::widget([
    			    'model' => $model,
    			    'attribute' => 'promote_end_date',
    			    'value' => $model->dateTimeValue('promote_end_date'),
    			    'options' => ['class' => 'inputms'],
    			]) ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
		
		<tr class="nb">
			<td colspan="2" height="10"><div class="line"> </div></td>
		</tr>
		
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('flag')?><?php if($model->isAttributeRequired('flag')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column attr-area">
    			<?php $model->flag = array_keys($model->getAllFlag(Column::COLUMN_TYPE_PRODUCT))//获取选择的标签数组?>
    			<?= Html::activeCheckboxList($model, 'flag', $model->getAllFlag(Column::COLUMN_TYPE_PRODUCT, true, true), ['tag' => 'span', 'separator' => '&nbsp;&nbsp;&nbsp;']) ?>
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
    		<td class="first-column"><?= $model->getAttributeLabel('linkurl')?><?php if($model->isAttributeRequired('linkurl')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeInput('text', $model, 'linkurl', ['class' => 'input']) ?>
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
    		<td class="first-column"><?= $model->getAttributeLabel('hits')?><?php if($model->isAttributeRequired('hits')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeInput('text', $model, 'hits', ['class' => 'inputs']) ?>
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
    			    'value' => $model->dateTimeValue('posttime'),
    			    'options' => ['class' => 'inputms'],
    			]) ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	<tr>
			<td class="first-column"><?= $model->getAttributeLabel('status')?><?php if($model->isAttributeRequired('status')) { ?><span class="maroon">*</span><?php } ?></td>
			<td class="second-column">
				<?= Html::activeRadioList($model, 'status', [
			        Product::STATUS_ON => '上架',
				    Product::STATUS_OFF => '下架',
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