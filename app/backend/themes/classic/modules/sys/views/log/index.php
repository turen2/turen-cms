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
use app\models\sys\Log;

/* @var $this yii\web\View */
/* @var $searchModel app\models\sys\LogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '操作日志';

$model = new Log();
?>

<?= $this->render('_search', ['model' => $searchModel]); ?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="data-table">
	<tr align="left" class="head">
		<td width="4%" class="first-column">ID</td>
		<td width="5%"><?= $dataProvider->sort->link('username', ['label' => $model->getAttributeLabel('username')]) ?></td>
		<td width="7%"><?= $model->getAttributeLabel('route')?></td>
		<td width="10%"><?= $model->getAttributeLabel('name')?></td>
		<td width="5%"><?= $dataProvider->sort->link('method', ['label' => $model->getAttributeLabel('method')]) ?></td>
		<td width="7%"><?= $model->getAttributeLabel('ip')?></td>
		<td width="18%"><?= $model->getAttributeLabel('agent')?></td>
		<td width="13%"><?= $dataProvider->sort->link('created_at', ['label' => $model->getAttributeLabel('created_at')]) ?></td>
		<td width="25%" class="end-column">操作</td>
	</tr>
	<?php foreach ($dataProvider->getModels() as $key => $model) { ?>
	<tr align="left" class="data-tr">
		<td class="first-column"><?= $model->log_id; ?></td>
		<td><?= $model->username; ?></td>
		<td><?= $model->route; ?></td>
		<td><?= $model->name; ?></td>
		<td><?= $model->method; ?></td>
		<td><?= $model->ip; ?></td>
		<td><?= $model->agent; ?></td>
		<td><?= Yii::$app->getFormatter()->asDatetime($model->created_at); ?></td>
		<td class="action end-column"><span><a href="<?= Url::to(['view', 'id' => $model->log_id]) ?>">详情</a></span></td>
	</tr>
	<?php } ?>
</table>
<?php //判断无记录样式
if(empty($dataProvider->count))
{
	echo '<div class="data-empty">暂时没有相关的记录</div>';
}
?>

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
<p class="cp tc"><?= Yii::$app->params['config_copyright'] ?></p>