<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use app\assets\Swiper2Asset;
use app\widgets\SideBoxListWidget;
use app\widgets\SideLabelListWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use common\models\cms\Column;

$this->currentModel = $model;

Swiper2Asset::register($this);
$js = <<<EOF
var caseDetailSwiper = new Swiper('.detail-photo-list .swiper-container', {
    pagination: '.detail-photo-list .swiper-container .pagination',
    autoplay: true,
    autoplay: 3500,//自动播放且间隔为3秒
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
<div class="case-detail">
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
                'links' => Column::ModelBreadcrumbs($model, ['/case/list'], false),
            ]) ?>
        </div>
        <div class="turen-box m2s clearfix">
            <div class="midcontent card">
                <div class="detail-text">
                    <div class="detail-title">
                        <?= Html::tag('h3', $model->title) ?>
                        <div class="detail-date">
                            <ul>
                                <li><span>日期：</span><?= Yii::$app->getFormatter()->asDateTime($model->posttime, 'php:Y年m月d日') ?></li>
                                <li><span>发布人：</span><?= $model->author ?></li>
                                <li><span>浏览数：</span><?= $model->hits ?></li>
                            </ul>
                            <a href="">
                                <span><img src="https://statics.zxzhijia.com/zxzj2017/new2018/images/star.png"/></span>
                                <b>收藏</b>
                            </a>
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
                                    <img height="350px" src="<?= empty($img['pic'])?ImageHelper::getNopic():Yii::$app->aliyunoss->getObjectUrl($img['pic'], true) ?>" />
                                </div>
                                <?php } ?>
                            </div>
                            <div class="pagination"></div>
                        </div>
                    </div>
                    <?php } ?>

                    <div class="detail-content">
                        <?= $model->content; ?>
                    </div>
                    <div class="detail-main">
                        <dl>
                            <dt>
                                <div class="fenxiang">
                                    <div class="fenxiang_1">
                                        <div class="bdsharebuttonbox bdshare-button-style0-16" data-bd-bind="1547005450752">
                                            <a href="#" class="bds_more" data-cmd="more"></a>
                                            <a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a>
                                            <a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a>
                                            <a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a>
                                            <a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a>
                                            <a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a>
                                        </div>
                                    </div>
                                </div>
                            </dt>
                            <dd>
                                <a href="javascript:void(0)" id="dianzan"><span></span><b id="currdz">1</b></a>
                            </dd>
                        </dl>
                        <ul>
                            <li>
                                <?php  if($prevModel) { ?>
                                    <a href="<?= Url::to(['/case/detail', 'slug' => $prevModel->slug]) ?>">
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
                                    <a href="<?= Url::to(['/case/detail', 'slug' => $nextModel->slug]) ?>">
                                        <span class="ap8"></span>
                                        <b>上一篇：<?= $nextModel->title ?></b>
                                    </a>
                                <?php } else { ?>
                                    <a href="javascript:;">
                                        <span class="ap8"></span>
                                        <b>上一篇：没有了</b>
                                    </a>
                                <?php } ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="sidebox">
                <div class="tab-sidebox card">
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
                    'blockId' => Yii::$app->params['config_face_banjia_cn_sidebox_contact_us_block_id'],
                ]); ?>

                <?= SideBoxListWidget::widget([
                    'style' => 'gen',
                    'title' => '案例推荐',
                    'htmlClass' => 'case-photo-list',
                    'moreLink' => Url::to(['/case/list']),

                    'columnType' => 'photo',
                    'flagName' => 	Yii::$app->params['config_face_banjia_cn_sidebox_current_photo_column_flag'],
                    'columnId' => $model->columnid,//当前的栏目
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
        </div>
    </div>
</div>
