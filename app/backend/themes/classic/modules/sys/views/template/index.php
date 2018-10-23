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
use common\helpers\ImageHelper;
use common\components\aliyunoss\AliyunOss;

/* @var $this yii\web\View */
/* @var $searchModel app\models\sys\TemplateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '模板管理';
?>

<?php // $this->render('_search', ['model' => $searchModel]); ?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="data-table">
	<tr align="left" class="head">
		<td width="3%" class="first-column">ID</td>
		<td width="10%">缩略图</td>
		<td width="10%"><?= $dataProvider->sort->link('temp_name', ['label' => '模板名称']) ?></td>
		<td width="7%">模板编码</td>
		<td width="5%">是否开启类别</td>
		<td width="6%"><?= $dataProvider->sort->link('developer_name', ['label' => '开发者']) ?></td>
		<td width="6%"><?= $dataProvider->sort->link('design_name', ['label' => '设计师']) ?></td>
		<td width="6%">开通语言</td>
		<td width="6%">默认语言</td>
		<td width="6%">是否启用</td>
		<td width="10%"><?= $dataProvider->sort->link('posttime', ['label' => '发布时间']) ?></td>
		<td width="10%"><?= $dataProvider->sort->link('created_at', ['label' => '添加日期']) ?></td>
		<td width="20%" class="end-column">操作</td>
	</tr>
	<?php foreach ($dataProvider->getModels() as $key => $model) {
		$options = [
		    'data-url' => Url::to(['delete', 'id' => $model->temp_id, 'returnUrl' => Url::current()]),
		    'onclick' => 'jwf.com.deleteItem(this, \''.$model->temp_name.'\')',
		];
		$delstr = Html::a('删除', 'javascript:;', $options);
	?>
	<tr align="left" class="data-tr">
		<td class="first-column"><?= $model->temp_id; ?></td>
		<td><span class="thumbs"><img alt="" src="<?= empty($model->picurl)?ImageHelper::getNopic():Yii::$app->aliyunoss->getObjectUrl($model->picurl, true, AliyunOss::OSS_STYLE_NAME180X180) ?>" style="height: 60px;"></span></td>
		<td><?= $model->temp_name; ?></td>
		<td><?= $model->temp_code; ?></td>
		<td><?= $model->open_cate?'支持':'不支持'; ?></td>
		<td><?= $model->developer_name; ?></td>
		<td><?= $model->design_name; ?></td>
		<td><?= $model->langStr; ?></td>
		<td><?= $model->defaultLangStr; ?></td>
		<td><span class="status <?= ($model->temp_id == Yii::$app->params['config.templateId'])?'on':'off' ?>"></span></td>
		<td><?= Yii::$app->getFormatter()->asDate($model->posttime); ?></td>
		<td><?= Yii::$app->getFormatter()->asDate($model->created_at); ?></td>
		<td class="action end-column"><span><a href="<?= Url::to(['update', 'id' => $model->temp_id]) ?>">修改</a></span> | <span class="nb"><?= $delstr; ?></span></td>
	</tr>
	<?php } ?>
</table>
<?php //判断无记录样式
if(empty($dataProvider->count))
{
	echo '<div class="data-empty">暂时没有相关的记录</div>';
}
?>

<div class="bottom-toolbar">
	<?= Html::a('添加新模板', ['create'], ['class' => 'data-btn']) ?>
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
			<?= Html::a('添加新模板', ['create'], ['class' => 'data-btn']) ?>
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

