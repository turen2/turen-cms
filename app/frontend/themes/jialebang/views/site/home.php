<?php 
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\base\Widget;
use app\widgets\LangSelector;
use app\assets\Swiper2Asset;

Swiper2Asset::register($this);

$js = <<<EOF
var mainSwiper = new Swiper('.slidebanner-wrap .swiper-container',{
    autoplay : 3200,//可选选项，自动滑动
    pagination: '.slidebanner-wrap .pagination',
    loop:true,
    grabCursor: true,
    paginationClickable: true
});
$('.slidebanner-wrap .arrow-left').on('click', function(e){
    e.preventDefault()
    mainSwiper.swipePrev()
});
$('.slidebanner-wrap .arrow-right').on('click', function(e){
    e.preventDefault()
    mainSwiper.swipeNext()
});

//主业务菜单
$('.main-nav .item-nav li').hover(
    function() {
	   $(this).css('borderColor', '#0099e9');
    },
    function() {
	   $(this).css('borderColor', '#FFF');
    }
);

var caseSwiper = new Swiper('.case-banner .swiper-container',{
    autoplay : 3200,//可选选项，自动滑动
    pagination: '.case-banner .pagination',
    loop:true,
    grabCursor: true,
    paginationClickable: true
});
$('.case-banner .arrow-left').on('click', function(e){
    e.preventDefault()
    caseSwiper.swipePrev()
});
$('.case-banner .arrow-right').on('click', function(e){
    e.preventDefault()
    caseSwiper.swipeNext()
});

//案例图片比例缩放效果
$('.case-list .list-left').hover(
    function() {
	   $(this).stop().animate({opacity:0.7},"fast").css({flter:"Alpha(Opacity=70)"});
    },
    function() {
	   $(this).stop().animate({opacity:1},"fast").css({flter:"Alpha(Opacity=100)"});
    }
);
$('.case-banner .swiper-slide img').hover(
    function () {
        $(this).removeClass("removeimg").addClass("fadeimg");
    },
    function () {
        $(this).removeClass("fadeimg").addClass("removeimg");
    }
);

//服务套餐
$('.gift-bag li').mouseenter(function() {
	$(this).find('.divA').stop().animate({bottom:'-60px'});
	$(this).find('.a2').css({left:'0'});
	$(this).children('.a2').find('.p4').css({left:'0'});
	$(this).children('.a2').find('.p5').css({left:'0'});
	$(this).children('.a2').find('.p6').css({transform:'scale(1)'});
	$(this).children('.a2').find('.p7').css({bottom:'5px'});
}).mouseleave(function() {
	$(this).find('.divA').stop().animate({bottom:'0px'});
	$(this).find('.a2').css({left:-$(this).width()});
	$(this).children('.a2').find('.p4').css({left:-$(this).width()});
	$(this).children('.a2').find('.p5').css({left:-$(this).width()});
	$(this).children('.a2').find('.p6').css({transform:'scale(1.3)'});
	$(this).children('.a2').find('.p7').css({bottom:'-50px'});
});
EOF;
$this->registerJs($js);

$this->title = '首页 - '.Yii::$app->params['config_site_name'];

$webUrl = Yii::getAlias('@web/');
?>

