<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use app\assets\Swiper2Asset;
use common\helpers\ImageHelper;
use common\models\ext\Ad;

Swiper2Asset::register($this);
$js = <<<EOF
var loginSwiper = new Swiper('.login-ad-banner .swiper-container', {
    loop: true,//循环
    autoplay : 3200,//可选选项，自动滑动
    pagination: '.login-ad-banner .pagination',
    grabCursor: true,
    paginationClickable: true,
    autoplayDisableOnInteraction: false,//用户操作后，autoplay将禁止
});
$('.login-ad-banner .arrow-right').on('click', function(e){
    e.preventDefault()
    loginSwiper.swipePrev()
});
$('.login-ad-banner .arrow-left').on('click', function(e){
    e.preventDefault()
    loginSwiper.swipeNext()
});
EOF;
$this->registerJs($js);
?>
<div class="login-ad-banner">
    <a class="arrow arrow-left" href="#"><span></span></a>
    <a class="arrow arrow-right" href="#"><span></span></a>
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <?php $loginMainAds = Ad::AdListByAdTypeId(Yii::$app->params['config_face_cn_login_signup_ad_type_id']); ?>
            <?php if($loginMainAds) { ?>
                <?php foreach ($loginMainAds as $index => $loginMainAd) { ?>
                    <div class="swiper-slide">
                        <a href="<?= $loginMainAd['linkurl'] ?>" target="_blank">
                            <img title="<?= $loginMainAd['title'] ?>" src="<?= empty($loginMainAd['picurl'])?ImageHelper::getNopic():Yii::$app->aliyunoss->getObjectUrl($loginMainAd['picurl'], true) ?>" />
                        </a>
                    </div>
                <?php } ?>
            <?php } else { ?>
                未设置登录/注册广告图
            <?php } ?>
        </div>
    </div>
    <div class="pagination"></div>
</div>