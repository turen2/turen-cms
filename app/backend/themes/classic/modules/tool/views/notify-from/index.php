<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel app\models\tool\NotifyFromSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '来源列表';
?>

<?= $this->render('_search', ['model' => $searchModel]); ?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="data-table">
	<tr align="left" class="head">
		<td width="4%" class="first-column">ID</td>
		<td width="10%"><?= $dataProvider->sort->link('fr_title', ['label' => '来源名称']) ?></td>
		<td width="18%"><?= $dataProvider->sort->link('fr_comment', ['label' => '备注']) ?></td>
		<td width="25%" class="end-column">操作</td>
	</tr>
	<?php foreach ($dataProvider->getModels() as $key => $model) {
		$options = [
    		'data-url' => Url::to(['delete', 'id' => $model->fr_id, 'returnUrl' => Url::current()]),
		    'onclick' => 'turen.com.deleteItem(this, \''.$model->fr_title.'\')',
		];
		$delstr = Html::a('删除', 'javascript:;', $options);
		
		$options = [
		    'data-method' => 'post',
		];
		$url = Url::to(['set-default', 'id' => $model->fr_id, 'returnUrl' => Url::current()]);
		$default = ($model->fr_is_default)?Html::a('默认', 'javascript:;'):Html::a('设为默认', $url, $options);
	?>
	<tr align="left" class="data-tr">
		<td class="first-column"><?= $model->fr_id; ?></td>
		<td><?= $model->fr_title; ?></td>
		<td><?= $model->fr_comment; ?></td>
		<td class="action end-column"><?=$default?> | <span><a href="<?= Url::to(['update', 'id' => $model->fr_id]) ?>">修改</a></span> | <span class="nb"><?= $delstr; ?></span></td>
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
	<?= Html::a('添加新来源', ['create'], ['class' => 'data-btn']) ?>
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
			<?= Html::a('添加新来源', ['create'], ['class' => 'data-btn']) ?>
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

