<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel app\models\cms\InfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '单页信息管理';
?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="data-table">
	<tr align="left" class="head">
		<td width="4%" class="first-column">ID</td>
		<td width="40%">单页名称</td>
		<td width="40%">发布时间</td>
		<td class="end-column">操作</td>
	</tr>
	<?php foreach ($dataProvider->getModels() as $key => $model) { ?>
	<tr align="left" class="data-tr">
		<td  class="first-column"><?= $model->cid; ?></td>
		<td><?= $model->cname; ?></td>
		<td><?= Yii::$app->getFormatter()->asDate($model->posttime);; ?></td>
		<td class="action end-column"><span><a href="<?= Url::to(['update', 'id' => $model->cid]) ?>">修改</a></span></td>
	</tr>
	<?php } ?>
</table>
<?php //判断无记录样式
if(empty($dataProvider->count))
{
	echo '<div class="data-empty">暂时没有相关的记录</div>';
}
?>

<div class="bottom-toolbar"> <a href="<?= Url::to(['column/index'])?>" class="data-btn">返回栏目管理</a> </div>

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

