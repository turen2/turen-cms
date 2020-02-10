<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\widgets\ActiveForm;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use backend\widgets\edititem\EditItemWidget;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\user\FeedbackSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '反馈列表';
?>

<?= $this->render('_search', ['model' => $searchModel]); ?>

<?php $form = ActiveForm::begin([
    'enableClientScript' => false,
    'options' => ['id' => 'batchform'],
]); ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="data-table">
	<tr align="left" class="head">
        <td width="4%" class="first-column"><input type="checkbox" name="checkid" id="checkid" onclick="turen.com.checkAll(this.checked);"></td>
		<td width="4%"><?= $dataProvider->sort->link('fk_id', ['label' => $searchModel->getAttributeLabel('fk_id')]) ?></td>
        <td width="13%"><?= $searchModel->getAttributeLabel('fk_nickname') ?></td>
        <td width="8%"><?= $searchModel->getAttributeLabel('fk_contact') ?></td>
        <td width="20%"><?= $searchModel->getAttributeLabel('fk_content') ?></td>
        <td width="6%"><?= $dataProvider->sort->link('fk_show', ['label' => $searchModel->getAttributeLabel('fk_show')]) ?></td>
        <td width="8%">通知情况</td>
        <td width="6%"><?= $searchModel->getAttributeLabel('fk_type_id') ?></td>
        <td width="4%"><?= $dataProvider->sort->link('orderid', ['label' => $searchModel->getAttributeLabel('orderid')]) ?></td>
        <td width="10%"><?= $dataProvider->sort->link('fk_retime', ['label' => $searchModel->getAttributeLabel('fk_retime')]) ?></td>
		<td width="10%"><?= $dataProvider->sort->link('created_at', ['label' => $searchModel->getAttributeLabel('created_at')]) ?></td>
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
        <td class="first-column">
            <input type="checkbox" name="checkid[]" id="checkid[]" value="<?= $model->fk_id; ?>">
        </td>
        <td><?= $model->fk_id; ?></td>
        <td><?= $model->fk_nickname; ?><?= $model->user?'<br />[关联:'.Html::a($model->user->username, ['/user/user/index', 'UserSearch[user_id]' => $model->user->user_id]).']':''; ?></td>
        <td><?= $model->fk_contact; ?></td>
        <td><?= StringHelper::truncateWords($model->fk_content, 16, '...'); ?></td>
        <td><?= $model->fk_show?'是':'否'; ?></td>
        <td><?= '邮件:'.($model->fk_email?'是':'否'); ?> / <?= '短信:'.($model->fk_sms?'是':'否'); ?></td>
        <td><?= empty($model->feedbackType)?'未设置':('表单：'.$model->feedbackType->fkt_form_name.'<br />'.'列表：'.$model->feedbackType->fkt_list_name); ?></td>
        <td><?= EditItemWidget::widget([
                'model' => $model,
                'primaryKey' => 'fk_id',
                'attribute' => 'orderid',
                'url' => Url::to(['/user/feedback/edit-item']),
                'options' => [],
            ]); ?></td>
        <td><?= empty($model->fk_retime)?'未回复':Yii::$app->getFormatter()->asDate($model->fk_retime); ?></td>
		<td><?= Yii::$app->getFormatter()->asDate($model->created_at); ?></td>
		<td class="action end-column"><span><a href="<?= Url::to(['update', 'id' => $model->fk_id]) ?>">修改</a></span> | <span class="nb"><?= $delstr; ?></span></td>
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
    	<a href="javascript:turen.com.batchSubmit('<?=Url::to(['batch', 'type' => 'delete'])?>', 'batchform');">删除</a>
	</span>
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
            	<span class="sel-name">选择：</span>
            	<a href="javascript:turen.com.checkAll(true);">全选</a> -
            	<a href="javascript:turen.com.checkAll(false);">反选</a>
            	<span class="op-name">操作：</span>
            	<a href="javascript:turen.com.batchSubmit('<?= Url::to(['batch', 'type' => 'delete'])?>', 'batchform');">删除</a>
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

