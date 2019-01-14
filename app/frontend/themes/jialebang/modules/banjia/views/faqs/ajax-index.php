<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\widgets\LinkPager;
use yii\widgets\LinkSorter;
use yii\widgets\ListView;

?>

<?= ListView::widget([
    'layout' => "{items}",
    'dataProvider' => $dataProvider,
    'summary' => '',//分页概要
    'showOnEmpty' => true,
    'emptyText' => '没有任何内容。',
    'emptyTextOptions' => ['class' => 'empty'],
    'options' => ['tag' => false, 'class' => 'list-view'],//整个列表的总class
    'itemOptions' => ['tag' => false, 'class' => ''],//每个item上的class
    'separator' => "\n",//每个item之间的分隔线
    'viewParams' => ['notfirst' => 1],//给模板的额外参数
    'itemView' => '_item',//默认参数：$model, $key, $index, $widget
    'beforeItem' => '',
    'afterItem' => '',
    'sorter' => [
        'class' => LinkSorter::class,
        'options' => ['class' => 'sorter clearfix'],
        'attributes' => ['posttime'],
    ],
    'pager' => [
        'class' => LinkPager::class,
        'options' => ['class' => 'pagination clearfix'],
        //'linkOptions' => ['class' => ''],
        'firstPageCssClass' => 'text first',
        'lastPageCssClass' => 'text last',
        'prevPageCssClass' => 'text prev',
        'nextPageCssClass' => 'text next',
        'activePageCssClass'=> 'active',
        'firstPageLabel' => '首页',
        'lastPageLabel' => '末页',
        'prevPageLabel' => '上页',
        'nextPageLabel' => '下页',
    ],
]) ?>
