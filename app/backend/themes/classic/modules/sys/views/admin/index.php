<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = '管理者列表';
?>

<?php echo $this->render('_search', ['model' => $searchModel]); ?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="data-table">
	<tr align="left" class="head">
		<td width="4%" class="first-column">ID</td>
		<td width="10%"><?= $dataProvider->sort->link('username', ['label' => '用户名']) ?></td>
		<td width="8%">管理角色</td>
		<td width="10%">电话</td>
		<td width="15%"><?= $dataProvider->sort->link('logintime', ['label' => '登录时间']) ?></td>
		<td width="8%">登录IP</td>
		<td class="end-column">操作</td>
	</tr>
	<?php
	$models = $dataProvider->getModels();
	foreach ($models as $key => $model)
	{
		$options = [
		    'title' => '点击进行显示和隐藏操作',
		    'data-url' => Url::to(['check', 'id' => $model->id]),
		    'onclick' => ($model->isFounder())?'$.notify(\'创始人不允许审核\', \'warn\')':'jwf.com.updateStatus(this)',
		];
		$checkstr = Html::a(($model->status?'已审':'未审'), 'javascript:;', $options);
		
		$options = [
		    'data-url' => Url::to(['delete', 'id' => $model->id, 'returnUrl' => Url::current()]),
		    'onclick' => 'jwf.com.deleteItem(this, \''.$model->username.'\')',
		];
		$delstr = Html::a('删除', 'javascript:;', $options);
	?>
	<tr align="left" class="data-tr">
		<td  class="first-column"><?php echo $model->id; ?></td>
		<td><?= $model->username; ?></td>
		<td><?= $model->roleName; ?></td>
		<td><?= $model->phone; ?></td>
		<td class="number"><?= empty($model->logintime)?'未登录':Yii::$app->getFormatter()->asDatetime($model->logintime); ?></td>
		<td><?= empty($model->loginip)?'未登录':$model->loginip ?></td>
		<td class="action end-column"><span><?= $checkstr; ?></span> | <span><a href="<?= Url::to(['/sys/admin/update', 'id' => $model->id]) ?>">修改</a></span> | <span class="nb"><?php echo $delstr; ?></span></td>
	</tr>
	<?php
	}
	?>
</table>
<?php

//判断无记录样式
if(empty($models))
{
	echo '<div class="data-empty">暂时没有相关的记录</div>';
}
?>

<div class="bottom-toolbar">
	<?= Html::a('添加管理员', ['/sys/admin/create'], ['class' => 'data-btn']) ?>
</div>

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
			<?= Html::a('添加新管理者', ['/sys/admin/create'], ['class' => 'data-btn']) ?>
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