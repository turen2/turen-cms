<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;
use app\models\tool\NotifyGroup;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\tool\NotifyUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '会员列表';
?>

<?= $this->render('_search', ['model' => $searchModel]); ?>

<?php $form = ActiveForm::begin([
    'enableClientScript' => false,
    'options' => ['id' => 'batchform'],
]); ?>
<div style="overflow-x: auto;">
    <table width="" border="0" cellpadding="0" cellspacing="0" class="data-table">
    	<tr align="left" class="head">
    		<td class="first-column"><div class="w20"><input type="checkbox" name="checkid" id="checkid" onclick="turen.com.checkAll(this.checked);"></div></td>
    		<td><div class="w80"><?= $dataProvider->sort->link('nu_username', ['label' => '用户名']) ?></div></td>
    		<td><div class="w80"><?= $dataProvider->sort->link('nu_realname', ['label' => '真实姓名']) ?></div></td>
    		<td><div class="w100"><?= $dataProvider->sort->link('nu_phone', ['label' => '手机号']) ?></div></td>
    		<td><div class="w120"><?= $dataProvider->sort->link('nu_email', ['label' => '邮箱']) ?></div></td>
    		<td><div class="w100"><?= $dataProvider->sort->link('nu_order_total', ['label' => '订单总额']) ?></div></td>
    		<td><div class="w60"><?= $dataProvider->sort->link('nu_star', ['label' => '星级']) ?></div></td>
    		<td><div class="w180">地址</div></td>
    		<td><div class="w100">可以发送</div></td>
    		<td><div class="w120"><?= $dataProvider->sort->link('nu_reg_time', ['label' => '注册时间']) ?></div></td>
    		<td><div class="w120"><?= $dataProvider->sort->link('nu_last_login_time', ['label' => '登录时间']) ?></div></td>
    		<td><div class="w120"><?= $dataProvider->sort->link('nu_last_order_time', ['label' => '下单时间']) ?></div></td>
    		<td><div class="w120"><?= $dataProvider->sort->link('nu_last_send_time', ['label' => '发送时间']) ?></div></td>
    		<td><div class="w120"><?= $dataProvider->sort->link('created_at', ['label' => '添加日期']) ?></div></td>
    		<td class="end-column"><div class="w80">操作</div></td>
    	</tr>
    	<?php foreach ($dataProvider->getModels() as $key => $model) {
    		$options = [
        		'data-url' => Url::to(['delete', 'id' => $model->nu_id, 'returnUrl' => Url::current()]),
    		    'onclick' => 'turen.com.deleteItem(this, \''.$model->nu_username.'\')',
    		];
    		$delstr = Html::a('删除', 'javascript:;', $options);
    	?>
    	<tr align="left" class="data-tr">
			<td  class="first-column">
    			<input type="checkbox" name="checkid[]" id="checkid[]" value="<?= $model->nu_id; ?>">
    		</td>
    		<td><?= $model->nu_username; ?></td>
    		<td><?= $model->nu_realname; ?></td>
    		<td><?= $model->nu_phone; ?></td>
    		<td><?= $model->nu_email; ?></td>
    		<td><?= Yii::$app->getFormatter()->asCurrency($model->nu_order_total); ?></td>
    		<td><?= str_repeat('<i class="fa fa-star"></i>', $model->nu_star).str_repeat('<i class="fa fa-star-o"></i>', (5-$model->nu_star)); ?></td>
    		<td><?= $model->nu_province.' '.$model->nu_city.' '.$model->nu_area; ?></td>
    		<td>
    			<div>短信 <?= $model->nu_is_sms_white?'是':'<span style="color:red;">否</span>'; ?></div>
        		<div>站内 <?= $model->nu_is_notify_white?'是':'<span style="color:red;">否</span>'; ?></div>
        		<div>邮件 <?= $model->nu_is_email_white?'是':'<span style="color:red;">否</span>'; ?></div>
    		</td>
    		<td><?= Yii::$app->getFormatter()->asDate($model->nu_reg_time); ?><br /><?= Yii::$app->getFormatter()->asTime($model->nu_reg_time); ?></td>
    		<td><?= Yii::$app->getFormatter()->asDate($model->nu_last_login_time); ?><br /><?= Yii::$app->getFormatter()->asTime($model->nu_last_login_time); ?></td>
    		<td><?= Yii::$app->getFormatter()->asDate($model->nu_last_order_time); ?><br /><?= Yii::$app->getFormatter()->asTime($model->nu_last_order_time); ?></td>
    		<td><?= Yii::$app->getFormatter()->asDate($model->nu_last_send_time); ?><br /><?= Yii::$app->getFormatter()->asTime($model->nu_last_send_time); ?></td>
    		<td><?= Yii::$app->getFormatter()->asDate($model->created_at); ?><br /><?= Yii::$app->getFormatter()->asTime($model->created_at); ?></td>
    		<td class="action end-column"><span><a href="<?= Url::to(['update', 'id' => $model->nu_id]) ?>">修改</a></span> | <span class="nb"><?= $delstr; ?></span></td>
    	</tr>
    	<?php } ?>
    </table>
</div>
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
		<span class="total">共 <?= $dataProvider->getTotalCount() ?> 条记录</span>
	</span>
	<span class="sel-area" style="top: 25px;">
    	<span class="op-name" style="margin-left: 0;">队列：</span>
		<span class="op-queue">
			<?= Html::dropDownList('type', 'filtered', ['selected' => '当前选中', '"filtered"' => '当前过滤']) ?>
			<?= Html::dropDownList('notify_group_id', null, ArrayHelper::map(NotifyGroup::find()->all(), 'ng_id', 'ng_title')) ?> 
			<a class="op-btn" href="javascript:;" onclick="alert('dddd');">确认</a>
		</span>
	</span>
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
            	<span class="op-name">队列：</span>
    			<span class="op-queue">
        			<?= Html::dropDownList('type', 'filtered', ['selected' => '当前选中', '"filtered"' => '当前过滤']) ?>
        			<?= Html::dropDownList('notify_group_id', null, ArrayHelper::map(NotifyGroup::find()->all(), 'ng_id', 'ng_title')) ?> 
					<a class="op-btn" href="javascript:;" onclick="alert('dddd');">确认</a>
    			</span>
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

