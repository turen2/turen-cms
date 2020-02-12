<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;
use common\helpers\Functions;
use backend\models\cms\Column;
use backend\widgets\edititem\EditItemWidget;
use backend\models\cms\Cate;
use backend\assets\ClipboardAsset;

ClipboardAsset::register($this);
$js = <<<EOF
    new ClipboardJS('.btn-clipboard');

    $('.btn-clipboard').click(function() {
        $.notify('复制成功', 'success');
    });
EOF;
$this->registerJs($js);

$this->title = '视频信息管理';
$this->topFilter = $this->render('_filter', ['model' => $searchModel, 'columnModel' => $columnModel, 'type' => Column::COLUMN_TYPE_VIDEO]);
if($columnModel) {
    $slugUrl = Functions::ColumnUrl($columnModel->m_column);
    $this->urlLink = '<span class="url-link">访问链接：<a class="btn-clipboard" data-clipboard-text="'.$slugUrl.'" href="javascript:;" title="点击复制">'.$slugUrl.'</a></span>';
}
?>

<?= $this->render('_search', ['model' => $searchModel]); ?>

<?php $form = ActiveForm::begin([
    'enableClientScript' => false,
    'options' => ['id' => 'batchform'],
]); ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="data-table">
	<tr align="left" class="head">
		<td width="4%" class="first-column"><input type="checkbox" name="checkid" id="checkid" onclick="turen.com.checkAll(this.checked);"></td>
		<td width="5%">ID</td>
		<td width="30%"><?= $dataProvider->sort->link('title', ['label' => '标题']) ?></td>
		<td width="8%">栏目</td>
		<?php if(Yii::$app->params['config.openCate']) { ?>
		<td width="8%">所属类别</td>
		<?php } ?>
		<td width="6%">发布人</td>
		<td width="5%"><?= $dataProvider->sort->link('hits', ['label' => '点击']) ?></td>
		<td width="4%"><?= $dataProvider->sort->link('orderid', ['label' => '排序']) ?></td>
		<td width="10%"><?= $dataProvider->sort->link('posttime', ['label' => '发布时间']) ?></td>
		<td class="end-column">操作</td>
	</tr>
	<?php foreach ($dataProvider->getModels() as $key => $model) {
		$options = [
	        'title' => '点击进行显示和隐藏操作',
	        'data-url' => Url::to(['check', 'kid' => $model->id]),
	        'onclick' => 'turen.com.updateStatus(this)',
        ];
		$checkstr = Html::a(($model->status?'显示':'隐藏'), 'javascript:;', $options);
		
		$options = [
    		'data-url' => Url::to(['delete', 'id' => $model->id, 'returnUrl' => Url::current()]),
		    'onclick' => 'turen.com.deleteItem(this, \''.$model->title.'\')',
		];
		$delstr = Html::a('删除', 'javascript:;', $options);
	?>
	<tr align="left" class="data-tr">
		<td width="4%" class="first-column">
			<input type="checkbox" name="checkid[]" id="checkid[]" value="<?= $model->id; ?>">
		</td>
		<td><?= $model->id; ?></td>
		<td>
			<span class="title" style="color:<?= $model->colorval; ?>;font-weight:<?= $model->boldval; ?>"><?= $model->title; ?><span class="title-flag"><?= implode('&nbsp;', $model->activeFlagList(Column::COLUMN_TYPE_VIDEO)); ?></span><?=empty($model->picurl)?'':' <span class="titpic"><i class="fa fa-picture-o"></i></span>'?></span>
            <?php $slugUrl = Functions::SlugUrl($model, 'slug', Column::MobileColumn($model->columnid)) ?>
            <p><a class="btn-clipboard" data-clipboard-text="<?= $slugUrl ?>" href="javascript:;" title="点击复制"><?= $slugUrl ?></a></p>
		</td>
		<td><?= Column::ColumnName($model->columnid).' ['.$model->columnid.']'; ?></td>
		<?php if(Yii::$app->params['config.openCate']) { ?>
		<td><?= Cate::CateName($model->cateid) ?></td>
		<?php } ?>
		<td><?= $model->author; ?></td>
		<td><?= $model->hits; ?></td>
		<td><?= EditItemWidget::widget([
		    'model' => $model,
		    'primaryKey' => 'id',
		    'attribute' => 'orderid',
		    'url' => Url::to(['/cms/video/edit-item']),
		    'options' => [],
		]); ?></td>
		<td><?= Yii::$app->getFormatter()->asDate($model->posttime); ?></td>
		<td class="action end-column"><span><?= $checkstr; ?></span> | <span><a href="<?= Url::to(['update', 'id' => $model->id]) ?>">修改</a></span> | <span class="nb"><?= $delstr; ?></span></td>
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
	<?= Html::a('添加视频信息', ['create'], ['class' => 'data-btn']) ?>
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
        	<a href="javascript:turen.com.batchSubmit('<?=Url::to(['batch', 'type' => 'delete'])?>', 'batchform');">删除</a>
        	<span class="total">共 <?= $dataProvider->getTotalCount() ?> 条记录</span>
    	</span>
			<?= Html::a('添加新视频', ['create'], ['class' => 'data-btn']) ?>
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