<div class="slidbox-margin container">
    <div class="slidform">
        <div class="slidbox-type">
            <div class="slidbox-type-wrap">
                <span class="on">免费报价</span>
                <span>免费电话</span>
            </div>
        </div>
        <div class="slidbox-form-wrap">
            <form>
                <p class="slidbox-form-text">仅需5秒，轻松获取在线报价</p>
                <div class="slidbox-form-con slidbox-free-quote">
                    <div class="slidbox-input">
                        <label onclick="$(this).siblings('input').focus();">建筑面积</label>
                        <input type="text" name="area" onkeydown="$(this).siblings('label').hide();" onblur="if(this.value=='')$(this).siblings('label').show()" class="slidbox-area-input" onkeyup="this.value=this.value.replace(/\D+/g,'')" autocomplete="off" autofocus="autofocus">
                        <span class="slidbox-area-unit">m²</span>
                    </div>
                    <div class="slidbox-input" style="z-index: 11;">
                        <div class="slidbox-huxing-wrap">
                            <div class="slidbox-huxing-solo">
                                <span class="slidbox-huxing-item">一室</span>
                                <em></em>
                                <ul>
                                    <li>
                                        <a href="javascript:;"> 一室</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="slidbox-huxing-solo">
                                <span class="slidbox-huxing-item"> 一厅</span>
                                <em>
                                </em>
                                <ul>
                                    <li>
                                        <a href="javascript:;">一厅</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="slidbox-huxing-solo mr0" style="margin-right:0;">
                                <span class="slidbox-huxing-item">一卫</span>
                                <em>
                                </em>
                                <ul>
                                    <li>
                                        <a href="javascript:;">一卫</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="slidbox-input">
                        <label onclick="$(this).siblings('input').focus();">您的手机号</label>
                        <input type="text" name="mobile" onkeydown="$(this).siblings('label').hide();" onblur="if(this.value=='')$(this).siblings('label').show();" maxlength="11" onkeyup="this.value=this.value.replace(/\D+/g,'')" autocomplete="off">
                    </div>
                </div>
                <p class="slidbox-user2know">
                    <i class="userCheck on"></i>我已阅读并且同意嘉乐邦网的<a href="" target="_blank">用户协议</a>
                </p>
                <a href="javascript:;" class="slidbox-obtain-btn">立即获取</a>
            </form>
        </div>
    </div>
    <div class="slidbox-intro-dist">
        <div class="slidebanner-wrap">
        	<a class="arrow arrow-left" href="#"><span></span></a> 
            <a class="arrow arrow-right" href="#"><span></span></a>
            <div class="swiper-container">
              <div class="swiper-wrapper">
                <div class="swiper-slide"> <img src="<?= $webUrl ?>images/module1.jpg"> </div>
                <div class="swiper-slide"> <img src="<?= $webUrl ?>images/module2.jpg"> </div>
                <div class="swiper-slide"> <img src="<?= $webUrl ?>images/module1.jpg"> </div>
                <div class="swiper-slide"> <img src="<?= $webUrl ?>images/module2.jpg"> </div>
              </div>
            </div>
            <div class="pagination"></div>
        </div>
        <div class="slidbox-intro-service">
            <a href="" target="_blank">
                <dl class="clearfix">
                    <dt class="fl">
                        <div class="slidbox-service-qjb">
                            <span></span>
                        </div>
                    </dt>
                    <dd>
                        <div class="slidbox-service-solo">
                            <h6>嘉乐邦协议</h6>
                            <p>1对1管家式服务</p>
                        </div>
                    </dd>
                </dl>
            </a>
            <a href="" target="_blank">
                <dl class="clearfix">
                    <dt class="fl">
                        <div class="slidbox-service-loan">
                            <span>
                            </span>
                        </div>
                    </dt>
                    <dd>
                        <div class="slidbox-service-solo">
                            <h6>家政贷款</h6>
                            <p>年利率3.35%起</p>
                        </div>
                    </dd>
                </dl>
            </a>
            <a href="" target="_blank">
                <dl class="clearfix">
                    <dt class="fl">
                        <div class="slidbox-service-jianli">
                            <span></span>
                        </div>
                    </dt>
                    <dd>
                        <div class="slidbox-service-solo">
                            <h6> 免费监理</h6>
                            <p>5次节点验收</p>
                        </div>
                    </dd>
                </dl>
            </a>
            <a href="" target="_blank" class="last">
                <dl class="clearfix">
                    <dt class="fl">
                        <div class="slidbox-service-jianli">
                            <span></span>
                        </div>
                    </dt>
                    <dd>
                        <div class="slidbox-service-solo">
                            <h6> 免费监理</h6>
                            <p>5次节点验收</p>
                        </div>
                    </dd>
                </dl>
            </a>
        </div>
    </div>
</div>

