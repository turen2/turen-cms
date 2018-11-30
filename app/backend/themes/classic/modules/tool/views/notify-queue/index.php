<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel app\models\tool\NotifyQueueSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '队列详情';
?>

<?= $this->render('_search', ['model' => $searchModel]); ?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="data-table">
	<tr align="left" class="head">
		<td width="3%" class="first-column"><?= $dataProvider->sort->link('nq_id', ['label' => 'ID']) ?></td>
		<td width="6%">用户名</td>
		<td width="10%">所属队列</td>
		<td width="6%"><?= $dataProvider->sort->link('nq_is_notify', ['label' => '站内信']) ?></td>
		<td width="5%"><?= $dataProvider->sort->link('nq_is_email', ['label' => '邮件']) ?></td>
		<td width="5%"><?= $dataProvider->sort->link('nq_is_sms', ['label' => '短信']) ?></td>
		<td width="9%"><?= $dataProvider->sort->link('nq_notify_send_time', ['label' => '站内发送时间']) ?></td>
		<td width="9%"><?= $dataProvider->sort->link('nq_notify_arrive_time', ['label' => '站内到达时间']) ?></td>
		<td width="9%"><?= $dataProvider->sort->link('nq_email_send_time', ['label' => '邮件发送时间']) ?></td>
		<td width="9%"><?= $dataProvider->sort->link('nq_email_send_time', ['label' => '邮件到达时间']) ?></td>
		<td width="9%"><?= $dataProvider->sort->link('nq_sms_send_time', ['label' => '短信发送时间']) ?></td>
		<td width="9%"><?= $dataProvider->sort->link('nq_sms_arrive_time', ['label' => '短信到达时间']) ?></td>
		<td width="25%" class="end-column">操作</td>
	</tr>
	<?php foreach ($dataProvider->getModels() as $key => $model) {
		$options = [
	        'title' => '点击进行显示和隐藏操作',
	        'data-url' => Url::to(['check', 'id' => $model->nq_id]),
	        'onclick' => 'turen.com.updateStatus(this)',
        ];
		$checkstr = Html::a(($model->nq_status?'启用':'禁用'), 'javascript:;', $options);
		
		$options = [
    		'data-url' => Url::to(['delete', 'id' => $model->nq_id, 'returnUrl' => Url::current()]),
		    'onclick' => 'turen.com.deleteItem(this, \''.$model->nq_id.'\')',
		];
		$delstr = Html::a('删除', 'javascript:;', $options);
	?>
	<tr align="left" class="data-tr">
		<td class="first-column"><?= $model->nq_id; ?></td>
		<td><?= empty($model->notifyUser)?'未定义':$model->notifyUser->nu_username; ?></td>
		<td><?= empty($model->notifyGroup)?'未定义':$model->notifyGroup->ng_title; ?></td>
		<td><?= $model->nq_is_notify?'<i class="fa fa-check-square-o"></i>':'<i class="fa fa-minus-circle"></i>'; ?></td>
		<td><?= $model->nq_is_email?'<i class="fa fa-check-square-o"></i>':'<i class="fa fa-minus-circle"></i>'; ?></td>
		<td><?= $model->nq_is_sms?'<i class="fa fa-check-square-o"></i>':'<i class="fa fa-minus-circle"></i>'; ?></td>
		<td><?= Yii::$app->getFormatter()->asDate($model->nq_notify_send_time); ?><br /><?= Yii::$app->getFormatter()->asTime($model->nq_notify_send_time); ?></td>
		<td><?= (empty($model->nq_notify_arrive_time)?'未达':Yii::$app->getFormatter()->asDate($model->nq_notify_arrive_time).'<br />'.Yii::$app->getFormatter()->asTime($model->nq_notify_arrive_time)); ?></td>
		<td><?= Yii::$app->getFormatter()->asDate($model->nq_email_send_time); ?><br /><?= Yii::$app->getFormatter()->asTime($model->nq_email_send_time); ?></td>
		<td><?= empty($model->nq_email_arrive_time)?'未达':Yii::$app->getFormatter()->asDate($model->nq_email_arrive_time).'<br />'.Yii::$app->getFormatter()->asTime($model->nq_email_arrive_time); ?></td>
		<td><?= Yii::$app->getFormatter()->asDate($model->nq_sms_send_time); ?><br /><?= Yii::$app->getFormatter()->asTime($model->nq_sms_send_time); ?></td>
		<td><?= empty($model->nq_sms_arrive_time)?'未达':Yii::$app->getFormatter()->asDate($model->nq_sms_arrive_time).'<br />'.Yii::$app->getFormatter()->asTime($model->nq_sms_arrive_time); ?></td>
		<td class="action end-column"><span><?= $checkstr; ?></span> | <span><a href="<?= Url::to(['update', 'id' => $model->nq_id]) ?>">修改</a></span> | <span class="nb"><?= $delstr; ?></span></td>
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

