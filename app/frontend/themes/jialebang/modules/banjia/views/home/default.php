<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use app\assets\Swiper2Asset;
use common\helpers\ImageHelper;
use common\models\ext\Ad;
use yii\helpers\Url;

$this->title = '嘉乐邦首页';
$webUrl = Yii::getAlias('@web/');

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
$('.home-main-ad .arrow-left').on('click', function(e){
    e.preventDefault();
    homeMainAdSwiper.swipeNext();
});
$('.home-main-ad .arrow-right').on('click', function(e){
    e.preventDefault();
    homeMainAdSwiper.swipePrev();
});

//下单跳动效果
var callOrderSwiper = new Swiper('.call-form .swiper-container', {
    mode: 'vertical',//纵向模式
    loop: true,//循环
    autoplay: 2500,//自动播放且间隔为3秒
    autoplayDisableOnInteraction: true,//用户操作后，autoplay将禁止
});

//案例现场
var caseSwiper = new Swiper('.case-banner .swiper-container', {
    loop: true,//循环
    autoplay : 3200,//可选选项，自动滑动
    pagination: '.case-banner .pagination',
    grabCursor: true,
    paginationClickable: true,
    autoplayDisableOnInteraction: true,//用户操作后，autoplay将禁止
});
$('.case-banner .arrow-left').on('click', function(e){
    e.preventDefault()
    caseSwiper.swipePrev()
});
$('.case-banner .arrow-right').on('click', function(e){
    e.preventDefault()
    caseSwiper.swipeNext()
});
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

