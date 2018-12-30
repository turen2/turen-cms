<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

$webUrl = Yii::getAlias('@web/');

use yii\helpers\Url; ?>

<div class="container block slide-form">
    <div class="main-slide fl">幻灯片轮播+免费咨询（http://91.jiaju.sina.com.cn/bj/）

    <br /><br />
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


    </div>
    <div class="call-form">订单滚动+公司公告列表</div>
</div>

<div class="container block hot-item">
    <div class="head-title"><h2>推荐热门项目<span class="txt">缩小的子标题</span></h2></div>
    <div class="item-list">
        <ul>
            <li>项目1</li>
            <li>项目2</li>
        </ul>
    </div>
</div>

<div class="container block work-flow">
    <div class="head-title"><h2>服务流程<span class="txt">缩小的子标题</span></h2></div>
    <div class="flow-content">
        <p>服务流程内容</p>
    </div>
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
