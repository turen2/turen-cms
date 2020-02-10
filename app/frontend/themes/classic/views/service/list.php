<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\widgets\LinkPager;
use yii\widgets\LinkSorter;
use yii\widgets\ListView;
use frontend\widgets\SideBoxListWidget;
use frontend\widgets\SideLabelListWidget;

$js = <<<EOF
$('.service-items .overlay-panel').hover(
    function () {
        $(this).removeClass("removeimg").addClass("fadeimg").prev().removeClass("removeimg").addClass("fadeimg");
    },
    function () {
        $(this).removeClass("removeimg").addClass("fadeimg").prev().removeClass("fadeimg").addClass("removeimg");
    }
);
EOF;
$this->registerJs($js);

$this->columnModel = $columnModel;
?>
<div class="service-list">
    <div class="container">
        <div class="breadcrumb-box clearfix">
            <span class="location"><b>当前位置：</b></span>
            <?= Breadcrumbs::widget([
                'encodeLabels' => false,
                'options' => ['class' => 'pagination clearfix'],
                'tag' => 'ul',
                'homeLink' => null,
                'itemTemplate' => "<li>{link}</li>\n",
                //'activeItemTemplate' => "<li class=\"active\">{link}</li>\n",
                'links' => $columnModel->breadcrumbs(['/service/list'], false),
            ]) ?>
        </div>

        <div class="turen-box m2s clearfix">
            <div class="midcontent">
                <?= ListView::widget([
                    'layout' => "<div class=\"turen-sort\">{sorter}</div>\n<div class=\"turen-items service-items\"><ul>{items}</ul></div>\n<div class=\"pagination-box clearfix\">{pager}</div>",
                    'dataProvider' => $dataProvider,
                    'summary' => '',//分页概要
                    'showOnEmpty' => false,
                    'emptyText' => '没有任何内容。',
                    'emptyTextOptions' => ['class' => 'empty'],
                    'options' => ['tag' => false, 'class' => 'list-view'],//整个列表的总class
                    'itemOptions' => ['tag' => 'li', 'class' => 'card'],//每个item上的class
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
                <?= SideBoxListWidget::widget([
                    'style' => 'tab',
                    'htmlClass' => 'about-us',
                    'columnType' => 'block',
                    'blockId' => Yii::$app->params['config_face_cn_sidebox_contact_us_block_id'],
                ]); ?>

                <?= SideBoxListWidget::widget([
                    'style' => 'gen',
                    'title' => '服务推荐',
                    'htmlClass' => 'service-product-list',
                    'moreLink' => Url::to(['/service/list']),

                    'columnType' => 'product',
                    'flagName' => Yii::$app->params['config_face_cn_sidebox_current_product_column_flag'],
                    'columnId' => $columnModel->id,//当前的栏目
                    'route' => ['/service/detail'],
                ]); ?>

                <?= SideLabelListWidget::widget([
                    'shortColumnClassName' => 'Product',//栏目短类名
                    'htmlClass' => 'service-product-label',
                    'title' => '相关标签',
                    'listNum' => 10,//最多显示的个数
                    'route' => ['/tag/list', 'type' => 'product'],
                ]); ?>
            </div>
        </div>
    </div>
</div>
