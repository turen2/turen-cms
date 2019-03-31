<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use app\models\ext\Nav;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ext\NavSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '导航菜单管理';
?>

<?php // $this->render('_search', ['model' => $searchModel]); ?>

<?php $form = ActiveForm::begin([
    'enableClientScript' => false,
    'options' => ['id' => 'batchform'],
]); ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="data-table">
	<tr align="left" class="head">
		<td width="4%" class="first-column"><input type="checkbox" name="checkid" onclick="turen.com.checkAll(this.checked);"></td>
		<td width="3%">ID</td>
		<td width="27%">导航名称</td>
		<td width="20%">跳转链接</td>
		<td align="center">排序</td>
		<td width="25%" class="end-column">操作</td>
	</tr>
</table>

<?php foreach ($dataProvider->getModels() as $key => $model) {
	$options = [
	        'title' => '点击进行显示和隐藏操作',
	        'data-url' => Url::to(['check', 'kid' => $model->id]),
	        'onclick' => 'turen.com.updateStatus(this)',
        ];
	$checkstr = Html::a(($model->status?'显示':'隐藏'), 'javascript:;', $options);
		
	$options = [
		'data-url' => Url::to(['delete', 'id' => $model->id, 'returnUrl' => Url::current()]),
	    'onclick' => 'turen.com.deleteItem(this, \''.$model->menuname.'\')',
		'class' => '',
	];
	$delstr = Html::a('删除', 'javascript:;', $options);
?>
<div rel="rowpid_<?=$model->getTopID('parentstr', 1)?>">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="data-table">
    <tbody>
    	<tr align="left" class="data-tr">
			<td width="4%" class="first-column">
				<input type="checkbox" name="checkid[]" id="checkid[]" value="<?= $model->id; ?>">
			</td>
			<td width="3%"><?= $model->id; ?>
				<input type="hidden" name="id[]" id="id[]" value="<?= $model->id; ?>">
			</td>
			<td width="27%">
				<?php if($model->level == 1) { ?>
				<span class="minus-sign" id="rowid_<?= $model->id; ?>" onclick="turen.com.displayRows(<?= $model->id; ?>);">
					<?= $model->menuname?> <i class="fa fa-bars"></i>
				</span>
				<?php } else { ?>
					<?=str_repeat('<span class="blank"></span>', $model->level-1)?>
					<span class="sub-type"><?= $model->menuname?></span>
				<?php } ?>
			</td>
			<td width="20%"><?=$model->linkurl?></td>
			<td align="center">
				<a href="<?=Url::to(['quick-move', 'type' => Nav::ORDER_UP_TYPE, 'kid' => $model->id, 'pid' => $model->parentid, 'orderid' => $model->orderid])?>" class="left-arrow" title="提升排序"></a>
				<input type="text" name="orderid[]" id="orderid[]" class="inputls" value="<?= $model->orderid; ?>">
				<a href="<?=Url::to(['quick-move', 'type' => Nav::ORDER_DOWN_TYPE, 'kid' => $model->id, 'pid' => $model->parentid, 'orderid' => $model->orderid])?>" class="right-arrow" title="下降排序"></a>
			</td>
			<td width="25%" class="action end-column">
				<span><a href="<?= Url::to(['create', 'pid' => $model->id]) ?>">添加子菜单</a></span> | 
				<span><?=$checkstr?></span> | 
				<span><a href="<?= Url::to(['update', 'id' => $model->id]) ?>">编辑</a></span> | 
				<span class="nb"><?=$delstr?></span>
			</td>
    	</tr>
	</tbody>
    </table>
</div>
<?php } ?>
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
    	<a href="javascript:turen.com.batchSubmit('<?=Url::to(['batch', 'type' => 'delete'])?>', 'batchform');">删除</a> - 
    	<a href="javascript:turen.com.batchSubmit('<?=Url::to(['batch', 'type' => 'order'])?>', 'batchform');">排序</a> - 
    	<a href="javascript:turen.com.showAllRows();">展开</a> - 
    	<a href="javascript:turen.com.hideAllRows();">隐藏</a>
	</span>
	<?= Html::a('添加新菜单', ['create'], ['class' => 'data-btn']) ?>
</div>

<div class="quick-toolbar">
	<div class="qiuck-warp">
		<div class="quick-area">
			<span class="sel-area">
        		<span class="sel-name">选择：</span> 
        		<a href="javascript:turen.com.checkAll(true);">全选</a> - 
        		<a href="javascript:turen.com.checkAll(false);">反选</a>
        		<span class="op-name">操作：</span>
    			<a href="javascript:turen.com.batchSubmit('<?=Url::to(['batch', 'type' => 'delete'])?>', 'batchform');">删除</a> - 
        		<a href="javascript:turen.com.batchSubmit('<?=Url::to(['batch', 'type' => 'order'])?>', 'batchform');">排序</a> - 
        		<a href="javascript:turen.com.showAllRows();">展开</a> - 
        		<a href="javascript:turen.com.hideAllRows();">隐藏</a>
    		</span> 
			<?= Html::a('添加新菜单', ['create'], ['class' => 'data-btn']) ?>
			<div class="page-small">
    			<div class="page-text">共 <?=$dataProvider->getTotalCount()?> 条记录</div>
    		</div>
		</div>
		<div class="quick-area-bg"></div>
	</div>
</div>
<p class="cp tc"><?= Yii::$app->params['config_copyright'] ?></p>