<div class="main-nav container">
    <ul class="item-nav clearfix">
        <li style="background: url(../images/nav/jzfw.png) no-repeat 50% 50%;">
            <h3>家政服务</h3>
            <p>洁净爱家 静心舒适</p>
            <p class="link clearfix">
            	<span><a href="">日常保洁</a></span>
            	<span><a href="">深度保洁</a></span>
            	<span><a href="">开荒保洁</a></span>
            	<span><a href="">抽油烟机清洗</a></span>
            	<span><a href="">冰箱清洗</a></span>
            	<span><a href="">洗衣机清洗</a></span>
            	<span><a href="">空调清洗</a></span>
            	<span><a href="">擦玻璃</a></span>
            </p>
        </li>
        <li style="background: url(../images/nav/gdst.png) no-repeat 50% 50%;">
            <h3>管道疏通</h3>
            <p>极速上门 实时响应</p>
            <p class="link clearfix">
            	<span><a href="">浴缸疏通</a></span>
            	<span><a href="">马桶疏通</a></span>
            	<span><a href="">洗手盆疏通</a></span>
            	<span><a href="">洗菜盆疏通</a></span>
            	<span><a href="">地漏疏通</a></span>
            	<span><a href="">下水道疏通</a></span>
            	<span><a href="">其它疏通</a></span>
            </p>
        </li>
        <li style="background: url(../images/nav/hbqc.png) no-repeat 50% 50%;">
            <h3>环保除虫</h3>
            <p>服务专业 方便快捷</p>
            <p class="link clearfix">
            	<span><a href="">除虫灭鼠</a></span>
            	<span><a href="">除甲醛</a></span>
            	<span><a href="">新风系统</a></span>
            	<span><a href="">除异味</a></span>
            	<span><a href="">除尘除螨</a></span>
            </p>
        </li>
        <li style="background: url(../images/nav/bjby.png) no-repeat 50% 50%;">
            <h3>搬家搬运</h3>
            <p>快速服务 贴心协议障</p>
            <p class="link clearfix">
            	<span><a href="">居民搬家</a></span>
                <span><a href="">办公室搬迁</a></span>
                <span><a href="">工厂搬迁</a></span>
                <span><a href="">长短途运输</a></span>
                <span><a href="">钢琴搬运</a></span>
                <span><a href="">学校搬迁</a></span>
                <span><a href="">医院搬迁</a></span>
                <span><a href="">网吧搬迁</a></span>
            </p>
        </li>
        <li class="last" style="background: url(../images/nav/gift.png) no-repeat 50% 50%;">
            <h3>咨询我们</h3>
            <p>发现更多 优质服务</p>
            <a class="call-me" href="" title="在线咨询"></a>
        </li>
    </ul>
</div>

