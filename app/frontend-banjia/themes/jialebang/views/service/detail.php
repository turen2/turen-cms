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
$this->title = $curModel->title;

Swiper2Asset::register($this);
PinAsset::register($this);
DatetimePickerAsset::register($this);
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
                    555555555555555
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
                <h3>免费咨询</h3>
            </div>
            <div class="tab-sidebox-content" id="sidebox-jijia">
                <?= Html::beginForm() ?>
                <div class="row">
                    <h6 class="form-label"><i class="fa fa-map-marker"></i> 起点：</h6>
                    <p id="call-start">
                    <?= CascadeWidget::widget([
                        'province' => '广东省',
                        'cities' => [
                            '深圳市' => '深圳市',
                            '广州市' => '广州市',
                            '中山市' => '中山市',
                            '东莞市' => '东莞市',
                            '惠州市' => '惠州市',
                            '佛山市' => '佛山市'
                        ],
                        'formId' => 'call-start',
                    ]); ?>
                    </p>
                </div>
                <div class="row">
                    <h6 class="form-label"><i class="fa fa-map-marker"></i> 终点：</h6>
                    <p id="call-end">
                    <?= CascadeWidget::widget([
                        'province' => '广东省',
                        'cities' => [
                            '深圳市' => '深圳市',
                            '广州市' => '广州市',
                            '中山市' => '中山市',
                            '东莞市' => '东莞市',
                            '惠州市' => '惠州市',
                            '佛山市' => '佛山市'
                        ],
                        'formId' => 'call-end',
                    ]); ?>
                    </p>
                </div>
                <div class="row">
                    <h6 class="form-label"><i class="fa fa-users"></i> 搬运工人：</h6>
                    <?= Html::radioList('userNumber', '2人', ['1人' => '1人', '2人' => '2人', '3人' => '3人', '4人' => '4人', '更多' => '更多'], ['tag' => 'p', 'class' => 'call-number']) ?>
                </div>
                <div class="row">
                    <h6 class="form-label"><i class="fa fa-calendar-check-o"></i> 预约时间：</h6>
                    <p class="call-time">
                        <?= Html::textInput('callTime', date('Y年m月d日 H:i'), ['placeholder' => '选择日期']) ?>
                    </p>
                </div>
                <div class="row">
                    <h6 class="form-label"><i class="fa fa-truck"></i> 车型类型：</h6>
                    <p class="call-truck">
                        <?= Html::dropDownList('callTruck', null, [
                                '小货车' => '小货车（0.8m x 3m x 2.5m）',
                        ]) ?>
                        <br />
                        <a href="<?= Url::to(['page/info', 'slug' => 'chexing-shibei']) ?>" target="_blank"><i class="fa fa-info-circle"></i> 查看车型</a>
                    </p>
                </div>
                <div class="row">
                    <h6 class="form-label"><i class="fa fa-file-excel-o"></i> 要求：</h6>
                    <p class="call-order">
                        <?= Html::textarea('callOrder', '', ['class' => '', 'placeholder' => '请输入您的特殊要求']) ?>
                    </p>
                </div>
                <div class="row">
                    <h6 class="form-label"><i class="fa fa-calculator"></i> 费用：</h6>
                    <p class="call-price">线上下单统一9折起</p>
                </div>
                <a class="submit-btn br5" href="javascript:;">立即咨询</a>
                <?= Html::endForm() ?>
            </div>
        </div>
    </div>
</div>