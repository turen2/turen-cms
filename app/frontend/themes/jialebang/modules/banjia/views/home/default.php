<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use app\assets\Swiper2Asset;
use common\models\ext\Ad;
use yii\helpers\Url;

$this->title = '嘉乐邦首页';
$webUrl = Yii::getAlias('@web/');

Swiper2Asset::register($this);
$js = <<<EOF
var homeMainAdSwiper = new Swiper('.home-main-ad .swiper-container', {
    pagination: '.home-main-ad .swiper-container .pagination',
    paginationClickable: true,
    slidesPerView: 'auto'
});
$('.home-main-ad .arrow-left').on('click', function(e){
    e.preventDefault()
    homeMainAdSwiper.swipePrev()
});
$('.home-main-ad .arrow-right').on('click', function(e){
    e.preventDefault()
    homeMainAdSwiper.swipeNext()
});
EOF;
$this->registerJs($js);
?>

<div class="container block slide-form">
    <div class="main-slide fl">
        <?php $mainAds = Ad::AdListByAdTypeId(Yii::$app->params['config_face_banjia_cn_home_main_ad_type_id']); ?>
        <?php if($mainAds) { ?>
            <div class="home-main-ad">
                <a class="arrow arrow-left" href="#"></a>
                <a class="arrow arrow-right" href="#"></a>
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <?php foreach ($mainAds as $index => $mainAd) { ?>
                            <div class="swiper-slide">
                                <img height="370px" alt="<?= $mainAd['title'] ?>" src="<?= empty($mainAd['picurl'])?ImageHelper::getNopic():Yii::$app->aliyunoss->getObjectUrl($mainAd['picurl'], true) ?>" />
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
    <div class="call-form">
        <div class="home-pulish">
            <h3 class="title">10秒客服回电</h3>
            <form action="" class="">
                <div class="form-items">
                    <span class="label">手机号码</span>
                    <input type="text" name="phone" maxlength="11" placeholder="请输入手机号码" />
                </div>
                <div class="form-items">
                    <span class="label">区域选择</span>
                    <select name="area">
                        <option value="-1">选择区域</option>
                        <option value="深圳市">深圳市</option>
                        <option value="广州市">广州市</option>
                        <option value="东莞市">东莞市</option>
                        <option value="珠海市">珠海市</option>
                        <option value="中山市">中山市</option>
                        <option value="惠州市">惠州市</option>
                        <option value="其它区域">其它区域</option>
                    </select>
                </div>
                <div class="form-items">
                    <span class="label">业务类型</span>
                    <select name="type">
                        <option value="-1">选择区域</option>
                        <option value="居民搬家">居民搬家</option>
                        <option value="办公室搬迁">办公室搬迁</option>
                        <option value="厂房搬迁">厂房搬迁</option>
                        <option value="学校搬迁">学校搬迁</option>
                        <option value="钢琴搬运">钢琴搬运</option>
                        <option value="仓库搬迁">仓库搬迁</option>
                        <option value="服务器搬迁">服务器搬迁</option>
                        <option value="空调移机">空调移机</option>
                        <option value="长途搬家">长途搬家</option>
                        <option value="其它类型">其它类型</option>
                    </select>
                </div>

                <a class="submit-btn" href="javascript:;">立即获取</a>
            </form>
            <p class="text">*声明：为了您的权益，您的隐私将被严格保密！</p>
        </div>
    </div>
</div>

<div class="container block hot-item">
    <div class="head-title"><h2>推荐热门项目<span class="txt">缩小的子标题</span></h2></div>
    <div class="item-list">
        <ul>
            <li>项目1</li>
            <li>项目2</li>
        </ul>
        <?php
        echo Yii::$app->params['config_face_banjia_cn_main_nav_id'];
        echo '<br />';
        echo Yii::$app->params['config_face_banjia_cn_left_bottom_block_id'];
        echo '<br />';
        echo Yii::$app->params['config_face_banjia_cn_left_top_block_id'];
        echo '<br />';
        ?>

    </div>
</div>

<div class="container block work-flow">
    <div class="head-title"><h2>服务流程<span class="txt">缩小的子标题</span></h2></div>
    <div class="flow-content">
        <p>服务流程内容</p>
    </div>
</div>

<div style="background: #000;color: white">
    <br />
    下单滚动效果：http://ask.17house.com/c-all/1.html
    <br />
    幻灯片轮播+免费咨询（http://91.jiaju.sina.com.cn/bj/）
    <br />
    全局链接：
    <br />
    <a href="<?= Url::to(['/banjia/news/list']) ?>" target="_blank">新闻news</a>
    <br />
    <a href="<?= Url::to(['/banjia/baike/list']) ?>" target="_blank">百科baike</a>
    <br />
    <a href="<?= Url::to(['/banjia/faqs/index']) ?>" target="_blank">问答faqs</a>
    <br />
    <a href="<?= Url::to(['/banjia/service/detail']) ?>" target="_blank">服务service</a>
    <br />
    <a href="<?= Url::to(['/banjia/calculator/index']) ?>" target="_blank">计价器calculator</a>
    <br />
    <a href="<?= Url::to(['/banjia/case/list']) ?>" target="_blank">项目case</a>
    <br />
    <a href="<?= Url::to(['/banjia/page/info']) ?>" target="_blank">通用简单页面page</a>
    <br />
    <a href="<?= Url::to(['/banjia/calendar/index']) ?>" target="_blank">吉日日历calendar</a>
    <br />
    <a href="<?= Url::to(['/banjia/case/list']) ?>" target="_blank">案例</a>

    <br />所有使用装修之家的：弹出窗口样式，各种确认窗口，填写窗口

    订单滚动+公司公告列表，滚动：http://shenzhen.17house.com/xftc/
    <br />
    头部：https://wenda.tobosu.com/

</div>

<div class="container block news-center">
    <div class="head-title"><h2>新闻中心<span class="txt">缩小的子标题</span></h2></div>
    <div class="news-list">
        <p>新闻列表</p>
    </div>
</div>

<div class="container block work-case">
    <div class="head-title"><h2>案例现场<span class="txt">缩小的子标题</span></h2></div>
    <div class="case-list">
        <p>案例列表</p>
    </div>
</div>

<div class="container block user-comment">
    <div class="head-title"><h2>用户好评<span class="txt">缩小的子标题</span></h2></div>
    <div class="comment-list">
        <p>评论列表</p>
        <p>首页客户好评：https://2.swiper.com.cn/demo/senior/index.html</p>
    </div>
</div>

<div class="container block work-star">
    <div class="head-title"><h2>劳动之星<span class="txt">缩小的子标题</span></h2></div>
    <div class="star-list">
        <p>模范列表</p>
    </div>
</div>

<div class="home-data-show">
    <div class="container content-wrapper">
        <div class="home-data-box">
            <img src="<?= $webUrl ?>images/banjia/index__data_mini.png">
        </div>
        <div class="home-img-box">
            <img src="<?= $webUrl ?>images/banjia/index_data_represent.png" class="home-img">
            <p class="home-slogan-top">嘉乐邦八年行业经验</p>
            <p class="home-slogan-bottom">深 度 服 务 于 珠 三 角 客 户</p>
        </div>
    </div>
    <img class="home-bg" src="<?= $webUrl ?>images/banjia/index_data_bg.jpg">
</div>