<div class="gift-bag container">
	<div class="jia-head">
		<h2 class="fl">服务优惠套餐<span class="txt">一站式的服务</span></h2>
	</div>
    <ul class="clearfix">
        <li>
            <a href="" class="a1">
                <img src="<?= $webUrl ?>images/gift/10556208_161709842590030.jpg">
                <div class="divA">
                    <p class="p1">
                        迪拜六日跟团游
                    </p>
                    <p class="p2">
                        香港直飞+精选阿联酋航空(A380豪华客机)+当晚抵达全程入住4晚五星酒店！
                    </p>
                    <p class="p3">
                        ¥
                        <span>
                            6999
                        </span>
                        起
                    </p>
                </div>
            </a>
            <a href="" class="a2">
                <p class="p4">
                    迪拜六日跟团游
                </p>
                <p class="p5">
                    香港直飞+精选阿联酋航空(A380豪华客机)+当晚抵达全
                    <br>
                    程入住4晚五星酒店！
                </p>
                <p class="p6">
                    ¥
                    <span>
                        6999
                    </span>
                    起
                </p>
                <p class="p7">
                    查看详情&gt;
                </p>
            </a>
        </li>
        <li>
            <a href="" class="a1">
                <img src="<?= $webUrl ?>images/gift/10552347_231610350949916.jpg">
                <div class="divA">
                    <p class="p1">
                        埃及+迪拜10日跟团游
                    </p>
                    <p class="p2">
                        全程4-5星酒店/金字塔/博特馆/度假圣地红海洪加达/迪拜/阿布扎比一次走遍！
                    </p>
                    <p class="p3">
                        ¥
                        <span>
                            8399
                        </span>
                        起
                    </p>
                </div>
            </a>
            <a href="" class="a2">
                <p class="p4">
                    埃及+迪拜10日跟团游
                </p>
                <p class="p5">
                    全程4-5星酒店/金字塔/博特馆/度假圣地红海洪加达
                    <br>
                    /迪拜/阿布扎比一次走遍！
                </p>
                <p class="p6">
                    ¥
                    <span>
                        8399
                    </span>
                    起
                </p>
                <p class="p7">
                    查看详情&gt;
                </p>
            </a>
        </li>
        <li class="last">
            <a href="" class="a1">
                <img src="<?= $webUrl ?>images/gift/10527181_887630653793940.jpg">
                <div class="divA">
                    <p class="p1">
                        土耳其10日跟团游
                    </p>
                    <p class="p2">
                        全程五星/免费车载WIFI/棉花堡/爱琴海/ 特洛伊古城/伊斯坦布尔风情!
                    </p>
                    <p class="p3">
                        ¥
                        <span>
                            8499
                        </span>
                        起
                    </p>
                </div>
            </a>
            <a href="" class="a2">
                <p class="p4">
                    土耳其10日跟团游
                </p>
                <p class="p5">
                    全程五星/免费车载WIFI/棉花堡/爱琴海/
                    <br>
                    特洛伊古城/伊斯坦布尔风情!！
                </p>
                <p class="p6">
                    ¥
                    <span>
                        8499
                    </span>
                    起
                </p>
                <p class="p7">
                    查看详情&gt;
                </p>
            </a>
        </li>
        <li>
            <a href="" class="a1">
                <img src="<?= $webUrl ?>images/gift/224607_162375013321817.jpg">
                <div class="divA">
                    <p class="p1">
                        泰国曼谷+金沙岛+芭堤雅6日跟团游
                    </p>
                    <p class="p2">
                        香港往返/深圳往返【德国啤酒屋】+品尝当地著名【78层自助餐】/品质保证
                    </p>
                    <p class="p3">
                        ¥
                        <span>
                            2199
                        </span>
                        起
                    </p>
                </div>
            </a>
            <a href="" class="a2">
                <p class="p4">
                    泰国曼谷+金沙+芭堤雅6日跟团游
                </p>
                <p class="p5">
                    香港往返/深圳往返【德国啤酒屋】+品尝当地著名
                    <br>
                    【78层自助餐】/品质保证
                </p>
                <p class="p6">
                    ¥
                    <span>
                        2199
                    </span>
                    起
                </p>
                <p class="p7">
                    查看详情&gt;
                </p>
            </a>
        </li>
        <li>
            <a href="" class="a1">
                <img src="<?= $webUrl ?>images/gift/10527181_887630653793940.jpg">
                <div class="divA">
                    <p class="p1">
                        土耳其10日跟团游
                    </p>
                    <p class="p2">
                        全程五星/免费车载WIFI/棉花堡/爱琴海/ 特洛伊古城/伊斯坦布尔风情!
                    </p>
                    <p class="p3">
                        ¥
                        <span>
                            8499
                        </span>
                        起
                    </p>
                </div>
            </a>
            <a href="" class="a2">
                <p class="p4">
                    土耳其10日跟团游
                </p>
                <p class="p5">
                    全程五星/免费车载WIFI/棉花堡/爱琴海/
                    <br>
                    特洛伊古城/伊斯坦布尔风情!！
                </p>
                <p class="p6">
                    ¥
                    <span>
                        8499
                    </span>
                    起
                </p>
                <p class="p7">
                    查看详情&gt;
                </p>
            </a>
        </li>
        <li class="last">
            <a href="" class="a1">
                <img src="<?= $webUrl ?>images/gift/224607_162375013321817.jpg">
                <div class="divA">
                    <p class="p1">
                        泰国曼谷+金沙岛+芭堤雅6日跟团游
                    </p>
                    <p class="p2">
                        香港往返/深圳往返【德国啤酒屋】+品尝当地著名【78层自助餐】/品质保证
                    </p>
                    <p class="p3">
                        ¥
                        <span>
                            2199
                        </span>
                        起
                    </p>
                </div>
            </a>
            <a href="" class="a2">
                <p class="p4">
                    泰国曼谷+金沙+芭堤雅6日跟团游
                </p>
                <p class="p5">
                    香港往返/深圳往返【德国啤酒屋】+品尝当地著名
                    <br>
                    【78层自助餐】/品质保证
                </p>
                <p class="p6">
                    ¥
                    <span>
                        2199
                    </span>
                    起
                </p>
                <p class="p7">
                    查看详情&gt;
                </p>
            </a>
        </li>
    </ul>
