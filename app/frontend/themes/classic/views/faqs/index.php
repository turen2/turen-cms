<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\widgets\LinkPager;
use yii\widgets\LinkSorter;
use yii\widgets\ListView;
use app\widgets\SideBoxListWidget;

$this->columnModel = $columnModel;
$this->title = '常见问答';

$links = [];
$links[] = ['label' => '<li class="active"><span>&gt;</span></li>'];
$links[] = ['label' => $this->title];

$pageParam = $dataProvider->pagination->pageParam;
$loadPageUrl = Url::current([$pageParam => null]);//禁止链接中包含page参数
$js = <<<EOF
//加载功能
$('.ask-more').on('click', function() {
    var url = '{$loadPageUrl}';
    var _this = $(this);
    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',
        context: _this,
        cache: false,
        data: {{$pageParam}: _this.data('page')},
        beforeSend: function(xhr) {
            _this.addClass('loading');
        },
        complete: function(xhr, status) {
            _this.removeClass('loading');
        },
        success: function(res) {
            if (res['state']) {
                $('.info-body ul').append(res['msg']);
                $('.info-body .ajax').fadeIn();
                if(res['complete']) {
                    _this.html('已经加载完了').unbind('click');
                } else {
                    _this.data('page', _this.data('page')+1);//分页+1
                }
            } else {
                alert(res['state']);
            }
       }
    });
});
EOF;
$this->registerJs($js);
?>

<div class="faqs-index">
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
                'links' => $links,
            ]) ?>
        </div>

        <div class="turen-box">
            <div class="turen-box m2s clearfix">
                <div class="midcontent card">
                    <div class="detail-text">
                        <div class="detail-content ask-info">
                            <ul class="info-top">
                                <li class="fl"><a class="<?= empty($searchModel->flag)?'active':'' ?>" href="<?= Url::to(['/faqs/index', 'flag' => null]) ?>">全部问答</a></li>
                                <li class="fl"><a class="<?= ($searchModel->flag == '搬家必答')?'active':'' ?>" href="<?= Url::to(['/faqs/index', 'flag' => '搬家必答']) ?>">搬家必答</a></li>
                                <li class="fl"><a class="<?= ($searchModel->flag == '最新问答')?'active':'' ?>" href="<?= Url::to(['/faqs/index', 'flag' => '最新问答']) ?>">最新问答</a></li>
                            </ul>
                            <?php
                            if(empty($dataProvider->count)) {
                                echo '<p class="empty">没有任何内容。</p>';
                            } else {
                                echo ListView::widget([
                                    'layout' => "<div class=\"info-body\"><ul>{items}</ul><a class=\"ask-more\" data-page=\"2\" href=\"javascript:;\">点击加载更多</a></div>",
                                    'dataProvider' => $dataProvider,
                                    'summary' => '',//分页概要
                                    'showOnEmpty' => true,
                                    'emptyText' => '没有任何内容。',
                                    'emptyTextOptions' => ['class' => 'empty'],
                                    'options' => ['tag' => false, 'class' => 'list-view'],//整个列表的总class
                                    'itemOptions' => ['tag' => false, 'class' => ''],//每个item上的class
                                    'separator' => "\n",//每个item之间的分隔线
                                    'viewParams' => ['notfirst' => 0],//给模板的额外参数
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
                                ]);
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="sidebox">
                    <div class="tab-sidebox">
                        <div class="tab-sidebox-title">
                            <h3>搬家费用测算</h3>
                        </div>
                        <div class="tab-sidebox-content">
                            <div class="sidebox-block test-price">
                                <p>//http://www.365azw.com/share/jiancai</p>
                                <p>测试</p>
                                <p>测试</p>
                                <p>测试</p>
                            </div>
                        </div>
                    </div>
                    <?= SideBoxListWidget::widget([
                        'style' => 'tab',
                        'htmlClass' => 'about-us',
                        'columnType' => 'block',
                        'blockId' => Yii::$app->params['config_face_cn_sidebox_contact_us_block_id'],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>


