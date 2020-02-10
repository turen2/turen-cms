<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
/* @var $this yii\web\View */

$this->currentModel = $model;

use frontend\assets\Swiper2Asset;
use frontend\widgets\ContentMoreWidget;
use common\models\cms\Column;
use common\models\cms\Photo;
use common\tools\like\LikeWidget;
use common\tools\share\ShareWidget;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use frontend\widgets\SideBoxListWidget;
use frontend\widgets\SideLabelListWidget;

$dlength = 90;

Swiper2Asset::register($this);
$js = <<<EOF
var caseDetailSwiper = new Swiper('.detail-photo-list .swiper-container', {
    pagination: '.detail-photo-list .swiper-container .pagination',
    loop: true, // 循环
    autoplay: true,
    autoplay: 2000,//自动播放且间隔为3秒
    paginationClickable: true,
    slidesPerView: 'auto'
});
$('.detail-photo-list .arrow-left').on('click', function(e){
    e.preventDefault();
    caseDetailSwiper.swipeNext();
});
$('.detail-photo-list .arrow-right').on('click', function(e){
    e.preventDefault();
    caseDetailSwiper.swipePrev();
});
EOF;
$this->registerJs($js);
?>

<div class="news-detail">
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
                'links' => Column::ModelBreadcrumbs($model, ['/chexing/list'], false, 1),
            ]) ?>
        </div>
        <div class="turen-box m2s clearfix">
            <div class="midcontent">
                <div class="detail-text card">
                    <div class="detail-title">
                        <?php
                        $options = ['style' => ''];
                        if(!empty($model->colorval) || !empty($model->boldval)) {
                            Html::addCssStyle($options, ['color' => $model->colorval, 'font-weight' => $model->boldval]);
                        }
                        echo Html::tag('h3', $model->title, ['style' => $options['style']]);
                        ?>
                        <div class="detail-date">
                            <ul>
                                <li><span>日期：</span><?= Yii::$app->getFormatter()->asDateTime($model->posttime, 'php:Y年m月d日') ?></li>
                                <li><span>发布人：</span><?= $model->author ?></li>
                                <li><span>浏览数：</span><?= $model->hits ?></li>
                            </ul>
                            <?= LikeWidget::widget([
                                'modelClass' => Photo::class,
                                'modelId' => $model->id,
                                'upName' => '赞',
                                'downName' => '踩',
                                'followName' => false,
                                'route' => ['/chexing/like'],
                            ]); ?>
                        </div>
                    </div>
                    <div class="detail-digest">
                        <div class="detail-digest-line">
                            <p>
                                <?php
                                if(empty($model->description)) {
                                    $des = $model->content;//去除图片链接
                                } else {
                                    $des = $model->description;
                                }
                                echo StringHelper::truncate(strip_tags($des), $dlength);
                                ?>
                            </p>
                            <span>摘要<i></i></span>
                        </div>
                    </div>

                    <?php $imgs = $model->picList() ?>
                    <?php if($imgs) { ?>
                        <div class="detail-photo-list">
                            <a class="arrow arrow-left" title="向左滑动" href="#"></a>
                            <a class="arrow arrow-right" title="向右滑动" href="#"></a>
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    <?php foreach ($imgs as $index => $img) { ?>
                                        <div class="swiper-slide red-slide">
                                            <img height="500px" alt="<?= $img['txt'] ?>" title="<?= $img['txt'] ?>" src="<?= empty($img['pic'])?ImageHelper::getNopic():Yii::$app->aliyunoss->getObjectUrl($img['pic'], true) ?>" />
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="pagination"></div>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="detail-content">
                        <?= $model->content; ?>
                        <?php
                        $imgs = $model->picList();
                        $images = [];
                        foreach ($imgs as $img) {
                            $images[] = Yii::$app->aliyunoss->getObjectUrl($img['pic'], true);
                        }
                        echo ShareWidget::widget([
                            'title' => '分享至：',
                            'images' => $images
                        ]);
                        ?>
                    </div>
                    <div class="detail-main">
                        <ul>
                            <li>
                                <?php  if($prevModel) { ?>
                                    <a href="<?= Url::to(['/chexing/detail', 'slug' => $prevModel->slug]) ?>">
                                        <span class="ap8"></span>
                                        <b>上一篇：<?= $prevModel->title ?></b>
                                    </a>
                                <?php } else { ?>
                                    <a href="javascript:;">
                                        <span class="ap8"></span>
                                        <b>上一篇：没有了</b>
                                    </a>
                                <?php } ?>
                            </li>
                            <li style="float: right;">
                                <?php  if($nextModel) { ?>
                                    <a style="float: right;" href="<?= Url::to(['/chexing/detail', 'slug' => $nextModel->slug]) ?>">
                                        <span class="ap9"></span>
                                        <b>下一篇：<?= $nextModel->title ?></b>
                                    </a>
                                <?php } else { ?>
                                    <a style="float: right;" href="javascript:;">
                                        <span class="ap9"></span>
                                        <b>下一篇：没有了</b>
                                    </a>
                                <?php } ?>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="detail-more">
                    <?= ContentMoreWidget::widget([
                        'title' => '看过此车型还看过',
                        'htmlClass' => '',
                        'columnType' => 'photo',
                        'columnId' => $model->columnid,
                        'flagName' => '还看',
                        'listNum' => 6,
                        'route' => ['/chexing/detail'],
                    ]); ?>

                    <?= ContentMoreWidget::widget([
                        'title' => '相关阅读',
                        'htmlClass' => 'detail-add',
                        'columnType' => 'photo',
                        'columnId' => $model->columnid,
                        'flagName' => '相关',
                        'listNum' => 6,
                        'route' => ['/chexing/detail'],
                    ]); ?>
                </div>

            </div>
            <div class="sidebox">
                <?= SideBoxListWidget::widget([
                    'style' => 'gen',
                    'title' => '相关推荐',
                    'htmlClass' => 'chexing-detail-photo',
                    'moreLink' => Url::to(['/chexing/list']),

                    'columnType' => 'photo',
                    'columnId' => $model->columnid,
                    'listNum' => 6,
                    'route' => ['/chexing/detail'],
                ]); ?>

                <?= SideLabelListWidget::widget([
                    'shortColumnClassName' => 'Photo',//栏目短类名
                    'htmlClass' => '',
                    'title' => '相关标签',
                    'listNum' => 10,//最多显示的个数
                    'route' => ['/tag/list', 'type' => 'photo'],
                ]); ?>
            </div>
        </div>
    </div>
</div>