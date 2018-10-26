<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use app\models\sys\MultilangTpl;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\sys\MultilangTplSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '多语言管理';
?>

<?= $this->render('_search', ['model' => $searchModel]); ?>

<?php $form = ActiveForm::begin([
    'enableClientScript' => false,
    'options' => ['id' => 'batchform'],
]); ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="data-table">
	<tr align="left" class="head">
		<td width="4%"  class="first-column"><input type="checkbox" name="checkid" id="checkid" onclick="turen.com.checkAll(this.checked);"></td>
		<td width="4%">ID</td>
		<td width="10%"><?= $dataProvider->sort->link('lang_name', ['label' => '多语言站名']) ?></td>
		<td width="13%">指定模板</td>
		<td width="6%"><?= $dataProvider->sort->link('lang', ['label' => '语言包']) ?></td>
		<td width="6%"><?= $dataProvider->sort->link('key', ['label' => 'Url Key']) ?></td>
		<td width="7%"><?= $dataProvider->sort->link('back_defautl', ['label' => '后台默认']) ?></td>
		<td width="7%"><?= $dataProvider->sort->link('front_default', ['label' => '前台默认']) ?></td>
		<td width="10%" align="center"><?= $dataProvider->sort->link('orderid', ['label' => '排序']) ?></td>
		<td width="25%" class="end-column">操作</td>
	</tr>
	<?php foreach ($dataProvider->getModels() as $key => $model) {
	    $options = [
	        'title' => '点击进行控制前台显示和隐藏',
	        'data-url' => Url::to(['check', 'id' => $model->id]),
	        'onclick' => 'turen.com.updateStatus(this)',
	    ];
	    $checkstr = Html::a(($model->is_visible?'前台显示':'前台隐藏'), 'javascript:;', $options);
	    
		$options = [
    		'data-url' => Url::to(['delete', 'id' => $model->id, 'returnUrl' => Url::current()]),
		    'onclick' => 'turen.com.deleteItem(this, \''.$model->lang_name.'\')',
		];
		$delstr = Html::a('删除', 'javascript:;', $options);
	?>
	<tr align="left" class="data-tr">
		<td  class="first-column">
			<input type="checkbox" name="checkid[]" id="checkid[]" value="<?= $model->id; ?>">
		</td>
		<td><?= $model->id; ?></td>
		<td><?= $model->lang_name; ?></td>
		<td><?= isset($model->template)?$model->template->temp_name:'未定义'; ?></td>
		<td><?= $model->lang; ?></td>
		<td><?= $model->key; ?></td>
		<td><?= $model->back_defautl?'<span class="badge badge-success">是</span>':'<span class="badge">否</span>'; ?></td>
		<td><?= $model->front_default?'<span class="badge badge-success">是</span>':'<span class="badge">否</span>'; ?></td>
		<td align="center">
			<a href="<?=Url::to(['simple-move', 'type' => MultilangTpl::ORDER_UP_TYPE, 'id' => $model->id, 'orderid' => $model->orderid])?>" class="left-arrow" title="提升排序"></a>
			<input type="text" name="orderid[]" id="orderid[]" class="inputls" value="<?= $model->orderid; ?>">
			<a href="<?=Url::to(['simple-move', 'type' => MultilangTpl::ORDER_DOWN_TYPE, 'id' => $model->id, 'orderid' => $model->orderid])?>" class="right-arrow" title="下降排序"></a>
		</td>
		<td class="action end-column"><span><?= $checkstr ?></span> | <span><a href="<?= Url::to(['update', 'id' => $model->id]) ?>">修改</a></span> | <span class="nb"><?= $delstr; ?></span></td>
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
	<span class="sel-area"><span>选择：</span>
    	<a href="javascript:turen.com.checkAll(true);">全选</a> - 
    	<a href="javascript:turen.com.checkAll(false);">反选</a>
    	<a href="javascript:turen.com.batchSubmit('<?=Url::to(['batch', 'type' => 'order'])?>', 'batchform');">排序</a>
	</span>
	<?= Html::a('添加新语言站', ['create'], ['class' => 'data-btn']) ?>
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
				<a href="javascript:turen.com.batchSubmit('<?=Url::to(['batch', 'type' => 'order'])?>', 'batchform');">排序</a> - 
				<span class="total">共 <?= $dataProvider->getTotalCount() ?> 条记录</span>
			</span>
			<?= Html::a('添加新语言站', ['create'], ['class' => 'data-btn']) ?>
			<span class="page-small">
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
			</span>
		</div>
		<div class="quick-area-bg"></div>
	</div>
</div>
<p class="cp tc"><?= Yii::$app->params['config_copyright'] ?></p>