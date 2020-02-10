<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;
use backend\models\cms\Flag;
use backend\models\cms\Column;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\cms\FlagSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '标记管理';
$this->topFilter = $this->render('_filter', ['model' => $searchModel]);
?>

<?php // $this->render('_search', ['model' => $searchModel]); ?>

<?php $form = ActiveForm::begin([
    'enableClientScript' => false,
    'options' => ['id' => 'batchform'],
]); ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="data-table">
	<tr align="left" class="head">
		<td width="4%" class="first-column"><input type="checkbox" name="checkid" id="checkid" onclick="turen.com.checkAll(this.checked);"></td>
		<td width="4%">ID</td>
		<td width="6%"><?= $dataProvider->sort->link('flagname', ['label' => '标记名']) ?></td>
		<td width="4%"><?= $dataProvider->sort->link('flag', ['label' => '标记值']) ?></td>
		<td width="5%">所属类型</td>
		<td width="6%" align="center"><?= $dataProvider->sort->link('orderid', ['label' => '排序']) ?></td>
		<td width="10%"><?= $dataProvider->sort->link('updated_at', ['label' => '更新日期']) ?></td>
		<td width="25%" class="end-column">操作</td>
	</tr>
	<?php foreach ($dataProvider->getModels() as $key => $model) {
		$options = [
	        'title' => '点击进行显示和隐藏操作',
	        'data-url' => Url::to(['check', 'kid' => $model->id]),
	        'onclick' => 'turen.com.updateStatus(this)',
        ];
		
		$options = [
    		'data-url' => Url::to(['delete', 'id' => $model->id, 'returnUrl' => Url::current()]),
		    'onclick' => 'turen.com.deleteItem(this, \''.$model->flagname.'\')',
		];
		$delstr = Html::a('删除', 'javascript:;', $options);
	?>
	<tr align="left" class="data-tr">
		<td class="first-column">
			<input type="checkbox" name="checkid[]" id="checkid[]" value="<?= $model->id; ?>">
		</td>
		<td><?= $model->id; ?>
			<input type="hidden" name="id[]" id="id[]" value="<?= $model->id; ?>">
		</td>
		<td><?= $model->flagname; ?></td>
		<td><?= $model->flag; ?></td>
		<td><?= Column::ColumnConvert('id2name', $model->type, '未定义'); ?></td>
		<td align="center">
			<a href="<?=Url::to(['quick-move', 'type' => Flag::ORDER_UP_TYPE, 'kid' => $model->id, 'orderid' => $model->orderid])?>" class="left-arrow" title="提升排序"></a>
			<input type="text" name="orderid[]" id="orderid[]" class="inputls" value="<?= $model->orderid; ?>">
			<a href="<?=Url::to(['quick-move', 'type' => Flag::ORDER_DOWN_TYPE, 'kid' => $model->id, 'orderid' => $model->orderid])?>" class="right-arrow" title="下降排序"></a>
		</td>
		<td><?= Yii::$app->getFormatter()->asDate($model->updated_at); ?></td>
		<td class="action end-column"><span><a href="<?= Url::to(['update', 'id' => $model->id]) ?>">修改</a></span> | <span class="nb"><?= $delstr; ?></span></td>
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
    	<a href="javascript:turen.com.batchSubmit('<?=Url::to(['batch', 'type' => 'delete'])?>', 'batchform');">删除</a> - 
		<a href="javascript:turen.com.batchSubmit('<?=Url::to(['batch', 'type' => 'order'])?>', 'batchform');">排序</a>
	</span>
	<?= Html::a('添加新标记', ['create'], ['class' => 'data-btn']) ?>
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
    			<a href="javascript:turen.com.batchSubmit('<?=Url::to(['batch', 'type' => 'delete'])?>', 'batchform');">删除</a> - 
        		<a href="javascript:turen.com.batchSubmit('<?=Url::to(['batch', 'type' => 'order'])?>', 'batchform');">排序</a> - 
        		<span class="total">共 <?= $dataProvider->getTotalCount() ?> 条记录</span>
        	</span>
			<?= Html::a('添加新标记', ['create'], ['class' => 'data-btn']) ?>
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