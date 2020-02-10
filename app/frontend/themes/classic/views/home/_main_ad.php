<?php

use app\assets\Swiper2Asset;
use common\helpers\ImageHelper;
use common\models\ext\Ad;

Swiper2Asset::register($this);

$js = <<<EOF
//主幻灯片
var homeMainAdSwiper = new Swiper('.home-main-ad .swiper-container', {
    pagination: '.home-main-ad .swiper-container .pagination',
    loop: true,//循环
    autoplay: 3500,//自动播放且间隔为3秒
    paginationClickable: true,//导航可操作帧
    autoplayDisableOnInteraction: true,//用户操作后，autoplay将禁止
});
$('.home-main-ad .arrow-right').on('click', function(e){
    e.preventDefault();
    homeMainAdSwiper.swipeNext();
});
$('.home-main-ad .arrow-left').on('click', function(e){
    e.preventDefault();
    homeMainAdSwiper.swipePrev();
});
EOF;
$this->registerJs($js);
?>
<div class="main-slide fl">
    <?php $mainAds = Ad::AdListByAdTypeId(Yii::$app->params['config_face_cn_home_main_ad_type_id']); ?>
    <?php if($mainAds) { ?>
        <div class="home-main-ad">
            <a class="arrow arrow-left opacity50" title="向左滑动" href="#"></a>
            <a class="arrow arrow-right opacity50" title="向右滑动" href="#"></a>
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <?php foreach ($mainAds as $index => $mainAd) { ?>
                        <div class="swiper-slide">
                            <a href="<?= $mainAd['linkurl'] ?>">
                                <img height="370px" title="<?= $mainAd['title'] ?>" src="<?= empty($mainAd['picurl'])?ImageHelper::getNopic():Yii::$app->aliyunoss->getObjectUrl($mainAd['picurl'], true) ?>" />
                            </a>
                        </div>
                    <?php } ?>
                </div>
                <div class="pagination"></div>
            </div>
        </div>
    <?php } else { ?>
        未设置主幻灯片
    <?php } ?>
</div>