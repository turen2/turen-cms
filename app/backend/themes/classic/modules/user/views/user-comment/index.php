<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use app\components\ActiveRecord;
use app\models\cms\Column;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\user\UserCommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '评论列表';
?>

<?= $this->render('_search', ['model' => $searchModel]); ?>

<?php $form = ActiveForm::begin([
    'enableClientScript' => false,
    'options' => ['id' => 'batchform'],
]); ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="data-table">
	<tr align="left" class="head">
		<td width="4%" class="first-column"><input type="checkbox" name="checkid" id="checkid" onclick="jwf.com.checkAll(this.checked);"></td>
		<td width="4%">ID</td>
		<td width="30%"><?= $dataProvider->sort->link('uc_note', ['label' => '评论内容']) ?></td>
		<td width="5%">类型</td>
		<td width="15%">评论对象</td>
		<td width="6%"><?= $dataProvider->sort->link('username', ['label' => '用户名']) ?></td>
		<td width="7%">IP</td>
		<td width="10%"><?= $dataProvider->sort->link('created_at', ['label' => '评论日期']) ?></td>
		<td width="25%" class="end-column">操作</td>
	</tr>
	<?php foreach ($dataProvider->getModels() as $key => $model) {
		$options = [
	        'title' => '点击进行显示和隐藏操作',
	        'data-url' => Url::to(['check', 'id' => $model->uc_id]),
	        'onclick' => 'jwf.com.updateStatus(this)',
        ];
		$checkstr = Html::a(($model->status?'显示':'隐藏'), 'javascript:;', $options);
		
		$options = [
    		'data-url' => Url::to(['delete', 'id' => $model->uc_id, 'returnUrl' => Url::current()]),
		    'onclick' => 'jwf.com.deleteItem(this, \'评论ID为'.$model->uc_id.'\')',
		];
		$delstr = Html::a('删除', 'javascript:;', $options);
	?>
	<tr align="left" class="data-tr">
		<td  class="first-column">
			<input type="checkbox" name="checkid[]" id="checkid[]" value="<?= $model->uc_id; ?>">
		</td>
		<td><?= $model->uc_id; ?></td>
		<td><?= ($model->uc_pid == ActiveRecord::DEFAULT_NULL)?$model->uc_note:$model->uc_reply; ?></td>
		<td><?= ($model->uc_pid == ActiveRecord::DEFAULT_NULL)?'主评':'回评'; ?></td>
		<td><?= $model->objectLink(); ?></td>
		<td><?= $model->username; ?></td>
		<td><?= $model->uc_ip; ?></td>
		<td><?= Yii::$app->getFormatter()->asDate($model->created_at); ?></td>
		<td class="action end-column"><span><?= $checkstr; ?></span> | <span><a href="<?= Url::to(['update', 'id' => $model->uc_id]) ?>">修改</a></span> | <span class="nb"><?= $delstr; ?></span></td>
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

<div class="bottom-toolbar">
	<span class="sel-area">
    	<span>选择：</span> 
    	<a href="javascript:jwf.com.checkAll(true);">全部</a> - 
    	<a href="javascript:jwf.com.checkAll(false);">无</a> - 
    	<a href="javascript:jwf.com.batchSubmit('<?=Url::to(['batch', 'type' => 'delete'])?>', 'batchform');">删除</a>　
	</span>
	<?= Html::a('添加新评论', ['create'], ['class' => 'data-btn']) ?>
</div>

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

<div class="quick-toolbar">
	<div class="qiuck-warp">
		<div class="quick-area">
    		<span class="sel-area">
        	<span>选择：</span> 
        	<a href="javascript:jwf.com.checkAll(true);">全部</a> - 
        	<a href="javascript:jwf.com.checkAll(false);">无</a> - 
        	<a href="javascript:jwf.com.batchSubmit('<?=Url::to(['batch', 'type' => 'delete'])?>', 'batchform');">删除</a>　
    	</span>
			<?= Html::a('添加新评论', ['create'], ['class' => 'data-btn']) ?>
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