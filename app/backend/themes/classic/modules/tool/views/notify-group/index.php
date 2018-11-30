<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel app\models\tool\NotifyGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '消息队列';
?>

<?= $this->render('_search', ['model' => $searchModel]); ?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="data-table">
	<tr align="left" class="head">
		<td width="20%" class="first-column"><?= $dataProvider->sort->link('ng_title', ['label' => '标题']) ?></td>
		<td width="18%"><?= $dataProvider->sort->link('ng_nc_id', ['label' => '关联内容']) ?></td>
		<td width="10%">信息载体</td>
		<td width="6%"><?= $dataProvider->sort->link('ng_count', ['label' => '待发量']) ?></td>
		<td width="6%"><?= $dataProvider->sort->link('ng_send_count', ['label' => '已发量']) ?></td>
		<td width="19%"><?= $dataProvider->sort->link('ng_clock_time', ['label' => '定时发送']) ?></td>
		<td width="25%" class="end-column"><?= $dataProvider->sort->link('ng_status', ['label' => '操作']) ?></td>
	</tr>
	<?php foreach ($dataProvider->getModels() as $key => $model) {
		$options = [
	        'title' => '点击进行发送和暂停操作',
	        'data-url' => Url::to(['check', 'id' => $model->ng_id]),
	        'onclick' => 'turen.com.updateStatus(this)',
        ];
		$checkstr = Html::a(($model->ng_status?'启用':'禁用'), 'javascript:;', $options);
		
		$options = [
    		'data-url' => Url::to(['delete', 'id' => $model->ng_id, 'returnUrl' => Url::current()]),
		    'onclick' => 'turen.com.deleteItem(this, \''.$model->ng_title.'\')',
		];
		$delstr = Html::a('删除', 'javascript:;', $options);
	?>
	<tr align="left" class="data-tr">
		<td class="first-column font-14i"><?= $model->sendStatus() ?> <?= $model->ng_title ?> <br /><a href="<?= Url::to(['/tool/notify-queue/index', 'NotifyQueueSearch[nq_ng_id]' => $model->ng_id]) ?>">[查看详情]</a></td>
		<td><?= empty($model->notifyContent)?'未定义':$model->notifyContent->nc_title; ?></td>
		<td>短信 邮件 站内</td>
		<td><?= $model->ng_count?></td>
		<td><?= $model->ng_send_count?></td>
		<td><?= empty($model->ng_clock_time)?'未定义时间':Yii::$app->getFormatter()->asDatetime($model->ng_clock_time)?></td>
		<td class="action end-column"><span><?= $checkstr; ?></span> | <span><a href="<?= Url::to(['update', 'id' => $model->ng_id]) ?>">修改</a></span> | <span class="nb"><?= $delstr; ?></span></td>
	</tr>
	<?php } ?>
</table>
<?php //判断无记录样式
if(empty($dataProvider->count))
{
	echo '<div class="data-empty">暂时没有相关的记录</div>';
}
?>

<div class="bottom-toolbar clearfix">
	<?= Html::a('添加新队列', ['create'], ['class' => 'data-btn']) ?>
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
				<span class="total">共 <?= $dataProvider->getTotalCount() ?> 条记录</span>
			</span>
			<?= Html::a('添加新队列', ['create'], ['class' => 'data-btn']) ?>
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

