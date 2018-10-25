<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\user\FavoriteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户收藏';
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
		<td width="18%">收藏对象</td>
		<td width="7%">附加数据</td>
		<td width="7%">用户</td>
		<td width="13%">当前链接</td>
		<td width="7%"><?= $dataProvider->sort->link('uf_star', ['label' => '星级']) ?></td>
		<td width="10%">IP</td>
		<td width="10%"><?= $dataProvider->sort->link('created_at', ['label' => '添加日期']) ?></td>
		<td width="25%" class="end-column">操作</td>
	</tr>
	<?php foreach ($dataProvider->getModels() as $key => $model) {
	    $options = [
	        'data-url' => Url::to(['delete', 'id' => $model->uf_id, 'returnUrl' => Url::current()]),
	        'onclick' => 'jwf.com.deleteItem(this, \''.$model->objectName.'\')',
	    ];
	    $delstr = Html::a('删除', 'javascript:;', $options);
    ?>
	<tr align="left" class="data-tr">
		<td  class="first-column">
			<input type="checkbox" name="checkid[]" id="checkid[]" value="<?= $model->uf_id; ?>">
		</td>
		<td><?= $model->uf_id; ?></td>
		<td><?= $model->objectName; ?></td>
		<td><?= $model->moreData; ?></td>
		<td><?= empty($model->user)?'未定义':$model->user->username; ?></td>
		<td><?= Html::a(StringHelper::truncate($model->uf_link, 18, '..'), $model->uf_link, ['target' => '_blank']); ?></td>
		<td><?= $model->uf_star; ?></td>
		<td><?= $model->uf_ip; ?></td>
		<td><?= Yii::$app->getFormatter()->asDate($model->created_at); ?></td>
		<td class="action end-column"><span><a href="javascript: alert('待开发');">发消息</a></span> | <span class="nb"><?= $delstr; ?></span></td>
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
		<span>选择：</span> 
    	<a href="javascript:jwf.com.checkAll(true);">全部</a> - 
    	<a href="javascript:jwf.com.checkAll(false);">无</a> - 
    	<a href="javascript:jwf.com.batchSubmit('<?=Url::to(['batch', 'type' => 'delete'])?>', 'batchform');">删除</a>　
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
        	<span>选择：</span> 
        	<a href="javascript:jwf.com.checkAll(true);">全部</a> - 
        	<a href="javascript:jwf.com.checkAll(false);">无</a> - 
        	<a href="javascript:jwf.com.batchSubmit('<?=Url::to(['batch', 'type' => 'delete'])?>', 'batchform');">删除</a> - 
        	<span class="total">共 <?= $dataProvider->getTotalCount() ?> 条记录</span>
    	</span>
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