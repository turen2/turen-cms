<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use app\assets\PinAsset;
use app\assets\Swiper2Asset;
use common\helpers\ImageHelper;
use common\helpers\Util;
use yii\helpers\Url;

/* @var $this yii\web\View */
$this->title = $curModel->title;

Swiper2Asset::register($this);
PinAsset::register($this);
$js = <<<EOF
var swiper = new Swiper('.service-top-slide .swiper-container', {
    loop: false,//循环切换
    //autoplay : 2000,//可选选项，自动滑动
    //pagination: '.pagination',
    grabCursor: true,
    paginationClickable: true,
    slidesPerView: 7,
    autoplayDisableOnInteraction: true,//用户操作后，autoplay将禁止
    initialSlide :$('.service-link.on').parent().index(),//初始化索引
});
$('.service-top-slide .arrow-left').on('click', function(e){
    e.preventDefault();
    swiper.swipePrev();
});
$('.service-top-slide .arrow-right').on('click', function(e){
    e.preventDefault();
    swiper.swipeNext();
});
$(".service-nav").pin({
      padding: {top: 100}
});
$('.free-jijia').pin({
    padding: {top: 100}
});
$('.service-nav li').on('click', function() {
    $('.service-nav li').removeClass('on').eq($(this).index()).addClass('on');
});
//测试
//$(window).scroll(function() {
//    console.log($('.service-slide-box').offset().top);
//});
EOF;
$this->registerJs($js);
?>
<div class="service-slide-box">
    <div class="service-top-slide container">
        <a class="arrow arrow-left" title="向左滑动" href="#"></a>
        <a class="arrow arrow-right" title="向右滑动" href="#"></a>
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <?php foreach ($models as $index => $model) { ?>
                    <div class="swiper-slide">
                        <a class="service-link<?= ($model->id == $curModel->id)?' on':'' ?> br5" href="<?= Url::to(['service/detail', 'slug' => $model->slug]) ?>">
                            <img height="120px" title="<?= $model->title ?>" src="<?= empty($model->picurl)?ImageHelper::getNopic():Yii::$app->aliyunoss->getObjectUrl($model->picurl, true) ?>" />
                            <span class="link-txt"><?= $model->title ?></span>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<div class="container service-box clearfix">
    <div class="detail">
        <div class="service-nav-box">
            <ul class="service-nav">
                <li class="on"><a title="服务导航" href="#范围"><i>服务<br />范围</i></a></li>
                <li><a title="服务导航" href="#价格"><i>服务<br />价格</i></a></li>
                <li><a title="服务导航" href="#详情"><i>服务<br />详情</i></a></li>
            </ul>
        </div>
        <div class="service-content">
            <div class="item">
                <div class="title"><span>服务范围<b></b><em id="范围" name="范围"></em></span></div>
                <div class="infotxt">
                    <?php

                    $province = Util::CreateProvinceSelector('广东省');



                    ?>
                </div>
            </div>
            <div class="item">
                <div class="title"><span>服务价格<b></b><em id="价格" name="价格"></em></span></div>
                <div class="infotxt xtable">
                    <table width="100%">
                        <tbody><tr>
                            <th style="color:#ff6600;">套餐类型</th>
                            <th colspan="3" style="color:#ff6600;">面积</th>
                            <th style="color:#ea5514;">价格</th>
                            <th colspan="2" style="color:#ff6600;">套餐内容</th>
                            <th colspan="2" style="color:#ff6600;">备注说明</th>
                        </tr>
                        <tr>
                            <th rowspan="6">大扫除A</th>
                            <th colspan="3">60m<sup>2</sup>以下</th>
                            <th>¥600 <!--2017.11.25改动之前是&yen;500--></th>
                            <th colspan="2" rowspan="6">去污保洁+擦玻璃+全屋消杀</th>
                            <th colspan="2" rowspan="6">不包含阳光房玻璃面积，<br>阳光房玻璃面积可以根据现场测量收费<br>200m<sup>2</sup>以上现场报价收费</th>
                        </tr>
                        <tr>
                            <th colspan="3">61m<sup>2</sup>-90m<sup>2</sup></th>
                            <th>¥780<!--2017.11.25改动之前是&yen;680--></th>
                        </tr>
                        <tr>
                            <th colspan="3">91m<sup>2</sup>-120m<sup>2</sup></th>
                            <th>¥980<!--2017.11.25改动之前是&yen;880--></th>
                        </tr>
                        <tr>
                            <th colspan="3">121m<sup>2</sup>-150m<sup>2</sup></th>
                            <th>¥1380<!--2017.11.25改动之前是&yen;1280--></th>
                        </tr>
                        <tr>
                            <th colspan="3">151m<sup>2</sup>-200m<sup>2</sup></th>
                            <th>¥1680<!--2017.11.25改动之前是&yen;1580--></th>
                        </tr>
                        <tr>
                            <th colspan="3">&gt;200m<sup>2</sup></th>
                            <th>¥9⁄m<sup>2</sup><br>（参考价）<!--2017.11.25改动新增的价格--></th>
                        </tr>
                        <tr>
                            <th rowspan="6">大扫除B</th>
                            <th colspan="3">60m<sup>2</sup>以下</th>
                            <th>¥500<!--2017.11.25改动之前是&yen;400--></th>
                            <th colspan="2" rowspan="6">去污保洁+擦玻璃</th>
                            <th colspan="2" rowspan="6">不包含全屋消杀，不包含阳光房玻璃面积，<br>阳光房玻璃面积可以根据现场测量收费<br>200m<sup>2</sup>以上现场报价收费</th>
                        </tr>
                        <tr>
                            <th colspan="3">61m<sup>2</sup>-90m<sup>2</sup></th>
                            <th>¥620<!--2017.11.25改动之前是&yen;520--></th>
                        </tr>
                        <tr>
                            <th colspan="3">91m<sup>2</sup>-120m<sup>2</sup></th>
                            <th>¥780<!--2017.11.25改动之前是&yen;680--></th>
                        </tr>
                        <tr>
                            <th colspan="3">121m<sup>2</sup>-150m<sup>2</sup></th>
                            <th>¥1080<!--2017.11.25改动之前是&yen;980--></th>
                        </tr>
                        <tr>
                            <th colspan="3">151m<sup>2</sup>-200m<sup>2</sup></th>
                            <th>¥1380<!--2017.11.25改动之前是&yen;1280--></th>
                        </tr>
                        <tr>
                            <th colspan="3">&gt;200m<sup>2</sup></th>
                            <th>¥7⁄m<sup>2</sup><br>（参考价）<!--2017.11.25改动新增的价格--></th>
                        </tr>
                        <tr>
                            <th rowspan="6">大扫除C</th>
                            <th colspan="3">60m<sup>2</sup>以下</th>
                            <th>¥400<!--2017.11.25改动之前是&yen;300--></th>
                            <th colspan="2" rowspan="6">去污保洁</th>
                            <th colspan="2" rowspan="6">不包含擦室内玻璃和全屋消杀<br>200m<sup>2</sup>以上现场报价收费</th>
                        </tr>
                        <tr>
                            <th colspan="3">61m<sup>2</sup>-90m<sup>2</sup></th>
                            <th>¥480<!--2017.11.25改动之前是&yen;380--></th>
                        </tr>
                        <tr>
                            <th colspan="3">91m<sup>2</sup>-120m<sup>2</sup></th>
                            <th>¥580<!--2017.11.25改动之前是&yen;480--></th>
                        </tr>
                        <tr>
                            <th colspan="3">121m<sup>2</sup>-150m<sup>2</sup></th>
                            <th>¥780<!--2017.11.25改动之前是&yen;680--></th>
                        </tr>
                        <tr>
                            <th colspan="3">151m<sup>2</sup>-200m<sup>2</sup></th>
                            <th>¥880<!--2017.11.25改动之前是&yen;780--></th>
                        </tr>
                        <tr><th colspan="3">&gt;200m<sup>2</sup></th>
                            <th>¥4⁄m<sup>2</sup><br>（参考价）<!--2017.11.25改动新增的价格--></th>
                        </tr>
                        <tr>
                            <th rowspan="6">大扫除D</th>
                            <th colspan="3">60m<sup>2</sup>以下</th>
                            <th>¥500<!--2017.11.25改动之前是&yen;400--></th>
                            <th colspan="2" rowspan="6">去污保洁+全屋消杀</th>
                            <th colspan="2" rowspan="6">不包含擦玻璃<br>200m<sup>2</sup>以上现场报价收费</th>
                        </tr>
                        <tr>
                            <th colspan="3">61m<sup>2</sup>-90m<sup>2</sup></th>
                            <th>¥620<!--2017.11.25改动之前是&yen;520--></th>
                        </tr>
                        <tr>
                            <th colspan="3">91m<sup>2</sup>-120m<sup>2</sup></th>
                            <th>¥780<!--2017.11.25改动之前是&yen;680--></th>
                        </tr>
                        <tr>
                            <th colspan="3">121m<sup>2</sup>-150m<sup>2</sup></th>
                            <th>¥1060<!--2017.11.25改动之前是&yen;960--></th>
                        </tr>
                        <tr>
                            <th colspan="3">151m<sup>2</sup>-200m<sup>2</sup></th>
                            <th>¥1180<!--2017.11.25改动之前是&yen;1080--></th>
                        </tr>
                        <tr><th colspan="3">&gt;200m<sup>2</sup></th>
                            <th>¥6⁄m<sup>2</sup><br>（参考价）<!--2017.11.25改动新增的价格--></th>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="item last">
                <div class="title"><span>服务详情<b></b><em id="详情" name="详情"></em></span></div>
                <div class="infotxt">
                    服务详情
                    <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
                    <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
                    <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
                </div>
            </div>
        </div>
    </div>
    <div class="form">
        <div class="tab-sidebox free-jijia">
            <div class="tab-sidebox-title">
                <h3>免费计价</h3>
            </div>
            <div class="tab-sidebox-content" id="sidebox-jijia">
                <form action="">
                    <div class="row">
                        <label>xxxxx</label>
                        <input type="text" />
                    </div>
                    <div class="row">
                        <label>xxxxx</label>
                        <input type="text" />
                    </div>
                    <div class="row">
                        <label>xxxxx</label>
                        <input type="text" />
                    </div>
                    <a class="submit-btn br5" href="javascript:;">立即发送</a>
                </form>
            </div>
        </div>
    </div>
</div>