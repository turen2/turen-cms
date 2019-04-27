<?php

use app\models\user\FeedbackType;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel app\models\user\FeedbackTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '反馈类型列表';
?>

<?= $this->render('_search', ['model' => $searchModel]); ?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="data-table">
	<tr align="left" class="head">
		<td width="4%" class="first-column"><?= $dataProvider->sort->link('fkt_id', ['label' => 'ID']) ?></td>
        <td width="20%"><?= $dataProvider->sort->link('fkt_form_show', ['label' => '表单显示名称']) ?></td>
        <td width="20%"><?= $dataProvider->sort->link('fkt_list_show', ['label' => '列表显示名称']) ?></td>
        <td width="10%" align="center"><?= $dataProvider->sort->link('orderid', ['label' => '排序']) ?></td>
		<td width="10%">添加日期</td>
		<td width="25%" class="end-column">操作</td>
	</tr>
	<?php foreach ($dataProvider->getModels() as $key => $model) {
        $options = [
            'data-method' => 'post',
        ];
        $url = Url::to(['set-default', 'id' => $model->fkt_id, 'returnUrl' => Url::current()]);
        $default = ($model->is_default)?Html::a('默认', 'javascript:;'):Html::a('设为默认', $url, $options);

		$options = [
	        'title' => '点击进行显示和隐藏操作',
	        'data-url' => Url::to(['check', 'id' => $model->fkt_id]),
	        'onclick' => 'turen.com.updateStatus(this)',
        ];
		$checkstr = Html::a(($model->status?'显示':'隐藏'), 'javascript:;', $options);

		$options = [
    		'data-url' => Url::to(['delete', 'id' => $model->fkt_id, 'returnUrl' => Url::current()]),
		    'onclick' => 'turen.com.deleteItem(this, \''.$model->fkt_form_name.'|'.$model->fkt_list_name.'\')',
		];
		$delstr = Html::a('删除', 'javascript:;', $options);
	?>
	<tr align="left" class="data-tr">
		<td class="first-column"><?= $model->fkt_id; ?></td>
        <td><?= $model->fkt_form_name?$model->fkt_form_name:'未定义'; ?>[<?= $model->fkt_form_show?'显示':'隐藏'; ?>]</td>
        <td><?= $model->fkt_list_name?$model->fkt_list_name:'未定义'; ?>[<?= $model->fkt_list_show?'显示':'隐藏'; ?>]</td>
        <td align="center">
            <a href="<?=Url::to(['quick-move', 'type' => FeedbackType::ORDER_UP_TYPE, 'kid' => $model->fkt_id, 'orderid' => $model->orderid])?>" class="left-arrow" title="提升排序"></a>
            <input type="text" name="orderid[]" id="orderid[]" class="inputls" value="<?= $model->orderid; ?>">
            <a href="<?=Url::to(['quick-move', 'type' => FeedbackType::ORDER_DOWN_TYPE, 'kid' => $model->fkt_id, 'orderid' => $model->orderid])?>" class="right-arrow" title="下降排序"></a>
        </td>
		<td><?= Yii::$app->getFormatter()->asDate($model->created_at); ?></td>
		<td class="action end-column"><?=$default?> | <span><?= $checkstr; ?></span> | <span><a href="<?= Url::to(['update', 'id' => $model->fkt_id]) ?>">修改</a></span> | <span class="nb"><?= $delstr; ?></span></td>
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
	<?= Html::a('添加新反馈类型', ['create'], ['class' => 'data-btn']) ?>
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
			<?= Html::a('添加新反馈类型', ['create'], ['class' => 'data-btn']) ?>
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

