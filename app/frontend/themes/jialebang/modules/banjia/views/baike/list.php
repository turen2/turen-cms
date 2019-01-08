<?php
/* @var $this yii\web\View */

use app\widgets\SideBoxListWidget;
use app\widgets\SideLabelListWidget;
use common\models\cms\Column;
use yii\widgets\Breadcrumbs;
use yii\widgets\LinkPager;
use yii\widgets\LinkSorter;
use yii\widgets\ListView;

$this->title = $columnModel->cname;
?>
<div class="baike-content">
    <div class="container">
        <div class="banjia-title">
            <ul>
                <li><b>当前位置：</b></li>
                <?= Breadcrumbs::widget([
                    'encodeLabels' => false,
                    'tag' => false,
                    'homeLink' => null,
                    'itemTemplate' => "<li>{link}</li>\n",
                    //'activeItemTemplate' => "<li class=\"active\">{link}</li>\n",
                    'links' => Column::Breadcrumbs($columnModel, ['/banjia/post/list']),
                ]) ?>
            </ul>
        </div>

        <div class="banjia-box">
            <div class="banjia-left sidebox">
                <?= $this->render('/common/_sidebox_flow') ?>

                <?= SideBoxListWidget::widget([
                    'style' => 'gen',
                    'title' => '百科推荐',
                    'htmlClass' => 'baike-list',
                    
                    'columnType' => 'article',
                    'flagName' => '推荐',
                    'columnId' => 	Yii::$app->params['config_face_banjia_cn_sidebox_baike_column_id'],//搬家百科
                    'route' => ['/banjia/baike/detail'],
                ]); ?>

                <?= SideBoxListWidget::widget([
                    'style' => 'tab',
                    'htmlClass' => 'about-us',
                    'columnType' => 'block',
                    'blockId' => Yii::$app->params['config_face_banjia_cn_sidebox_contact_us_block_id'],
                ]); ?>

                <?= SideLabelListWidget::widget([
                    'shortColumnClassName' => 'Article',//栏目短类名
                    'htmlClass' => 'aboutlabel',
                    'title' => '相关标签',
                    'listNum' => 10,//最多显示的个数
                    'route' => ['/banjia/tag/list', 'type' => 'article'],
                ]); ?>
            </div>
            <div class="banjia-right">
                <?= ListView::widget([
                    'layout' => "<div class=\"banjia-right-tab\">{sorter}</div>\n<div class=\"banjia-items\"><ul>{items}</ul></div>\n<div class=\"banjia-page\">{pager}</div>",
                    'dataProvider' => $dataProvider,
                    'summary' => '',//分页概要
                    'showOnEmpty' => true,
                    'emptyText' => '没有任何内容。',
                    'emptyTextOptions' => ['class' => 'empty'],
                    'options' => ['tag' => false, 'class' => 'list-view'],//整个列表的总class
                    'itemOptions' => ['tag' => 'li', 'class' => 'banjia-list'],//每个item上的class
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
                        'attributes' => ['posttime', 'hits'],
                    ],
                    'pager' => [
                        'class' => LinkPager::class,
                        'options' => ['class' => ''],
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
        </div>
    </div>
</div>
