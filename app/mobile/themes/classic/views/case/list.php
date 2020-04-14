<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
/* @var $this yii\web\View */

use mobile\assets\MasonryAsset;
use yii\helpers\Url;
use yii\widgets\ListView;

$this->columnModel = $columnModel;
$this->title = $columnModel->cname;

MasonryAsset::register($this);

$webUrl = Yii::getAlias('@web/');

$currentUrl = Url::current(['wallpage' => 'wall_page']);//在当前url基础上增加一个新参数！！！使用wall_page点位链接，支持伪静态

$next = $webUrl.'images/yaqiao/next.png';

$js = <<<EOF
var url = '{$currentUrl}';

/*瀑布流初始化设置*/
var _grid = $('.grid').masonry({
    itemSelector: '.grid-item',
    gutter: 10
});
// layout Masonry after each image loads
_grid.imagesLoaded().done(function () {
    _grid.masonry('layout');
});

var pageIndex = 1; // 当前page页面
var dataFall = []; // 每次请求响应的数据
var isEnd = false; // 服务器端是否加载完毕
var isBottom = true; // bool变量, 用于阻止滚动到底部连续触发多次
$(window).scroll(function () {
    _grid.masonry('layout');
    var scrollTop = $(this).scrollTop();
    var scrollHeight = $(document).height();
    var windowHeight = $(this).height();
    var scrollarea = scrollHeight - (windowHeight + scrollTop);
    if (scrollarea > 100 && scrollarea < 800) {
        if (isBottom) {
            var newUrl = url.replace(/wall_page/g, pageIndex);
            
            isBottom = false;
            $('.dropload-down-zxzj').css("display", "flex");
            $('.dropload-down-zxzj').html('<p class="dropload-load-zxzj"><span class="loading"></span>加载中...</p>');
            $.ajax({
                dataType: "json",
                type: 'GET',
                url: newUrl,//配合后台接口
                async: true,
                //data: {
                    //pageindex: pageIndex,
                    //pagesize: totalItem,
                //},
                success: function (data) {
                    dataFall = data.caseMoreList;
                    isEnd = data.end;
                    if (dataFall != null && dataFall.length > 0) {
                        setTimeout(function () {
                            appendFall();
                        }, 500)
                    } else {
                        isBottom = false;
                        $('.dropload-down-zxzj').html('<p class="dropload-noData-zxzj">没有更多数据</p>');
                    }
                },
                error: function (e) {
                    console.log('请求失败')
                }
            })
        }
    }
})

/////////////////////添加图片//////////////////////////////////////

function appendFall() {
    $.each(dataFall, function (index, value) {
        var dataLength = dataFall.length;
        _grid.imagesLoaded().done(function () {
            _grid.masonry('layout');
        });

        var html = "";
        html += '<a href="'+value.url+'">';
            html += '<div class="casebook-pic">';
                html += '<img class="item-bg" src="'+value.picurl+'" />';
                html += '<span>'+value.address+'</span></div>';
            html += '<div class="casebook-text">';
                html += '<h3 class="item-h3">'+value.title+'</h3>';
                html += '<dl>';
                    html += '<dd><i class="iconfont jia-eye"></i> '+value.hits+'</dd>';
                    html += '<dd><span></span></dd>';
                    html += '<dd>'+value.date+'</dd>';
                html += '</dl>';
                html += '<div class="casebook-designer item-box">';
                    html += '<i><img class="item-next" src="{$next}"></i>';
                html += '</div>';
            html += '</div>';
        html += '</a>';

        var _li = $('<li class="article grid-item item">');
        _li.html(html);
        var _items = _li;
        //_items.imagesLoaded().done(function() {
        _grid.masonry('layout');
        _grid.append(_items).masonry('appended', _items);
        //})
    });
    
    if (isEnd) {
        $('.dropload-down-zxzj').html('<p class="dropload-noData-zxzj">没有更多数据</p>');
    } else {
        isBottom = true;
        $('.dropload-down-zxzj').html('<p class="dropload-refresh-zxzj">↑上拉加载更多</p>');
    }
    
    pageIndex++;
}

window.onscroll = function () {
    if ($(window).scrollTop() >= $('.public-box').offset().top) {
        $('.goto-top').fadeIn(1500);
        $('.public-tab').css({
            'position': 'fixed',
            'top': '1.1rem',
            'left': 0,
            'padding': '0.05rem',
            'background-color': '#fff'
        });
        $('.public-box').css('padding-bottom', '0.52rem');
        $('.pub-hide').css({
            'top': '1.62rem',
        });
        $('.blackmask').css({
            'top': '1.62rem',
        });
    } else {
        $('.goto-top').fadeOut(1500);
        $('.public-tab').css({
            'position': 'relative',
            'top': 0,
            'left': 0,
            'padding': '0.05rem',
            'background': 'none'
        })
        $('.public-box').css('padding-bottom', '0');
        $('.pub-hide').css({
            'top': $('.public-tab').offset().top - $(window).scrollTop() + $('.public-tab').height()

        });
        $('.blackmask').css({
            'top': $('.public-tab').offset().top - $(window).scrollTop() + $('.public-tab').height()
        });
    }
}
EOF;
$this->registerJs($js);
?>

<div class="public-box"></div>

<div class="main-box">
    <div class="process-options">
        <ul>
            <li>
                <?= $dataProvider->sort->link('posttime', ['label' => '<span><img class="process-pic" src="'.$webUrl.'images/yaqiao/time.png"><img class="process-pho" src="'.$webUrl.'images/yaqiao/time2.png"></span><p>按时间</p>']) ?>
            </li>
            <li>
                <?= $dataProvider->sort->link('hits', ['label' => '<span><img class="process-pic" src="'.$webUrl.'images/yaqiao/fire.png"><img class="process-pho" src="'.$webUrl.'images/yaqiao/fire2.png"></span><p>按热度</p>']) ?>
            </li>
        </ul>
    </div>

    <div class="casebook">
        <?= ListView::widget([
            'layout' => "<ul class=\"wall grid\">{items}</ul>",
            'dataProvider' => $dataProvider,
            'summary' => '',//分页概要
            'showOnEmpty' => false,
            'emptyText' => '没有任何内容。',
            'emptyTextOptions' => ['class' => 'empty'],
            'options' => ['tag' => false, 'class' => ''],//整个列表的总class
            'itemOptions' => ['tag' => 'li', 'class' => 'article grid-item item'],//每个item上的class
            'separator' => "\n",//每个item之间的分隔线
            'viewParams' => [],//给模板的额外参数
            //'itemView' => function ($model, $key, $index, $widget) {//可以是回调，也可以是子模板
            //return Html::a(Html::encode($model->title), ['view', 'id' => $model->id]);
            //},
            'itemView' => '_item',//默认参数：$model, $key, $index, $widget
            'beforeItem' => '',
            'afterItem' => '',
        ]) ?>
        <div class="dropload-down-zxzj" style="display: none;justify-content: center;align-items: center;"><p class="dropload-load-zxzj"><span class="dropload-refresh"></span>↑上拉加载更多</p></div>
    </div>
</div>
<div class="myblack"></div>