<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = '预约/询盘';
?>

<?= $this->render('_search', ['model' => $searchModel]); ?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="data-table">
	<tr align="left" class="head">
		<td width="4%" class="first-column">ID</td>
        <td width="8%"><?= $dataProvider->sort->link('ui_title', ['label' => '服务单号']) ?></td>
        <td width="10%"><?= $dataProvider->sort->link('ui_title', ['label' => '预约名称']) ?></td>
        <td width="16%">内容</td>
        <td width="6%">是否回复</td>
        <td width="10%">备注</td>
        <td width="5%">类型</td>
        <td width="6%">所属用户</td>
        <td width="8%"><?= $dataProvider->sort->link('ui_submit_time', ['label' => '提交日期']) ?></td>
        <td width="8%"><?= $dataProvider->sort->link('ui_answer_time', ['label' => '回复日期']) ?></td>
		<td width="8%"><?= $dataProvider->sort->link('ui_remark_time', ['label' => '备注日期']) ?></td>
		<td width="20%" class="end-column">操作</td>
	</tr>
	<?php foreach ($dataProvider->getModels() as $key => $model) { ?>
	<tr align="left" class="data-tr">
		<td class="first-column"><?= $model->ui_id; ?></td>
        <td><?= $model->ui_service_num; ?></td>
        <td><?= $model->ui_title; ?></td>
        <td>
            <?php
            if(empty($model->ui_content)) {
                echo '空';
            } else {
                $rows = Json::decode($model->ui_content);
                foreach ($rows as $key => $row) {
                    echo $key.' : '.$row;
                    echo '<br />';
                }
            }
            ?>
        </td>
        <td><?= empty($model->ui_answer)?'否':'是'; ?></td>
        <td><?= $model->ui_remark; ?></td>
        <td><?= $model->getTypeName(); ?></td>
        <td><?= $model->username; ?></td>
        <td><?= empty($model->ui_submit_time)?'未提交':str_replace(' ', '<br />', Yii::$app->getFormatter()->asDatetime($model->ui_submit_time)); ?></td>
        <td><?= empty($model->ui_answer_time)?'未回复':Yii::$app->getFormatter()->asDate($model->ui_answer_time); ?></td>
        <td><?= empty($model->ui_remark_time)?'未备注':Yii::$app->getFormatter()->asDate($model->ui_remark_time); ?></td>
		<td class="action end-column"><span><?= $model->getStateName(); ?></span> | <span><a href="<?= Url::to(['view', 'id' => $model->ui_id]) ?>">详情</a></span></td>
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