</div>

<div class="jia-case container">
    <div class="img-top clearfix">
        <h2 class="fl">现场案例动态<span class="txt">一站式的服务、服务后期持续跟进</span></h2>
        <div class="img-nav fr">
            <ul class="clearfix">
                <li>
                    <a href="" target="_blank">玄关</a>
                    <span class="line-p">|</span>
                </li>
                <li>
                    <a href="" target="_blank">玄关</a>
                    <span class="line-p">|</span>
                </li>
                <li>
                    <a href="" target="_blank">玄关</a>
                    <span class="line-p">|</span>
                </li>
                <li>
                    <a class="more-info" href="" target="_blank">更多效果图 &gt;</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="case-box clearfix">
        <div class="case-banner">
            <a class="arrow arrow-left" href="#"><span></span></a>
            <a class="arrow arrow-right" href="#"><span></span></a>
        	<div class="swiper-container">
              <div class="swiper-wrapper">
                  <div class="swiper-slide">
					<a href="" target="_blank">
						<img src="//tgi1.jia.com/122/269/22269481.jpg" alt="夏季来临">
            			<div class="back-screen">
            				<p class="big-font">夏季来临</p>
            				<p class="small-font">快给家里降点温</p>
            			</div>
            		</a>
                  </div>
                  <div class="swiper-slide">
                  	<a href="" target="_blank">
            			<img src="//tgi12.jia.com/122/269/22269485.jpg" alt="打造粉色之家">
            			<div class="back-screen">
            				<p class="big-font">打造粉色之家</p>
            				<p class="small-font">圆你一个公主梦</p>
            			</div>
            		</a>
                  </div>
                  <div class="swiper-slide">
                  	<a href="" target="_blank">
            			<img src="//tgi1.jia.com/122/269/22269481.jpg" alt="夏季来临">
            			<div class="back-screen">
            				<p class="big-font">夏季来临</p>
            				<p class="small-font">快给家里降点温</p>
            			</div>
            		</a>
                  </div>
              </div>
            </div>
            <div class="pagination"></div>
        </div>
        <div class="case-list">
            <div class="list-left">
                <a href="" target="_blank">
                    <img src="//tgi13.jia.com/122/269/22269527.jpg" alt="搬搬家案例搬家案例家案例">
                    <div class="case-gloab">
                        <span class="case-gloab-title">搬搬家案例搬家案例家案例</span>
                    </div>
                </a>
            </div>
            <div class="list-left">
                <a href="" target="_blank">
                    <img src="//tgi13.jia.com/122/269/22269527.jpg" alt="搬搬家案例搬家案例家案例">
                    <div class="case-gloab">
                        <span class="case-gloab-title">搬搬家案例搬家案例家案例</span>
                    </div>
                </a>
            </div>
            <div class="list-left mr0">
                <a href="" target="_blank">
                    <img src="//tgi13.jia.com/122/269/22269527.jpg" alt="搬搬家案例搬家案例家案例">
                    <div class="case-gloab">
                        <span class="case-gloab-title">搬搬家案例搬家案例家案例</span>
                    </div>
                </a>
            </div>
            <div class="list-left">
                <a href="" target="_blank">
                    <img src="//tgi1.jia.com/122/269/22269542.jpg" alt="家政清洁家政清洁家政清洁">
                    <div class="case-gloab">
                        <span class="case-gloab-title">家政清洁家政清洁家政清洁</span>
                    </div>
                </a>
            </div>
            <div class="list-left">
                <a href="" target="_blank">
                    <img src="//tgi1.jia.com/122/269/22269542.jpg" alt="家政清洁家政清洁家政清洁">
                    <div class="case-gloab">
                        <span class="case-gloab-title">家政清洁家政清洁家政清洁</span>
                    </div>
                </a>
            </div>
            <div class="list-left mr0">
                <a href="" target="_blank">
                    <img src="//tgi1.jia.com/122/269/22269542.jpg" alt="家政清洁家政清洁家政清洁">
                    <div class="case-gloab">
                        <span class="case-gloab-title">家政清洁家政清洁家政清洁</span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="jia-baike container">
	<div class="jia-head">
		<h2 class="fl">百科大全&服务协议障<span class="txt">一站式的服务</span></h2>
	</div>
	<div class="clearfix">
        <ul class="baike-list clearfix">
            <li>
                <a href="" target="_blank">
                    <dl class="mod-wrap mod-1">
                        <dt>
                            <img src="//oneimg3.jia.com/content/public/resource/12808457/2017/06/275196_field_7_1498455803.png" width="95" height="95">
                        </dt>
                        <dd>
                            <h4>家政百事通</h4>
                            <p>有问必答</p>
                        </dd>
                    </dl>
                </a>
            </li>
            <li>
                <a href="" target="_blank">
                    <dl class="mod-wrap mod-2">
                        <dt>
                            <img src="//oneimg4.jia.com/content/public/resource/12808457/2017/05/275197_field_7_1495076838.jpg" width="95" height="95">
                        </dt>
                        <dd>
                            <h4>
                                买贵怎么办？
                            </h4>
                            <p>
                                嘉乐邦网为您协议价护航
                            </p>
                        </dd>
                    </dl>
                </a>
            </li>
            <li>
                <a href="" target="_blank">
                    <dl class="mod-wrap mod-3">
                        <dt>
                            <img src="//oneimg5.jia.com/content/public/resource/12808457/2017/04/275198_field_7_1493092697.jpg" width="95" height="95">
                        </dt>
                        <dd>
                            <h4>
                                家政嘉乐邦协议服务
                            </h4>
                            <p>
                                第三方监管为您护航
                            </p>
                        </dd>
                    </dl>
                </a>
            </li>
            <li>
                <a href="" target="_blank">
                    <dl class="mod-wrap mod-4">
                        <dt>
                            <img src="//oneimg1.jia.com/content/public/resource/12808457/2017/05/275199_field_7_1494299392.png" width="95" height="95">
                        </dt>
                        <dd>
                            <h4>
                                嘉乐邦家政学堂
                            </h4>
                            <p>
                                家政百事通公益交流
                            </p>
                        </dd>
                    </dl>
                </a>
            </li>
            <li>
                <a href="" target="_blank">
                    <dl class="mod-wrap mod-5">
                        <dt>
                            <img src="//oneimg2.jia.com/content/public/resource/12808457/2017/06/275200_field_7_1498455723.png" width="95" height="95">
                        </dt>
                        <dd>
                            <h4>
                                纯公益免费验房
                            </h4>
                            <p>
                                同小区满5户即可参加
                            </p>
                        </dd>
                    </dl>
                </a>
            </li>
            <li>
                <a href="" target="_blank">
                    <dl class="mod-wrap mod-6">
                        <dt>
                            <img src="//oneimg3.jia.com/content/public/resource/12808457/2017/06/275201_field_7_1496281383.png" width="95" height="95">
                        </dt>
                        <dd>
                            <h4>
                                新房质量检测
                            </h4>
                            <p>
                                领取680元验房卡
                            </p>
                        </dd>
                    </dl>
                </a>
            </li>
        </ul>
        <div class="right-list-box">
            <div class="box-hd">
                <h3 class="png-fix-bg">售后跟进</h3>
                <a class="more" href="" target="_blank">更多&gt;&gt;</a>
                <ul class="notice-list">
                    <li>
                        <span class="png-fix-bg">
                            <a target="_blank" href="" title="[受理中]正适装饰无赖公司，骗子，大家一定不要被它坑了，骗走了血汗钱">
                                [受理中]正适装饰无赖公司，骗子，大家一定不要被它坑了，骗走了血汗钱
                            </a>
                        </span>
                    </li>
                    <li>
                        <span class="png-fix-bg">
                            <a target="_blank" href="" title="[表扬]表扬嘉乐邦监徐勇平">
                                [表扬]表扬嘉乐邦监徐勇平
                            </a>
                        </span>
                    </li>
                    <li>
                        <span class="png-fix-bg">
                            <a target="_blank" href="" title="[受理中]教训深刻">
                                [受理中]教训深刻
                            </a>
                        </span>
                    </li>
                    <li>
                        <span class="png-fix-bg">
                            <a target="_blank" href="" title="[表扬]嘉乐邦洪亮　监理包公">
                                [表扬]嘉乐邦洪亮　监理包公
                            </a>
                        </span>
                    </li>
                    <li>
                        <span class="png-fix-bg last">
                            <a target="_blank" href="" title="[已解决]与t6国际设计家政过程中有争议的问题现已解决">
                                [已解决]与t6国际设计家政过程中有争议的问题现已解决
                            </a>
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="jia-knowledge clearfix">
        <dl class="box">
            <dt>
                <h3>家政知识</h3>
                <a href=" target="_blank" class="more">更多&gt;</a>
            </dt>
            <dd>
                <p>
                    <a href="">
                        常用的水槽类型 2018水槽品牌推荐
                    </a>
                </p>
                <p>
                    <a href="">
                        灰色地砖家政效果图 高级灰的名头可不是白叫的
                    </a>
                </p>
                <p>
                    <a href="">
                        钛合金门窗多少钱一平方 钛合金门窗优点有哪些
                    </a>
                </p>
                <p>
                    <a href="">
                        不锈钢厨房台面怎么样 不锈钢和石英石台面哪个好
                    </a>
                </p>
                <p>
                    <a href="">
                        三室两厅的家政案例 90平北欧风新房欣赏
                    </a>
                </p>
            </dd>
        </dl>
        <dl class="box">
            <dt>
                <h3>
                    建材知识
                </h3>
                <a href="" target="_blank" class="more">更多&gt;</a>
            </dt>
            <dd>
                <p>
                    <a href="">
                        洁具品牌推荐 洁具选购技巧
                    </a>
                </p>
                <p>
                    <a href="">
                        门业厂家推荐 如何提防卖门奸商
                    </a>
                </p>
                <p>
                    <a href="">
                        toto 高仪 科勒哪个好 殿堂级卫浴实力大比拼
                    </a>
                </p>
                <p>
                    <a href="">
                        水磨石地面施工价格是多少 如何做好水磨石地面的施工
                    </a>
                </p>
                <p>
                    <a href="">
                        地砖效果图鉴赏 五款时尚美观地砖推荐
                    </a>
                </p>
            </dd>
        </dl>
        <dl class="box">
            <dt>
                <h3>家居知识</h3>
                <a href="" target="_blank" class="more">更多&gt;</a>
            </dt>
            <dd>
                <p>
                    <a href="">
                        生态板十大名牌排名榜 中国十大板材品牌排行
                    </a>
                </p>
                <p>
                    <a href="">
                        电视墙2018最新款造型 六款时尚电视墙效果图
                    </a>
                </p>
                <p>
                    <a href="">
                        橱柜门颜色效果图大全 八款橱柜常用色推荐
                    </a>
                </p>
                <p>
                    <a href="">
                        什么是简中式家装 简中式家装家政注意事项
                    </a>
                </p>
                <p>
                    <a href="">
                        坐便器坑距一般是多少 坐便器都有哪些品牌
                    </a>
                </p>
            </dd>
        </dl>
    </div>
</div>

<div class="container">
    <div class="jia-baike container">
        <div class="jia-head">
            <h2 class="fl">百科大全&amp;服务协议障<span class="txt">一站式的服务</span></h2>
        </div>
        <div class="clearfix">
            http://wh.ikongjian.com/底部的友链和扇形展示
        </div>
    </div>
</div>

<div class="company-history">
	<img src="<?= $webUrl ?>images/company-history.png" />
</div>