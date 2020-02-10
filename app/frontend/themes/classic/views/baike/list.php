<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
/* @var $this yii\web\View */

use yii\widgets\Breadcrumbs;
use yii\widgets\LinkPager;
use yii\widgets\LinkSorter;
use yii\widgets\ListView;
use app\widgets\SideBoxListWidget;
use app\widgets\SideLabelListWidget;

$this->columnModel = $columnModel;

?>
<div class="baike-list">
    <div class="container">
        <div class="breadcrumb-box clearfix">
            <span class="location"><b>当前位置：</b></span>
            <?= Breadcrumbs::widget([
                'encodeLabels' => false,
                'options' => ['class' => 'pagination clearfix'],
                'tag' => 'ul',
                'homeLink' => null,
                'itemTemplate' => "<li>{link}</li>\n<li>&gt;</li>\n",
                //'activeItemTemplate' => "<li class=\"active\">{link}</li>\n",
                'links' => $columnModel->breadcrumbs(['/baike/list'], false),
            ]) ?>
        </div>

        <div class="turen-box m2s clearfix">
            <div class="midcontent">
                <?= ListView::widget([
                    'layout' => "<div class=\"turen-sort\">{sorter}</div>\n<div class=\"turen-items\"><ul>{items}</ul></div>\n<div class=\"pagination-box clearfix\">{pager}</div>",
                    'dataProvider' => $dataProvider,
                    'summary' => '',//分页概要
                    'showOnEmpty' => false,
                    'emptyText' => '没有任何内容。',
                    'emptyTextOptions' => ['class' => 'empty'],
                    'options' => ['tag' => false, 'class' => 'list-view'],//整个列表的总class
                    'itemOptions' => ['tag' => 'li', 'class' => 'turen-list'],//每个item上的class
                    'separator' => "\n",//每个item之间的分隔线
                    'viewParams' => [],//给模板的额外参数
                    //'itemView' => function ($model, $key, $index, $widget) {//可以是回调，也可以是子模板
                        //return Html::a(Html::encode($model->title), ['view', 'id' => $model->id]);
                    //},
                    'itemView' => '_item',//默认参数：$model, $key, $index, $widget
                    'beforeItem' => '',
                    'afterItem' => '',

                    'sorter' => [
                        'class' => LinkSorter::class,
                        'options' => ['class' => 'sorter clearfix'],
                        'attributes' => ['posttime', 'hits'],
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
            </div>
            <div class="sidebox">
                <?= $this->render('/common/_sidebox_flow') ?>

                <?= SideBoxListWidget::widget([
                    'style' => 'gen',
                    'title' => '百科推荐',
                    'htmlClass' => 'baike-article-list',

                    'columnType' => 'article',
                    'flagName' => Yii::$app->params['config_face_cn_sidebox_baike_column_flag'],
                    'columnId' => 	Yii::$app->params['config_face_cn_sidebox_baike_column_id'],//高空车租赁百科
                    'route' => ['/baike/detail'],
                ]); ?>

                <?= SideBoxListWidget::widget([
                    'style' => 'tab',
                    'htmlClass' => 'about-us',
                    'columnType' => 'block',
                    'blockId' => Yii::$app->params['config_face_cn_sidebox_contact_us_block_id'],
                ]); ?>

                <?= SideLabelListWidget::widget([
                    'shortColumnClassName' => 'Article',//栏目短类名
                    'htmlClass' => 'label-sidebox',
                    'title' => '相关标签',
                    'listNum' => 10,//最多显示的个数
                    'route' => ['/tag/list', 'type' => 'article'],
                ]); ?>
            </div>
        </div>
    </div>
</div>
