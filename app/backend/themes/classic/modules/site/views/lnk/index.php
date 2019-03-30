<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\site\Lnk;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel app\models\site\LnkSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '快捷链接管理';
?>
<?php $form = ActiveForm::begin([
    'enableClientScript' => false,
    'options' => ['id' => 'batchform'],
]); ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="data-table">
	<tr align="left" class="head">
		<td width="4%"  class="first-column"><input type="checkbox" name="checkid" id="checkid" onclick="turen.com.checkAll(this.checked);"></td>
		<td width="15%"><?= $dataProvider->sort->link('lnk_name', ['label' => '快捷名称']) ?></td>
		<td width="22%">链接</td>
		<td width="10%">ICO图标</td>
		<td width="10%" align="center"><?= $dataProvider->sort->link('orderid', ['label' => '排序']) ?></td>
		<td class="end-column">操作</td>
	</tr>
	
	<?php if(empty($dataProvider->count)) { ?>
	<tr align="center">
		<td colspan="6" class="data-empty">暂时没有相关的记录</td>
	</tr>
	<?php } ?>
	
	<?php foreach ($dataProvider->getModels() as $key => $model) {
		$options = [
    		'data-url' => Url::to(['delete', 'id' => $model->lnk_id, 'returnUrl' => Url::current()]),
		    'onclick' => 'turen.com.deleteItem(this, \''.$model->lnk_name.'\')',
		];
		$delstr = Html::a('删除', 'javascript:;', $options);
	?>
	<tr align="left" class="data-tr">
		<td  class="first-column">
			<input type="checkbox" name="checkid[]" id="checkid[]" value="<?= $model->lnk_id; ?>">
		</td>
		<td>
			<input type="text" name="lnk_name[]" id="lnk_name[]" class="inputd" value="<?= $model->lnk_name; ?>" />
			<input type="hidden" name="lnk_id[]" id="lnk_id[]" value="<?= $model->lnk_id; ?>">
		</td>
		<td>
			<input type="text" name="lnk_link[]" id="lnk_link[]" class="inputd" value="<?= $model->lnk_link; ?>" />
		</td>
		<td>
			<input type="text" name="lnk_ico[]" id="lnk_ico[]" class="inputd" value="<?= Html::encode($model->lnk_ico); ?>" />
		</td>
		<td align="center">
			<a href="<?=Url::to(['simple-move', 'type' => Lnk::ORDER_UP_TYPE, 'kid' => $model->lnk_id, 'orderid' => $model->orderid])?>" class="left-arrow" title="提升排序"></a>
			<input type="text" name="orderid[]" id="orderid[]" class="inputls" value="<?= $model->orderid; ?>">
			<a href="<?=Url::to(['simple-move', 'type' => Lnk::ORDER_DOWN_TYPE, 'kid' => $model->lnk_id, 'orderid' => $model->orderid])?>" class="right-arrow" title="下降排序"></a>
		</td>
		<td class="action end-column">
			<span class="nb"><?=$delstr?></span>
		</td>
	</tr>
	<?php } ?>
	<tr align="center">
		<td colspan="6"><strong>新增一个快捷方式</strong></td>
	</tr>
	<tr align="left" class="data-tr-on">
		<td  class="first-column">&nbsp;</td>
		<td><input type="text" name="lnk_nameadd" id="lnk_nameadd" class="input" style="width: 200px;" /></td>
		<td><input type="text" name="lnk_linkadd" id="lnk_linkadd" class="input" /></td>
		<td><input type="text" name="lnk_icoadd" id="lnk_icoadd" class="input" style="width: 200px;" /></td>
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
				<a href="javascript:turen.com.batchSubmit('<?=Url::to(['batch', 'type' => 'order'])?>', 'batchform');">排序</a>
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