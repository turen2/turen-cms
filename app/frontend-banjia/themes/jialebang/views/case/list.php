<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
/* @var $this yii\web\View */

use app\assets\WaterfallAsset;
use app\widgets\SideBoxListWidget;
use app\widgets\SideLabelListWidget;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\widgets\LinkPager;
use yii\widgets\LinkSorter;

$this->columnModel = $columnModel;

WaterfallAsset::register($this);
$currentUrl = Url::current(['wallpage' => 'wall_page']);//在当前url基础上增加一个新参数！！！使用wall_page点位链接，支持伪静态
$js = <<<EOF
$('#photo-water-list ul').waterfall({
    itemCls: 'water-list',
    colWidth: 265,//元素本身的宽度
    gutterWidth: 20,//每个元素之间的间隙
    gutterHeight: 20,//
    maxPage: 3,//每一个页面请求三次
    checkImagesLoaded: false,
    callbacks: {
        loadingFinished: function(loading, isBeyondMaxPage) {
            if ( !isBeyondMaxPage ) {
                loading.fadeOut();
            } else {
                loading.hide();
                $('.pagination-box .pagination').show();
            }
        }
    },
    path: function(page) {
        var url = '{$currentUrl}';
        url = url.replace(/wall_page/g, page);
        return url;
    }
});
EOF;
$this->registerJs($js);
?>

<script type="text/x-handlebars-template" id="waterfall-tpl">
    {{#result}}
    <li class="water-list">
        <div class="wall-pic">
            <a href="{{url}}">
                <img src="{{image}}" alt="{{title}}" />
            </a>
            <span><a href="{{url}}">查看详情</a><i></i></span>
            <b><a href="{{url}}">{{hits}}</a><i></i></b>
        </div>
        <div class="wall-text">
            <p><a class="wall-word" href="{{url}}" target="_blank">{{title}}</a></p>
        </div>
    </li>
    {{/result}}
</script>
<div class="case-list">
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
                'links' => $columnModel->breadcrumbs(['/case/list'], false),
            ]) ?>
        </div>

        <div class="turen-box s2m clearfix">
            <div class="sidebox">
                <?= SideBoxListWidget::widget([
                    'style' => 'gen',
                    'title' => '案例推荐',
                    'htmlClass' => 'case-photo-list',
                    'moreLink' => Url::to(['/case/list']),
                    
                    'columnType' => 'photo',
                    'flagName' => Yii::$app->params['config_face_banjia_cn_sidebox_current_photo_column_flag'],
                    'columnId' => $columnModel->id,//当前的栏目
                    'route' => ['/case/detail'],
                ]); ?>

                <?= SideLabelListWidget::widget([
                    'shortColumnClassName' => 'Photo',//栏目短类名
                    'htmlClass' => 'label-sidebox',
                    'title' => '相关标签',
                    'listNum' => 10,//最多显示的个数
                    'route' => ['/tag/list', 'type' => 'photo'],
                ]); ?>
            </div>
            <div class="midcontent">
                <div class="turen-sort">
                    <?= LinkSorter::widget([
                        'sort' => $dataProvider->sort,
                        'options' => ['class' => 'sorter clearfix'],
                        'attributes' => ['posttime', 'hits'],
                    ]) ?>
                </div>
                <div class="mod-promote">
                    <dl class="clearfix">
                        <dt>主要城市<i></i></dt>
                        <dd>
                            <a href="javascript:;">深圳市</a>
                            <a href="javascript:;">广州市</a>
                            <a href="javascript:;">东莞市</a>
                            <a href="javascript:;">珠海市</a>
                            <a href="javascript:;">中山市</a>
                            <a href="javascript:;">惠州市</a>
                        </dd>
                    </dl>
                </div>
                <div id="photo-water-list" class="turen-items">
                    <ul></ul>
                </div>
                <div class="pagination-box clearfix">
                    <?php
                    //注意：此时的pagination没有被激活，需要$dataProvider->count或$dataProvider->getModels()来激活。
                    //激活过，才能拿到count总数
                    $dataProvider->count;
                    ?>
                    <?= LinkPager::widget([
                        'pagination' => $dataProvider->getPagination(),
                        'options' => ['class' => 'pagination clearfix', 'style' => 'display: none;'],
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
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