//精选服务
$('.hot-item li').mouseenter(function() {
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
?>

<div class="container block slide-form">
    <div class="main-slide fl">
        <?php $mainAds = Ad::AdListByAdTypeId(Yii::$app->params['config_face_banjia_cn_home_main_ad_type_id']); ?>
        <?php if($mainAds) { ?>
            <div class="home-main-ad">
                <a class="arrow arrow-left" title="向左滑动" href="#"></a>
                <a class="arrow arrow-right" title="向右滑动" href="#"></a>
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <?php foreach ($mainAds as $index => $mainAd) { ?>
                            <div class="swiper-slide">
                                <a href="<?= $mainAd['linkurl'] ?>">
                                    <img height="370px" alt="<?= $mainAd['title'] ?>" src="<?= empty($mainAd['picurl'])?ImageHelper::getNopic():Yii::$app->aliyunoss->getObjectUrl($mainAd['picurl'], true) ?>" />
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
    <div class="call-form">
        <div class="home-pulish">
            <h3 class="title">轻松获取在线报价</h3>
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
                <a class="submit-btn" href="javascript:;">立即免费回电</a>
            </form>
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">1分钟前王先生****4527已预约</div>
                    <div class="swiper-slide">2分钟前王先生****4527已预约</div>
                    <div class="swiper-slide">3分钟前王先生****4527已预约</div>
                    <div class="swiper-slide">4分钟前王先生****4527已预约</div>
                    <div class="swiper-slide">5分钟前王先生****4527已预约</div>
                    <div class="swiper-slide">6分钟前王先生****4527已预约</div>
                    <div class="swiper-slide">7分钟前王先生****4527已预约</div>
                    <div class="swiper-slide">8分钟前王先生****4527已预约</div>
                    <div class="swiper-slide">9分钟前王先生****4527已预约</div>
                    <div class="swiper-slide">10分钟前王先生****4527已预约</div>
                </div>
            </div>
            <p class="text"><span class="red">*</span>声明：为了您的权益，您的隐私将被严格保密！</p>
        </div>
    </div>
</div>

<div class="container block work-flow">
    <div class="head-title"><h2>服务流程<span class="txt">标准化质量输出</span></h2></div>
    <div class="flow-content">
        <ul class="clearfix">
            <li class="first">
                <i class="insqzxfw_img1"></i>
                <b>免费咨询</b>
                <p>预约成功，安排上门服务</p>
            </li>
            <li>
                <i class="insqzxfw_img2"></i>
                <b>在线方案</b>
                <p>客服在线定制最优方案</p>
            </li>
            <li>
                <i class="insqzxfw_img3"></i>
                <b>售后保障</b>
                <p>全程客服跟踪，服务质量有保障</p>
            </li>
            <li class="last">
                <i class="insqzxfw_img4"></i>
                <b>优惠活动</b>
                <p>预约即可享受9折优惠</p>
            </li>
        </ul>
        <div class="insqzxfw_but" style="display: none;"><a href="https://www.jiazhuang.com/baojia_3/" target="_blank">马上预约</a></div>
    </div>
</div>

<div class="container block hot-item">
    <div class="head-title"><h2>精选服务<span class="txt">热门精选服务到家</span></h2></div>
    <ul class="clearfix">
        <li>
            <a href="javascript:;" class="a1">
                <img src="<?= $webUrl ?>images/gift/10556208_161709842590030.jpg">
                <div class="divA">
                    <p class="p1">
                        居民搬家
                    </p>
                    <p class="p2">
                        香港直飞+精选阿联酋航空(A380豪华客机)+当晚抵达全程入住4晚五星酒店！
                    </p>
                    <p class="p3">
                        ¥
                        <span>
                            120
                        </span>
                        起
                    </p>
                </div>
            </a>
            <a href="javascript:;" class="a2">
                <p class="p4">
                    居民搬家
                </p>
                <p class="p5">
                    香港直飞+精选阿联酋航空(A380豪华客机)+当晚抵达全
                    <br>
                    程入住4晚五星酒店！
                </p>
                <p class="p6">
                    ¥
                    <span>
                        120
                    </span>
                    起
                </p>
                <p class="p7">
                    查看详情&gt;
                </p>
            </a>
        </li>
        <li>
            <a href="javascript:;" class="a1">
                <img src="<?= $webUrl ?>images/gift/10552347_231610350949916.jpg">
                <div class="divA">
                    <p class="p1">
                        办公室搬迁
                    </p>
                    <p class="p2">
                        全程4-5星酒店/金字塔/博特馆/度假圣地红海洪加达/迪拜/阿布扎比一次走遍！
                    </p>
                    <p class="p3">
                        ¥
                        <span>
                            199
                        </span>
                        起
                    </p>
                </div>
            </a>
            <a href="javascript:;" class="a2">
                <p class="p4">
                    办公室搬迁
                </p>
                <p class="p5">
                    全程4-5星酒店/金字塔/博特馆/度假圣地红海洪加达
                    <br>
                    /迪拜/阿布扎比一次走遍！
                </p>
                <p class="p6">
                    ¥
                    <span>
                        199
                    </span>
                    起
                </p>
                <p class="p7">
                    查看详情&gt;
                </p>
            </a>
        </li>
        <li class="last">
            <a href="javascript:;" class="a1">
                <img src="<?= $webUrl ?>images/gift/10527181_887630653793940.jpg">
                <div class="divA">
                    <p class="p1">
                        厂房搬迁
                    </p>
                    <p class="p2">
                        全程五星/免费车载WIFI/棉花堡/爱琴海/ 特洛伊古城/伊斯坦布尔风情!
                    </p>
                    <p class="p3">
                        ¥
                        <span>
                            599
                        </span>
                        起
                    </p>
                </div>
            </a>
            <a href="javascript:;" class="a2">
                <p class="p4">
                    厂房搬迁
                </p>
                <p class="p5">
                    全程五星/免费车载WIFI/棉花堡/爱琴海/
                    <br>
                    特洛伊古城/伊斯坦布尔风情!！
                </p>
                <p class="p6">
                    ¥
                    <span>
                        599
                    </span>
                    起
                </p>
                <p class="p7">
                    查看详情&gt;
                </p>
            </a>
        </li>
        <li>
            <a href="javascript:;" class="a1">
                <img src="<?= $webUrl ?>images/gift/224607_162375013321817.jpg">
                <div class="divA">
                    <p class="p1">
                        仓库搬迁
                    </p>
                    <p class="p2">
                        香港往返/深圳往返【德国啤酒屋】+品尝当地著名【78层自助餐】/品质保证
                    </p>
                    <p class="p3">
                        ¥
                        <span>
                            380
                        </span>
                        起
                    </p>
                </div>
            </a>
            <a href="javascript:;" class="a2">
                <p class="p4">
                    仓库搬迁
                </p>
                <p class="p5">
                    香港往返/深圳往返【德国啤酒屋】+品尝当地著名
                    <br>
                    【78层自助餐】/品质保证
                </p>
                <p class="p6">
                    ¥
                    <span>
                        380
                    </span>
                    起
                </p>
                <p class="p7">
                    查看详情&gt;
                </p>
            </a>
        </li>
        <li>
            <a href="javascript:;" class="a1">
                <img src="<?= $webUrl ?>images/gift/10527181_887630653793940.jpg">
                <div class="divA">
                    <p class="p1">
                        长途搬家
                    </p>
                    <p class="p2">
                        全程五星/免费车载WIFI/棉花堡/爱琴海/ 特洛伊古城/伊斯坦布尔风情!
                    </p>
                    <p class="p3">
                        ¥
                        <span>
                            198
                        </span>
                        起
                    </p>
                </div>
            </a>
            <a href="javascript:;" class="a2">
                <p class="p4">
                    长途搬家
                </p>
                <p class="p5">
                    全程五星/免费车载WIFI/棉花堡/爱琴海/
                    <br>
                    特洛伊古城/伊斯坦布尔风情!！
                </p>
                <p class="p6">
                    ¥
                    <span>
                        198
                    </span>
                    起
                </p>
                <p class="p7">
                    查看详情&gt;
                </p>
            </a>
        </li>
        <li class="last">
            <a href="javascript:;" class="a1">
                <img src="<?= $webUrl ?>images/gift/224607_162375013321817.jpg">
                <div class="divA">
                    <p class="p1">
                        空调移机
                    </p>
                    <p class="p2">
                        香港往返/深圳往返【德国啤酒屋】+品尝当地著名【78层自助餐】/品质保证
                    </p>
                    <p class="p3">
                        ¥
                        <span>
                            99
                        </span>
                        起
                    </p>
                </div>
            </a>
            <a href="javascript:;" class="a2">
                <p class="p4">
                    空调移机
                </p>
                <p class="p5">
                    香港往返/深圳往返【德国啤酒屋】+品尝当地著名
                    <br>
                    【78层自助餐】/品质保证
                </p>
                <p class="p6">
                    ¥
                    <span>
                        99
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

<div class="container block hot-article">
    <div class="head-title"><h2>搬家百科<span class="txt">快速获得搬家经验</span></h2></div>
    <div class="hot-article-list">
        <div class="h-n-box">
            <div class="tit">
                <h3>搬家百科</h3>
                <a href="jiaju">更多&gt;</a></div>
            <dl class="clearfix">
                <dt>
                    <a href="jiaju/191878.html">
                        <img src="/images/test/dybwnoke.png" width="140" height="110" alt="实木家具日常保养攻略 实木家具保养技巧"></a>
                </dt>
                <dd>
                    <a href="jiaju/191878.html" class="ellipsis">实木家具日常保养攻略 实木家具保养技巧</a>
                    <p>平时在打扫卫生时，所使用的清洁工具不到碰撞到家具表面，也不用一些坚硬的金属制品或利器与家具发生摩擦。否则会</p>
                    <span>2018-09-19</span></dd>
            </dl>
            <div class="list">
                <a href="jiaju/191867.html" class="ellipsis">挑选浴室柜注意事项</a>
                <p>浴室柜的台面是很容易受到磨损的地方，所以我们一定要选择那种耐刮耐磨、质地坚硬的台面，现在比较多见的浴室柜台</p>
                <span>2018-09-14</span></div>
            <div class="list">
                <a href="jiaju/191862.html" class="ellipsis">橡木家具保养小贴士 橡木家具选购技巧</a>
                <p>橡木质地均匀而又紧密，纹理美丽而又独特，木质纹理具有极强的装饰效果。橡木家具有独特的木纹，木纹越清晰价值越</p>
                <span>2018-09-13</span></div>
            <div class="list">
                <a href="jiaju/191838.html" class="ellipsis">挑选书柜要点攻略 购买书柜的小贴士</a>
                <p>书柜外形多种多样，也各有利弊。在购买前，消费者需预先考虑的是，书柜的功能是仅摆放书籍，还是摆放、储物与展示</p>
                <span>2018-09-06</span></div>
        </div>
        <div class="h-n-box">
            <div class="tit">
                <h3>行业动态</h3>
                <a href="jiadian">更多&gt;</a></div>
            <dl class="clearfix">
                <dt>
                    <a href="jiadian/191883.html">
                        <img src="/images/test/oykmbsvc.png" width="140" height="110" alt="购买电视柜技巧 挑选电视柜注意事项"></a>
                </dt>
                <dd>
                    <a href="jiadian/191883.html" class="ellipsis">购买电视柜技巧 挑选电视柜注意事项</a>
                    <p>我们都知道电器都是要散热的，所以电视柜材料也是要散热的才比较好。线路的安置也是我们购买电视柜的注意事项，一</p>
                    <span>2018-09-20</span></dd>
            </dl>
            <div class="list">
                <a href="jiadian/191844.html" class="ellipsis">使用加湿器注意事项 清洁加湿器的方法</a>
                <p>不是随便什么水都可以放进加湿器里面的，各种加湿器对水质都有一定的要求，一般都是使用纯净水或者蒸馏水。大家根</p>
                <span>2018-09-07</span></div>
            <div class="list">
                <a href="jiadian/191826.html" class="ellipsis">液晶电视怎么挑选 液晶电视挑选攻略</a>
                <p>消费者可以直接忽略厂商提供的亮度和对比度参数，直接以自己的目测感受为主，方法为在5米以外的距离，查看屏幕显</p>
                <span>2018-09-04</span></div>
            <div class="list">
                <a href="jiadian/191738.html" class="ellipsis">空调清洗方法 空调清洗注意事项</a>
                <p>经过一整个夏天的考验，我们的空调再给我们带来凉爽的同时，自己已然是满是灰尘，有的家庭却并不以为意，很少主动</p>
                <span>2018-08-16</span></div>
        </div>
        <div class="h-n-box" style="border-right:0;">
            <div class="tit">
                <h3>常见问题</h3>
                <a href="jiancai">更多&gt;</a></div>
            <dl class="clearfix">
                <dt>
                    <a href="jiancai/191873.html">
                        <img src="/images/test/yzsgehpt.png" width="140" height="110" alt="挑选洗手盆方法 购买洗手盆小贴士"></a>
                </dt>
                <dd>
                    <a href="jiancai/191873.html" class="ellipsis">挑选洗手盆方法 购买洗手盆小贴士</a>
                    <p>在挑选玻璃洗手盆时不用过于执着其厚度，不一定是越厚的玻璃质量越好，一般厚度为12到15mm的厚度足够了，同</p>
                    <span>2018-09-17</span></dd>
            </dl>
            <div class="list">
                <a href="jiancai/191856.html" class="ellipsis">挑选沙发注意事项大全 购买沙发攻略</a>
                <p>沙发的承重力决定了沙发的使用寿命，而沙发的框架又直接决定了沙发的承重力。沙发结构的稳固度的关键在于其内部框</p>
                <span>2018-09-11</span></div>
            <div class="list">
                <a href="jiancai/191808.html" class="ellipsis">挑选卫浴要注意哪些方面 挑选卫浴注意事项大全</a>
                <p>面盆选购要配合浴室的整体装修环境，现在的大部分浴室以铺贴瓷砖、地砖为主，所以，陶瓷材质的面盆也是目前市场上</p>
                <span>2018-08-30</span></div>
            <div class="list">
                <a href="jiancai/191792.html" class="ellipsis">挑选卫浴注意事项大全 挑选卫浴技巧介绍</a>
                <p>选浴室柜主要就是考虑防污能力及釉面工艺，其次就是看款式与整体是否统一，还有柜门开关和抽屉阻尼使用是否顺滑，</p>
                <span>2018-08-27</span></div>
        </div>
    </div>
</div>

<div class="container news-center" style="display: none;">
    <div class="clearfix">
        <dl class="box">
            <dt>
                <h3>家政知识</h3>
                <a href="javascript:;" target="_blank" class="more">更多&gt;</a>
            </dt>
            <dd>
                <p class="clearfix"><a href="javascript:;">常用的水槽类型 2018水槽品牌推荐</a><span class="news-date fr">2019-02-02</span></p>
                <p class="clearfix"><a href="javascript:;">灰色地砖家政效果图 高级灰的名头可不是白叫的</a><span class="news-date fr">2019-02-02</span></p>
                <p class="clearfix"><a href="javascript:;">钛合金门窗多少钱一平方 钛合金门窗优点有哪些</a><span class="news-date fr">2019-02-02</span></p>
                <p class="clearfix"><a href="javascript:;">不锈钢厨房台面怎么样 不锈钢和石英石台面哪个好</a><span class="news-date fr">2019-02-02</span></p>
                <p class="clearfix"><a href="javascript:;">三室两厅的家政案例 90平北欧风新房欣赏</a><span class="news-date fr">2019-02-02</span></p>
            </dd>
        </dl>
        <dl class="box">
            <dt>
                <h3>
                    建材知识
                </h3>
                <a href="javascript:;" target="_blank" class="more">更多&gt;</a>
            </dt>
            <dd>
                <p class="clearfix"><a href="javascript:;">洁具品牌推荐 洁具选购技巧</a><span class="news-date fr">2019-02-02</span></p>
                <p class="clearfix"><a href="javascript:;">门业厂家推荐 如何提防卖门奸商</a><span class="news-date fr">2019-02-02</span></p>
                <p class="clearfix"><a href="javascript:;">toto 高仪 科勒哪个好 殿堂级卫浴实力大比拼</a><span class="news-date fr">2019-02-02</span></p>
                <p class="clearfix"><a href="javascript:;">水磨石地面施工价格是多少 如何做好水磨石地面的施工</a><span class="news-date fr">2019-02-02</span></p>
                <p class="clearfix"><a href="javascript:;">地砖效果图鉴赏 五款时尚美观地砖推荐</a><span class="news-date fr">2019-02-02</span></p>
            </dd>
        </dl>
        <dl class="box last">
            <dt>
                <h3>家居知识</h3>
                <a href="javascript:;" target="_blank" class="more">更多&gt;</a>
            </dt>
            <dd>
                <p class="clearfix"><a href="javascript:;">生态板十大名牌排名榜 中国十大板材品牌排行</a><span class="news-date fr">2019-02-02</span></p>
                <p class="clearfix"><a href="javascript:;">电视墙2018最新款造型 六款时尚电视墙效果图</a><span class="news-date fr">2019-02-02</span></p>
                <p class="clearfix"><a href="javascript:;">橱柜门颜色效果图大全 八款橱柜常用色推荐</a><span class="news-date fr">2019-02-02</span></p>
                <p class="clearfix"><a href="javascript:;">什么是简中式家装 简中式家装家政注意事项</a><span class="news-date fr">2019-02-02</span></p>
                <p class="clearfix"><a href="javascript:;">坐便器坑距一般是多少 坐便器都有哪些品牌</a><span class="news-date fr">2019-02-02</span></p>
            </dd>
        </dl>
    </div>
</div>

<div class="work-case container">
    <div class="head-title"><h2>现场案例动态<span class="txt">一站式的服务、服务后期持续跟进</span></h2></div>
    <div class="case-box clearfix">
        <div class="case-banner">
            <a class="arrow arrow-left" href="#"><span></span></a>
            <a class="arrow arrow-right" href="#"><span></span></a>
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <a href="javascript:;" target="_blank">
                            <img src="//tgi1.jia.com/122/269/22269481.jpg" alt="夏季来临">
                            <div class="back-screen">
                                <p class="big-font">夏季来临</p>
                                <p class="small-font">快给家里降点温</p>
                            </div>
                        </a>
                    </div>
                    <div class="swiper-slide">
                        <a href="javascript:;" target="_blank">
                            <img src="//tgi12.jia.com/122/269/22269485.jpg" alt="打造粉色之家">
                            <div class="back-screen">
                                <p class="big-font">打造粉色之家</p>
                                <p class="small-font">圆你一个公主梦</p>
                            </div>
                        </a>
                    </div>
                    <div class="swiper-slide">
                        <a href="javascript:;" target="_blank">
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
        <div class="case-recommend">
            <div class="list-left">
                <a href="javascript:;" target="_blank">
                    <img src="//tgi13.jia.com/122/269/22269527.jpg" alt="搬搬家案例搬家案例家案例">
                    <div class="case-gloab">
                        <span class="case-gloab-title">搬搬家案例搬家案例家案例</span>
                    </div>
                </a>
            </div>
            <div class="list-left">
                <a href="javascript:;" target="_blank">
                    <img src="//tgi13.jia.com/122/269/22269527.jpg" alt="搬搬家案例搬家案例家案例">
                    <div class="case-gloab">
                        <span class="case-gloab-title">搬搬家案例搬家案例家案例</span>
                    </div>
                </a>
            </div>
            <div class="list-left mr0">
                <a href="javascript:;" target="_blank">
                    <img src="//tgi13.jia.com/122/269/22269527.jpg" alt="搬搬家案例搬家案例家案例">
                    <div class="case-gloab">
                        <span class="case-gloab-title">搬搬家案例搬家案例家案例</span>
                    </div>
                </a>
            </div>
            <div class="list-left">
                <a href="javascript:;" target="_blank">
                    <img src="//tgi1.jia.com/122/269/22269542.jpg" alt="家政清洁家政清洁家政清洁">
                    <div class="case-gloab">
                        <span class="case-gloab-title">家政清洁家政清洁家政清洁</span>
                    </div>
                </a>
            </div>
            <div class="list-left">
                <a href="javascript:;" target="_blank">
                    <img src="//tgi1.jia.com/122/269/22269542.jpg" alt="家政清洁家政清洁家政清洁">
                    <div class="case-gloab">
                        <span class="case-gloab-title">家政清洁家政清洁家政清洁</span>
                    </div>
                </a>
            </div>
            <div class="list-left mr0">
                <a href="javascript:;" target="_blank">
                    <img src="//tgi1.jia.com/122/269/22269542.jpg" alt="家政清洁家政清洁家政清洁">
                    <div class="case-gloab">
                        <span class="case-gloab-title">家政清洁家政清洁家政清洁</span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container" style="background: #000;color: white">
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

<div class="container block user-comment">
    <div class="head-title"><h2>用户好评<span class="txt">缩小的子标题</span></h2></div>
    <div class="comment-list">
        <p>评论列表</p>
        <p></p>
    </div>
</div>

<div class="container block work-star">
    <div class="head-title"><h2>嘉乐邦团队<span class="txt">搬家我们是认真的</span></h2></div>
    <div class="star-list">
        <p>嘉乐邦团队之星介绍</p>
    </div>
</div>

<div class="container bao-zhang" style="display: none;">
    <div class="turen-head">
        <h2 class="fl">关于服务保障<span class="txt">一站式的服务</span></h2>
    </div>
    <div class="clearfix">
        <ul class="bao-zhang-list clearfix">
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
