<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\cms\Src;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel app\models\cms\SrcSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '信息来源管理';
?>
<?php $form = ActiveForm::begin([
    'enableClientScript' => false,
    'options' => ['id' => 'batchform'],
]); ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="data-table">
	<tr align="left" class="head">
		<td width="4%"  class="first-column"><input type="checkbox" name="checkid" id="checkid" onclick="turen.com.checkAll(this.checked);"></td>
		<td width="20%"><?= $dataProvider->sort->link('srcname', ['label' => '来源名称']) ?></td>
		<td width="30%">来源地址</td>
		<td width="10%" align="center"><?= $dataProvider->sort->link('orderid', ['label' => '排序']) ?></td>
		<td class="end-column">操作</td>
	</tr>
	
	<?php if(empty($dataProvider->count)) { ?>
	<tr align="center">
		<td colspan="5" class="data-empty">暂时没有相关的记录</td>
	</tr>
	<?php } ?>
	
	<?php foreach ($dataProvider->getModels() as $key => $model) {
		$options = [
    		'data-url' => Url::to(['delete', 'id' => $model->id, 'returnUrl' => Url::current()]),
		    'onclick' => 'turen.com.deleteItem(this, \''.$model->srcname.'\')',
		];
		$delstr = Html::a('删除', 'javascript:;', $options);
	?>
	<tr align="left" class="data-tr">
		<td  class="first-column">
			<input type="checkbox" name="checkid[]" id="checkid[]" value="<?= $model->id; ?>">
		</td>
		<td>
			<input type="text" name="srcname[]" id="srcname[]" class="inputd" value="<?= $model->srcname; ?>" />
			<input type="hidden" name="id[]" id="id[]" value="<?= $model->id; ?>">
		</td>
		<td>
			<input type="text" name="linkurl[]" id="linkurl[]" class="inputd" value="<?= $model->linkurl; ?>" />
		</td>
		<td align="center">
			<a href="<?=Url::to(['simple-move', 'type' => Src::ORDER_UP_TYPE, 'id' => $model->id, 'orderid' => $model->orderid])?>" class="left-arrow" title="提升排序"></a>
			<input type="text" name="orderid[]" id="orderid[]" class="inputls" value="<?= $model->orderid; ?>">
			<a href="<?=Url::to(['simple-move', 'type' => Src::ORDER_DOWN_TYPE, 'id' => $model->id, 'orderid' => $model->orderid])?>" class="right-arrow" title="下降排序"></a>
		</td>
		<td class="action end-column">
			<span class="nb"><?=$delstr?></span>
		</td>
	</tr>
	<?php } ?>
	<tr align="center">
		<td colspan="5"><strong>新增一个信息标记</strong></td>
	</tr>
	<tr align="left" class="data-tr-on">
		<td  class="first-column">&nbsp;</td>
		<td><input type="text" name="srcnameadd" id="srcnameadd" class="input" /></td>
		<td><input type="text" name="linkurladd" id="linkurladd" class="input" /></td>
		<td align="center"><input type="text" name="orderidadd" id="orderidadd" class="inputls" value="" /></td>
		<td>&nbsp;</td>
	</tr>
</table>
<?php ActiveForm::end(); ?>

<div class="bottom-toolbar clearfix">
	<span class="sel-area">
		<span class="sel-name">选择：</span>
    	<a href="javascript:turen.com.checkAll(true);">全选</a> - 
    	<a href="javascript:turen.com.checkAll(false);">反选</a>
    	<span class="op-name">操作：</span>
    	<a href="javascript:turen.com.batchSubmit('<?=Url::to(['batch', 'type' => 'delete'])?>', 'batchform');">删除</a> - 
    	<a href="javascript:turen.com.batchSubmit('<?=Url::to(['batch', 'type' => 'order'])?>', 'batchform');">排序</a>
	</span>
	<a href="#" onclick="batchform.submit();" class="data-btn">更新全部</a>
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
				<span class="sel-name">选择：</span> <a href="javascript:turen.com.checkAll(true);">全选</a> - 
				<a href="javascript:turen.com.checkAll(false);">反选</a>
				<a href="javascript:turen.com.batchSubmit('<?=Url::to(['batch', 'type' => 'delete'])?>', 'batchform');">删除</a>
				<span class="op-name">操作：</span>
				<a href="javascript:turen.com.batchSubmit('<?=Url::to(['batch', 'type' => 'delete'])?>', 'batchform');">删除</a> - 
				<a href="javascript:turen.com.batchSubmit('<?=Url::to(['batch', 'type' => 'order'])?>', 'batchform');">排序</a> - 
				<span class="total">共 <?= $dataProvider->getTotalCount() ?> 条记录</span>
			</span>
			<a href="#" onclick="batchform.submit();" class="data-btn">更新全部</a>
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