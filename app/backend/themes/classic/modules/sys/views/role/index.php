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
/* @var $searchModel app\models\sys\RoleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '角色管理';
?>

<?php // $this->render('_search', ['model' => $searchModel]); ?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="data-table">
	<tr align="left" class="head">
		<td width="4%" class="first-column">ID</td>
		<td width="15%"><?= $dataProvider->sort->link('role_name', ['label' => '角色名']) ?></td>
		<td width="20%">描述</td>
		<td width="25%" class="end-column">操作</td>
	</tr>
	<?php foreach ($dataProvider->getModels() as $key => $model) {
		$options = [
	        'title' => '点击设置为有效和无效操作',
		    'data-url' => Url::to(['check', 'kid' => $model->role_id]),
	        'onclick' => 'turen.com.updateStatus(this)',
        ];
		$checkstr = Html::a(($model->status?'有效':'无效'), 'javascript:;', $options);
		
		$options = [
		    'data-url' => Url::to(['delete', 'id' => $model->role_id, 'returnUrl' => Url::current()]),
		    'onclick' => 'turen.com.deleteItem(this, \''.$model->role_name.'\')',
		];
		$delstr = Html::a('删除', 'javascript:;', $options);
	?>
	<tr align="left" class="data-tr">
		<td class="first-column"><?= $model->role_id; ?></td>
		<td><?= $model->role_name; ?></td>
		<td><?= $model->note; ?></td>
		<td class="action end-column"><span><?= $checkstr; ?></span> | <span><a href="<?= Url::to(['update', 'id' => $model->role_id]) ?>">修改</a></span> | <span class="nb"><?= $delstr; ?></span></td>
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
	<?= Html::a('添加新角色', ['create'], ['class' => 'data-btn']) ?>
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
			<?= Html::a('添加新角色', ['create'], ['class' => 'data-btn']) ?>
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