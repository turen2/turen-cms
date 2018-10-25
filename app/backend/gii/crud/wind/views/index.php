<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;
?>

<?= "<?= " ?>$this->render('_search', ['model' => $searchModel]); ?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="data-table">
	<tr align="left" class="head">
		<td width="4%" class="first-column">ID</td>
		
		<?php if (($tableSchema = $generator->getTableSchema()) === false) { ?>
        <?php foreach ($generator->getColumnNames() as $name) { ?>
		<td width="17%"><?= $generator->getAttributeLabel($name)?></td>
		<?php  } ?>
        <?php  } ?>
		
		<td width="10%">添加日期</td>
		<td width="25%" class="end-column">操作</td>
	</tr>
	<?= "<?php " ?>foreach ($dataProvider->getModels() as $key => $model) {
		$options = [
	        'title' => '点击进行显示和隐藏操作',
	        'data-url' => Url::to(['check', 'id' => $model->id]),
	        'onclick' => 'turen.com.updateStatus(this)',
        ];
		$checkstr = Html::a(($model->status?'显示':'隐藏'), 'javascript:;', $options);
		
		$options = [
    		'data-url' => Url::to(['delete', 'id' => $model->id, 'returnUrl' => Url::current()]),
		    'onclick' => 'turen.com.deleteItem(this, \''.$model->xxxxx.'\')',
		];
		$delstr = Html::a('删除', 'javascript:;', $options);
	?>
	<tr align="left" class="data-tr">
		<td class="first-column"><?= "<?= " ?>$model->id; ?></td>
		
		<?php if (($tableSchema = $generator->getTableSchema()) === false) { ?>
        <?php foreach ($generator->getColumnNames() as $name) { ?>
        <td><?= "<?= " ?>$model-><?= $name?>; ?></td>
        <?php  } ?>
        <?php  } ?>
		
		<td><?= "<?= " ?>Yii::$app->getFormatter()->asDate($model->updated_at); ?></td>
		<td class="action end-column"><span><?= "<?= " ?>$checkstr; ?></span> | <span><a href="<?= "<?= " ?>Url::to(['update', 'id' => $model->id]) ?>">修改</a></span> | <span class="nb"><?= "<?= " ?>$delstr; ?></span></td>
	</tr>
	<?= "<?php " ?>} ?>
</table>
<?= "<?php " ?>
//判断无记录样式
if(empty($dataProvider->count))
{
	echo '<div class="data-empty">暂时没有相关的记录</div>';
}
?>

<div class="bottom-toolbar clearfix">
	<?= "<?= " ?>Html::a('添加新开发日志', ['create'], ['class' => 'data-btn']) ?>
	<div class="page">
    	<?= "<?= " ?>LinkPager::widget([
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
			<?= "<?= " ?>Html::a('添加新开发日志', ['create'], ['class' => 'data-btn']) ?>
			<span class="page-small">
			<?= "<?= " ?>LinkPager::widget([
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
<p class="cp tc"><?= "<?= " ?>Yii::$app->params['config_copyright'] ?></p>
<?= "\n" ?>