<?php

use app\widgets\edititem\EditItemWidget;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel app\models\user\FeedbackSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '反馈列表';
?>

<?= $this->render('_search', ['model' => $searchModel]); ?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="data-table">
	<tr align="left" class="head">
		<td width="4%" class="first-column"><?= $dataProvider->sort->link('fk_id', ['label' => 'ID']) ?></td>
        <td width="8%">用户昵称</td>
        <td width="8%">联系方式</td>
        <td width="20%">留言内容</td>
        <td width="6%"><?= $dataProvider->sort->link('fk_show', ['label' => '在前台置顶']) ?></td>
        <td width="8%">通知情况</td>
        <td width="6%">反馈类型</td>
        <td width="4%"><?= $dataProvider->sort->link('orderid', ['label' => '排序']) ?></td>
        <td width="10%"><?= $dataProvider->sort->link('fk_retime', ['label' => '回复时间']) ?></td>
		<td width="10%"><?= $dataProvider->sort->link('created_at', ['label' => '提交时间']) ?></td>
		<td width="10%" class="end-column">操作</td>
	</tr>
	<?php foreach ($dataProvider->getModels() as $key => $model) {
		$options = [
    		'data-url' => Url::to(['delete', 'id' => $model->fk_id, 'returnUrl' => Url::current()]),
		    'onclick' => 'turen.com.deleteItem(this, \''.$model->fk_nickname.'\')',
		];
		$delstr = Html::a('删除', 'javascript:;', $options);
	?>
	<tr align="left" class="data-tr">
		<td class="first-column"><?= $model->fk_id; ?></td>
        <td><?= $model->fk_nickname; ?>[<?= $model->fk_user_id; ?>]</td>
        <td><?= $model->fk_contact; ?></td>
        <td><?= StringHelper::truncateWords($model->fk_content, 16, '...'); ?></td>
        <td><?= $model->fk_show?'是':'否'; ?></td>
        <td><?= '邮件:'.($model->fk_email?'是':'否'); ?> / <?= '短信:'.($model->fk_sms?'是':'否'); ?></td>
        <td><?= $model->fk_type_id; ?></td>
        <td><?= EditItemWidget::widget([
                'model' => $model,
                'primaryKey' => 'fk_id',
                'attribute' => 'orderid',
                'url' => Url::to(['/user/feedback/edit-item']),
                'options' => [],
            ]); ?></td>
        <td><?= Yii::$app->getFormatter()->asDate($model->fk_retime); ?></td>
		<td><?= Yii::$app->getFormatter()->asDate($model->created_at); ?></td>
		<td class="action end-column"><span><a href="<?= Url::to(['update', 'id' => $model->fk_id]) ?>">修改</a></span> | <span class="nb"><?= $delstr; ?></span></td>
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
	<?= Html::a('添加新反馈', ['create'], ['class' => 'data-btn']) ?>
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
			<?= Html::a('添加新反馈', ['create'], ['class' => 'data-btn']) ?>
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

