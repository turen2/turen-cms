<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use app\assets\DatetimePickerAsset;
use app\assets\PinAsset;
use app\assets\Swiper2Asset;
use app\widgets\cascade\CascadeWidget;
use common\helpers\ImageHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
$this->currentModel = $curModel;

//$this->title = $curModel->title;
//$this->title = $curModel->title;

Swiper2Asset::register($this);
PinAsset::register($this);
DatetimePickerAsset::register($this);
$js = <<<EOF
var swiper = new Swiper('.service-top-slide .swiper-container', {
    loop: true,//循环切换
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
$('#sidebox-jijia').pin({
    padding: {top: 100}
});
$('.service-nav li').on('click', function() {
    $('.service-nav li').removeClass('on').eq($(this).index()).addClass('on');
});

//日期选择
$.datetimepicker.setLocale('ch');
$('.call-time input').datetimepicker({
    'elem':'.call-time input',
    'format':'Y年m月d日 H:i',
    'allowTimes':[
        '06:00', '07:00', '08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00', '22:00', '23:00'
    ]
});

//初始化label
$('.call-number input:checked').each(function() {
    $(this).parent().addClass('on');
});
$('.call-number input').on('click', function() {
    $('.call-number input').parent().removeClass('on');
    $(this).parent().addClass('on');
    //console.log($(this).val());
});

//

//测试
//$(window).scroll(function() {
//    console.log($('.service-slide-box').offset().top);
//});
EOF;
$this->registerJs($js);
//var_dump($curModel->attributes);exit;
//diyfield_service_price//价格
//diyfield_service_item//项目范围
//content//详情
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
                    <?= $curModel->diyfield_service_item ?>
                </div>
            </div>
            <div class="item">
                <div class="title"><span>服务价格<b></b><em id="价格" name="价格"></em></span></div>
                <div class="infotxt xtable">
                    <?= $curModel->diyfield_service_price ?>
                </div>
            </div>
            <div class="item last">
                <div class="title"><span>服务详情<b></b><em id="详情" name="详情"></em></span></div>
                <div class="infotxt">
                    <?= $curModel->content ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form">
        <?= $this->render('/common/_sidebox_free_jia', ['slug' => $slug]) ?>
    </div>
</div>