<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use yii\helpers\Url;
use yii\widgets\ListView;

$this->columnModel = $columnModel;
$this->title = $columnModel->cname;

$css = <<<FOE
.public-box {
    border: none;
}
FOE;
$this->registerCss($css);

$js = <<<EOF

EOF;
$this->registerJs($js);

$webUrl = Yii::getAlias('@web/');
?>

<div class="public-box"></div>

<div class="small-banner" style="padding-top: .26rem;">
    <a href="<?= Url::to(['/online/price']) ?>">
        <img src="<?= $webUrl ?>images/yaqiao/price-banner.png" />
    </a>
</div>

<div class="main-box">
    <?= ListView::widget([
        'layout' => "<div class=\"question-wrap\"><ul>{items}</ul></div>",
        'dataProvider' => $dataProvider,
        'summary' => '',//分页概要
        'showOnEmpty' => false,
        'emptyText' => '没有任何内容。',
        'emptyTextOptions' => ['class' => 'empty'],
        'options' => ['tag' => false, 'class' => ''],//整个列表的总class
        'itemOptions' => ['tag' => 'li', 'class' => 'question-list'],//每个item上的class
        'separator' => "\n",//每个item之间的分隔线
        'viewParams' => [],//给模板的额外参数
        //'itemView' => function ($model, $key, $index, $widget) {//可以是回调，也可以是子模板
        //return Html::a(Html::encode($model->title), ['view', 'id' => $model->id]);
        //},
        'itemView' => '_item',//默认参数：$model, $key, $index, $widget
        'beforeItem' => '',
        'afterItem' => '',
    ]) ?>

    <div class="myblack"></div>

    <?php
    $page = $dataProvider->pagination->page;
    $count = $dataProvider->pagination->pageCount;
    $prevPage = $dataProvider->pagination->createUrl($page - 1, null);
    $nextPage = $dataProvider->pagination->createUrl($page + 1, null);
    ?>
    <div data-role="widget-pagination">
        <a href="<?= $prevPage ?>" class="<?= ($page <= 0)?'widget-pagination-disable':'' ?>">上一页</a>
        <div>
            <div class="widget-pagination-current-page"><?= $page + 1 ?>/<?= $count ?></div>
        </div>
        <a href="<?= $nextPage ?>" class="<?= ($page + 1 >= $count)?'widget-pagination-disable':'' ?>">下一页</a>
    </div>
</div>

<div class="myblack"></div>