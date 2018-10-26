<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use common\helpers\ImageHelper;
use common\components\aliyunoss\AliyunOss;
use app\models\cms\Column;
use app\widgets\edititem\EditItemWidget;
use yii\base\Widget;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\shop\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '产品管理';
$this->topFilter = $this->render('_filter', ['model' => $searchModel]);
?>

<?= $this->render('_search', ['model' => $searchModel]); ?>

<?php $form = ActiveForm::begin([
    'enableClientScript' => false,
    'options' => ['id' => 'batchform'],
]); ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="data-table">
	<tr align="left" class="head">
		<td width="4%" class="first-column"><input type="checkbox" name="checkid" id="checkid" onclick="turen.com.checkAll(this.checked);"></td>
		<td width="4%"><?= $dataProvider->sort->link('id', ['label' => 'ID']) ?></td>
		<td width="9%">缩略图</td>
		<td width="12%"><?= $dataProvider->sort->link('title', ['label' => '产品名称']) ?></td>
		<td width="11%">分类</td>
		<td width="11%">品牌</td>
		<td width="6%">售价</td>
		<td width="4%"><?= $dataProvider->sort->link('stock', ['label' => '库存']) ?></td>
		<td width="10%">快捷操作</td>
		<td width="5%"><?= $dataProvider->sort->link('hits', ['label' => '点击']) ?></td>
		<td width="4%"><?= $dataProvider->sort->link('orderid', ['label' => '排序']) ?></td>
		<td width="10%"><?= $dataProvider->sort->link('updated_at', ['label' => '更新日期']) ?></td>
		<td class="end-column">操作</td>
	</tr>
	<?php foreach ($dataProvider->getModels() as $key => $model) {
		$options = [
	        'title' => '点击进行上架和禁售操作',
	        'data-url' => Url::to(['check', 'id' => $model->id]),
	        'onclick' => 'turen.com.updateStatus(this)',
        ];
		$checkstr = Html::a(($model->status?'上架':'禁售'), 'javascript:;', $options);
		
		$options = [
    		'data-url' => Url::to(['delete', 'id' => $model->id, 'returnUrl' => Url::current()]),
		    'onclick' => 'turen.com.deleteItem(this, \''.$model->title.'\')',
		];
		$delstr = Html::a('删除', 'javascript:;', $options);
	?>
	<tr align="left" class="data-tr">
		<td  class="first-column">
			<input type="checkbox" name="checkid[]" id="checkid[]" value="<?= $model->id; ?>">
		</td>
		<td><?= $model->id; ?></td>
		<td><span class="thumbs">
			<img alt="" src="<?= empty($model->picurl)?ImageHelper::getNopic():Yii::$app->aliyunoss->getObjectUrl($model->picurl, true, AliyunOss::OSS_STYLE_NAME180X180) ?>" style="height: 60px;">
		</span></td>
		<td><span class="title" style="color:<?= $model->colorval; ?>;font-weight:<?= $model->boldval; ?>"><?= $model->title; ?><span class="title-flag"><?= implode('&nbsp;', $model->getAllFlag(Column::COLUMN_TYPE_PRODUCT)); ?></span></span><span><em><?= $model->subtitle; ?></em></span></td>
		<td><?= $model->getAllProductCate().' ['.$model->pcateid.']'; ?></td>
		<td><?= $model->getAllProductBrand().' ['.$model->brand_id.']'; ?></td>
		<td><?= Yii::$app->getFormatter()->asCurrency($model->finalPrice()); ?><?= $model->isPromote()?'<span class="is-promote">促</span>':''; ?></td>
		<td><?= $model->stock; ?></td>
		<td><?= '快捷'.$model->is_best.$model->is_new.$model->is_hot; ?></td>
		<td><?= $model->hits; ?></td>
		<td><?= EditItemWidget::widget([
		    'model' => $model,
		    'primaryKey' => 'id',
		    'attribute' => 'orderid',
		    'url' => Url::to(['/shop/product/edit-item']),
		    'options' => [],
		]); ?></td>
		<td><?= Yii::$app->getFormatter()->asDate($model->updated_at); ?></td>
		<td class="action end-column"><span><?= $checkstr; ?></span> | <span><a href="<?= Url::to(['update', 'id' => $model->id]) ?>">修改</a></span> | <span class="nb"><?= $delstr; ?></span></td>
	</tr>
	<?php } ?>
</table>
<?php ActiveForm::end(); ?>

<?php //判断无记录样式
if(empty($dataProvider->count))
{
	echo '<div class="data-empty">暂时没有相关的记录</div>';
}
?>

<div class="bottom-toolbar clearfix">
	<span class="sel-area">
    	<span class="sel-name">选择：</span> 
    	<a href="javascript:turen.com.checkAll(true);">全选</a> - 
    	<a href="javascript:turen.com.checkAll(false);">反选</a>
    	<span class="op-name">操作：</span>
    	<a href="javascript:turen.com.batchSubmit('<?=Url::to(['batch', 'type' => 'delete'])?>', 'batchform');">删除</a>
	</span>
	<?= Html::a('添加新产品', ['create'], ['class' => 'data-btn']) ?>
	<div class="page">
    	<?= LinkPager::widget([
    	    'pagination' => $dataProvider->getPagination(),
    	    'options' => ['class' => 'page-list', 'tag' => 'div'],
    	    'activePageCssClass' => 'on',
    	    'firstPageLabel' => '首页',
    	    'lastPageLabel' => '尾页',
    	    'nextPageLabel' => '下页',
    	    'prevPageLabel' => '上页',
    	    'linkContainerOptions' => ['tag' => 'span'],
    	]);
    	?>
    </div>
</div>

<div class="quick-toolbar">
	<div class="qiuck-warp">
		<div class="quick-area">
    		<span class="sel-area">
        	<span class="sel-name">选择：</span> 
        	<a href="javascript:turen.com.checkAll(true);">全选</a> - 
        	<a href="javascript:turen.com.checkAll(false);">反选</a>
        	<span class="op-name">操作：</span>
        	<a href="javascript:turen.com.batchSubmit('<?=Url::to(['batch', 'type' => 'delete'])?>', 'batchform');">删除</a>
        	<span class="total">共 <?= $dataProvider->getTotalCount() ?> 条记录</span>
    	</span>
			<?= Html::a('添加新文章', ['create'], ['class' => 'data-btn']) ?>
			<div class="page-small">
			<?= LinkPager::widget([
			    'pagination' => $dataProvider->getPagination(),
			    'options' => ['class' => 'page-list', 'tag' => 'div'],
			    'activePageCssClass' => 'on',
			    'firstPageLabel' => '首页',
			    'lastPageLabel' => '尾页',
			    'nextPageLabel' => '下页',
			    'prevPageLabel' => '上页',
			    'linkContainerOptions' => ['tag' => 'span'],
			]);
			?>
			</div>
		</div>
		<div class="quick-area-bg"></div>
	</div>
</div>
<p class="cp tc"><?= Yii::$app->params['config_copyright'] ?></p>