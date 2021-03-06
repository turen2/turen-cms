<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use yii\helpers\Json;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use frontend\assets\Swiper2Asset;
use common\helpers\ImageHelper;
use common\models\cms\Article;
use common\models\cms\Photo;
use common\models\ext\Ad;
use common\models\shop\Product;

$webUrl = Yii::getAlias('@web/');

Swiper2Asset::register($this);

$js = <<<EOF
//下单跳动效果
//案例现场
var caseSwiper = new Swiper('.case-banner .swiper-container', {
    loop: true,//循环
    autoplay : 3200,//可选选项，自动滑动
    pagination: '.case-banner .pagination',
    grabCursor: true,
    paginationClickable: true,
    autoplayDisableOnInteraction: true,//用户操作后，autoplay将禁止
});
$('.case-banner .arrow-right').on('click', function(e){
    e.preventDefault()
    caseSwiper.swipePrev()
});
$('.case-banner .arrow-left').on('click', function(e){
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
$('.case-banner .swiper-slide img, .case-recommend .list-left img').hover(
    function () {
        $(this).removeClass("removeimg").addClass("fadeimg");
    },
    function () {
        $(this).removeClass("fadeimg").addClass("removeimg");
    }
);
$('.hot-serve .overlay-panel').hover(
    function () {
        $(this).removeClass("removeimg").addClass("fadeimg").prev().removeClass("removeimg").addClass("fadeimg");
    },
    function () {
        $(this).removeClass("removeimg").addClass("fadeimg").prev().removeClass("fadeimg").addClass("removeimg");
    }
);

//业务精选
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

//用户好评滚动
var commentSwiper = new Swiper('.home-comment-slide .swiper-container', {
    loop: true,//循环切换
    //autoplay : 2000,//可选选项，自动滑动
    pagination: '.home-comment-slide .pagination',
    grabCursor: true,
    paginationClickable: true,
    autoplayDisableOnInteraction: true,//用户操作后，autoplay将禁止
});
$('.home-comment-slide .arrow-left').on('click', function(e){
    e.preventDefault()
    commentSwiper.swipePrev()
});
$('.home-comment-slide .arrow-right').on('click', function(e){
    e.preventDefault()
    commentSwiper.swipeNext()
});
EOF;
$this->registerJs($js);
?>

<div class="container block slide-form">
    <?= $this->render('_main_ad') ?>
    <?= $this->render('_call_price', ['productList' => $productList]) ?>
</div>

<div class="container block hot-serve">
    <div class="head-title">
        <h2><span>业务精选</span><hr></h2>
        <p class="txt">您的满意就是我们的宗旨</p>
    </div>
    <ul class="clearfix">
        <?php $hotServices = Product::find()->where(['columnid' => Yii::$app->params['config_face_cn_home_service_column_id']])->andWhere(['like', 'flag', Yii::$app->params['config_face_cn_home_service_column_flag']])->orderBy(['orderid' => SORT_DESC])->asArray()->all(); ?>
        <?php if($hotServices) { ?>
        <?php foreach ($hotServices as $index => $hotService) { ?>
        <li class="card<?= ($index%4 == 3)?' last':'' ?>">
            <div class="cover">
                <img class="cover-image" alt="<?= $hotService['title'] ?>" title="<?= $hotService['title'] ?>" src="<?= empty($hotService['picurl'])?ImageHelper::getNopic():Yii::$app->aliyunoss->getObjectUrl($hotService['picurl'], true) ?>" />
                <div class="overlay-panel">
                    <h3 class="card-title"><?= $hotService['title'] ?></h3>
                    <a class="hot-btn" title="<?= $hotService['title'] ?>" href="<?= Url::to(['service/detail', 'slug' => $hotService['slug']]) ?>">查看详情</a>
                </div>
            </div>
        </li>
        <?php } ?>
        <?php } ?>
    </ul>
    <a target="_blank" class="broser-more" href="<?= Url::to(['service/list']) ?>">浏览更多 <i class="iconfont jia-more1"></i></a>
</div>

<?php /*
<div class="container block hot-item">
    <div class="head-title">
        <h2><span>精选服务</span><hr></h2>
        <p class="txt">热门精选服务到家</p>
    </div>
    <ul class="clearfix">
        <?php $hotServices = Ad::AdListByAdTypeId(Yii::$app->params['']); ?>
        <?php if($hotServices) { ?>
            <?php foreach ($hotServices as $index => $hotService) { ?>
                <?php
                $tt = explode('||', $hotService['adtext']);
                $tt1 = isset($tt[0])?$tt[0]:'';
                $tt2 = isset($tt[1])?$tt[1]:'';
                ?>

                <li class="<?= ($index%3 == 2)?'last':'' ?>">
                    <a href="<?= $hotService['linkurl'] ?>" class="a1">
                        <img title="<?= $hotService['title'] ?>" src="<?= empty($hotService['picurl'])?ImageHelper::getNopic():Yii::$app->aliyunoss->getObjectUrl($hotService['picurl'], true) ?>" />
                        <div class="divA">
                            <p class="p1"><?= $hotService['title'] ?></p>
                            <p class="p2"><?= $tt1 ?></p>
                            <p class="p3"><?= $tt2 ?></p>
                        </div>
                    </a>
                    <a href="<?= $hotService['linkurl'] ?>" class="a2">
                        <p class="p4"><?= $hotService['title'] ?></p>
                        <p class="p5"><?= $tt1 ?></p>
                        <p class="p6"><?= $tt2 ?></p>
                        <p class="p7">查看详情&gt;</p>
                    </a>
                </li>
            <?php } ?>
        <?php } else { ?>
            未设置精选服务
        <?php } ?>
    </ul>
</div>
 */ ?>

<?php /*
<div class="container block news-center">
    <div class="clearfix">
        <dl class="box">
            <dt>
                <h3>家政知识</h3>
                <a href="javascript:;" target="_blank" class="more">更多 <i class="iconfont jia-more1"></i></a>
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
                <a href="javascript:;" target="_blank" class="more">更多 <i class="iconfont jia-more1"></i></a>
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
                <a href="javascript:;" target="_blank" class="more">更多 <i class="iconfont jia-more1"></i></a>
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
 */ ?>

<div class="container block work-case">
    <div class="head-title">
        <h2><span>现场案例动态</span><hr></h2>
        <p class="txt">一站式的服务、服务后期持续跟进</p>
    </div>
    <div class="case-box clearfix">
        <div class="case-banner">
            <a class="arrow arrow-left" href="#"><span></span></a>
            <a class="arrow arrow-right" href="#"><span></span></a>
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <?php $slidePhotoes = Photo::find()->where(['columnid' => Yii::$app->params['config_face_cn_home_case_slide_column_id'], 'delstate' => Photo::IS_NOT_DEL])->andWhere(['like', 'flag', Yii::$app->params['config_face_cn_home_case_slide_column_flag']])->orderBy(['orderid' => SORT_DESC])->asArray()->all(); ?>
                    <?php if($slidePhotoes) { ?>
                    <?php foreach ($slidePhotoes as $index => $slidePhotoe) { ?>
                    <div class="swiper-slide">
                        <a href="<?= empty($slidePhotoe['linkurl'])?Url::to(['case/detail', 'slug' => $slidePhotoe['slug']]):$slidePhotoe['linkurl'] ?>"<?= empty($slidePhotoe['linkurl'])?'':' target="_blank"' ?>>
                            <img title="<?= $slidePhotoe['title'] ?>" src="<?= empty($slidePhotoe['picurl'])?ImageHelper::getNopic():Yii::$app->aliyunoss->getObjectUrl($slidePhotoe['picurl'], true) ?>" />
                            <div class="back-screen">
                                <p class="big-font"><?= $slidePhotoe['title'] ?></p>
                                <p class="small-font">
                                    <?php
                                    if(!empty($slidePhotoe['content'])) {
                                        $des = $slidePhotoe['content'];//去除图片链接
                                    } else {
                                        $des = $slidePhotoe['description'];
                                    }
                                    echo StringHelper::truncate(strip_tags($des), 50);
                                    ?>
                                </p>
                            </div>
                        </a>
                    </div>
                    <?php } ?>
                    <?php } else { ?>
                        未设置首页案例主幻灯内容
                    <?php } ?>
                </div>
            </div>
            <div class="pagination"></div>
        </div>
        <div class="case-recommend">
            <?php $topPhotoes = Photo::find()->where(['columnid' => Yii::$app->params['config_face_cn_home_case_column_id']])->orderBy(['updated_at' => SORT_DESC])->limit(6)->asArray()->all(); ?>
            <?php foreach ($topPhotoes as $index => $topPhoto) { ?>
            <div class="list-left<?= ($index%3 != 2)?'':' mr0' ?>">
                <a href="<?= empty($topPhoto['linkurl'])?Url::to(['case/detail', 'slug' => $topPhoto['slug']]):$topPhoto['linkurl'] ?>"<?= empty($topPhoto['linkurl'])?'':' target="_blank"' ?>>
                    <img title="<?= $topPhoto['title'] ?>" src="<?= empty($topPhoto['picurl'])?ImageHelper::getNopic():Yii::$app->aliyunoss->getObjectUrl($topPhoto['picurl'], true) ?>" />
                    <div class="case-gloab">
                        <span class="case-gloab-title"><?= $topPhoto['title'] ?></span>
                    </div>
                </a>
            </div>
            <?php } ?>
        </div>
    </div>
    <a target="_blank" class="broser-more" href="<?= Url::to(['case/list']) ?>">浏览更多 <i class="iconfont jia-more1"></i></a>
</div>

<div class="container block hot-article">
    <div class="head-title">
        <h2><span>常见问答</span><hr></h2>
        <p class="txt">快速定位高空作业中遇到的疑点难点</p>
    </div>
    <div class="hot-article-list">
        <div class="h-n-box">
            <div class="tit">
                <h3>公司新闻</h3>
                <a href="<?= Url::to(['company/list']) ?>" target="_blank">更多<i class="iconfont jia-more1"></i></a>
            </div>
            <?php $companyList = Article::ActiveList(Article::class, Yii::$app->params['config_face_cn_home_company_column_id'], 5, Yii::$app->params['config_face_cn_home_company_column_flag']); ?>
            <?php foreach ($companyList as $index => $company) { ?>
                <?php
                if(empty($company['description'])) {
                    $des = $company['content'];//去除图片链接
                } else {
                    $des = $company['description'];
                }
                $note = StringHelper::truncate(strip_tags($des), 42);
                ?>
                <?php if(empty($index)) { ?>
                    <dl class="clearfix">
                        <dt>
                            <a href="<?= Url::to(['company/detail', 'slug' => $company['slug']]) ?>">
                                <img title="<?= $company['title'] ?>" width="140" height="110" src="<?= empty($company['picurl'])?ImageHelper::getNopic():Yii::$app->aliyunoss->getObjectUrl($company['picurl'], true) ?>" />
                            </a>
                        </dt>
                        <dd>
                            <a href="<?= Url::to(['company/detail', 'slug' => $company['slug']]) ?>" class="ellipsis"><?= $company['title'] ?></a>
                            <p><?= $note ?></p>
                            <span><i class="iconfont jia-calendar1"></i> <?= Yii::$app->getFormatter()->asDate($company['posttime']) ?></span>
                        </dd>
                    </dl>
                <?php } else { ?>
                    <div class="list">
                        <a href="<?= Url::to(['company/detail', 'slug' => $company['slug']]) ?>" class="ellipsis"><?= $company['title'] ?></a>
                        <p><?= $note ?></p>
                        <span><i class="iconfont jia-calendar1"></i> <?= Yii::$app->getFormatter()->asDate($company['posttime']) ?></span>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
        <div class="h-n-box">
            <div class="tit">
                <h3>行业动态</h3>
                <a href="<?= Url::to(['news/list']) ?>" target="_blank">更多<i class="iconfont jia-more1"></i></a>
            </div>
            <?php $newsList = Article::ActiveList(Article::class, Yii::$app->params['config_face_cn_home_news_column_id'], 5, Yii::$app->params['config_face_cn_home_news_column_flag']); ?>
            <?php foreach ($newsList as $index => $news) { ?>
                <?php
                if(empty($news['description'])) {
                    $des = $news['content'];//去除图片链接
                } else {
                    $des = $news['description'];
                }
                $note = StringHelper::truncate(strip_tags($des), 42);
                ?>
                <?php if(empty($index)) { ?>
                    <dl class="clearfix">
                        <dt>
                            <a href="<?= Url::to(['news/detail', 'slug' => $news['slug']]) ?>">
                                <img title="<?= $news['title'] ?>" width="140" height="110" src="<?= empty($news['picurl'])?ImageHelper::getNopic():Yii::$app->aliyunoss->getObjectUrl($news['picurl'], true) ?>" />
                            </a>
                        </dt>
                        <dd>
                            <a href="<?= Url::to(['news/detail', 'slug' => $news['slug']]) ?>" class="ellipsis"><?= $news['title'] ?></a>
                            <p><?= $note ?></p>
                            <span><i class="iconfont jia-calendar1"></i> <?= Yii::$app->getFormatter()->asDate($news['posttime']) ?></span>
                        </dd>
                    </dl>
                <?php } else { ?>
                    <div class="list">
                        <a href="<?= Url::to(['news/detail', 'slug' => $news['slug']]) ?>" class="ellipsis"><?= $news['title'] ?></a>
                        <p><?= $note ?></p>
                        <span><i class="iconfont jia-calendar1"></i> <?= Yii::$app->getFormatter()->asDate($news['posttime']) ?></span>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
        <div class="h-n-box" style="border-right:0;">
            <div class="tit">
                <h3>帮助中心</h3>
                <a href="<?= Url::to(['help/index']) ?>" target="_blank">更多<i class="iconfont jia-more1"></i></a>
            </div>
            <?php $helpList = Article::ActiveList(Article::class, Yii::$app->params['config_face_cn_home_help_column_id'], 5, Yii::$app->params['config_face_cn_home_help_column_flag']); ?>
            <?php foreach ($helpList as $index => $help) { ?>
                <?php
                if(empty($help['description'])) {
                    $des = $help['content'];//去除图片链接
                } else {
                    $des = $help['description'];
                }
                $note = StringHelper::truncate(strip_tags($des), 42);
                ?>
                <?php if(empty($index)) { ?>
                    <dl class="clearfix">
                        <dt>
                            <a href="<?= Url::to(['help/index', 'slug' => $help['slug']]) ?>">
                                <img title="<?= $help['title'] ?>" width="140" height="110" src="<?= empty($help['picurl'])?ImageHelper::getNopic():Yii::$app->aliyunoss->getObjectUrl($help['picurl'], true) ?>" />
                            </a>
                        </dt>
                        <dd>
                            <a href="<?= Url::to(['help/index', 'slug' => $help['slug']]) ?>" class="ellipsis"><?= $help['title'] ?></a>
                            <p><?= $note ?></p>
                            <span><i class="iconfont jia-calendar1"></i> <?= Yii::$app->getFormatter()->asDate($help['posttime']) ?></span>
                        </dd>
                    </dl>
                <?php } else { ?>
                    <div class="list">
                        <a href="<?= Url::to(['help/index', 'slug' => $help['slug']]) ?>" class="ellipsis"><?= $help['title'] ?></a>
                        <p><?= $note ?></p>
                        <span><i class="iconfont jia-calendar1"></i> <?= Yii::$app->getFormatter()->asDate($help['posttime']) ?></span>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</div>

<?php $userConments = Ad::AdListByAdTypeId(Yii::$app->params['config_face_cn_home_conment_ad_type_id']); ?>
<?php if($userConments) { ?>
<div class="container block user-comment">
    <div class="head-title">
        <h2><span>用户好评</span><hr></h2>
        <p class="txt">针对您定制最合适的作业方案</p>
    </div>
    <div class="comment-list">
        <div class="home-comment-slide">
            <a class="arrow arrow-left" title="向左滑动" href="#"></a>
            <a class="arrow arrow-right" title="向右滑动" href="#"></a>
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <?php foreach ($userConments as $index => $userConment) { ?>
                    <?php
                        //解析json
                        try {
                            $userSayContent = Json::decode($userConment['adtext']);
                        } catch (\Exception $e) {
                            continue;//异常直接跳过本次解析
                        }
                        ?>
                    <div class="swiper-slide">
                        <div class="user-info">
                            <img class="info-img" title="<?= $userConment['title'] ?>" src="<?= empty($userConment['picurl'])?ImageHelper::getNopic():Yii::$app->aliyunoss->getObjectUrl($userConment['picurl'], true) ?>" />
                            <div class="info-txt">
                                <div class="info-txt-p br5"><?= $userSayContent['say_content'] ?></div>
                                <div>
                                    <h6><?= $userConment['title'] ?></h6>
                                    <span><?= $userSayContent['sub_title1'] ?></span>
                                    <span><?= $userSayContent['sub_title2'] ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <div class="pagination"></div>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<?php $seviceCompanies = Ad::AdListByAdTypeId(Yii::$app->params['config_face_cn_home_service_company_ad_type_id']); ?>
<?php if($seviceCompanies) { ?>
<div class="container block service-company">
    <div class="head-title">
        <h2><span>重要合作客户</span><hr></h2>
        <p class="txt">大企业背书，服务值得信赖</p>
    </div>
    <div class="partner-list">
        <ul class="logo-show">
            <?php foreach ($seviceCompanies as $index => $seviceCompany) { ?>
            <li>
                <p class="logo-box">
                    <img title="<?= $seviceCompany['title'] ?>" src="<?= empty($seviceCompany['picurl'])?ImageHelper::getNopic():Yii::$app->aliyunoss->getObjectUrl($seviceCompany['picurl'], true) ?>" />
                </p>
                <p><?= $seviceCompany['title'] ?></p>
            </li>
            <?php } ?>
        </ul>
    </div>
</div>
<?php } ?>

<div class="container block work-flow">
    <div class="head-title">
        <h2><span>服务流程</span><hr></h2>
        <p class="txt">标准化质量输出</p>
    </div>
    <div class="flow-content">
        <ul class="clearfix">
            <li class="first">
                <i class="insqzxfw-img1"></i>
                <b>免费咨询</b>
                <p>预约成功，安排上门服务</p>
            </li>
            <li>
                <i class="insqzxfw-img2"></i>
                <b>在线方案</b>
                <p>客服在线定制合理方案</p>
            </li>
            <li>
                <i class="insqzxfw-img3"></i>
                <b>售后保障</b>
                <p>全程客服跟踪，服务质量有保障</p>
            </li>
            <li class="last">
                <i class="insqzxfw-img4"></i>
                <b>优惠活动</b>
                <p>预约即可享受9折优惠</p>
            </li>
        </ul>
        <div class="insqzxfw-but" style="display: none;"><a href="" target="_blank">马上预约</a></div>
    </div>
</div>

<!--<div class="container bao-zhang">-->
<!--    <div class="head-title">-->
<!--        <h2><span>关于服务保障</span><hr></h2>-->
<!--        <p class="txt">一站式的服务</p>-->
<!--    </div>-->
<!--    <div class="clearfix">-->
<!--        <ul class="bao-zhang-list clearfix">-->
<!--            <li>-->
<!--                <a href="" target="_blank">-->
<!--                    <dl class="mod-wrap mod-1">-->
<!--                        <dt>-->
<!--                            <img src="//oneimg3.jia.com/content/public/resource/12808457/2017/06/275196_field_7_1498455803.png" width="95" height="95">-->
<!--                        </dt>-->
<!--                        <dd>-->
<!--                            <h4>家政百事通</h4>-->
<!--                            <p>有问必答</p>-->
<!--                        </dd>-->
<!--                    </dl>-->
<!--                </a>-->
<!--            </li>-->
<!--            <li>-->
<!--                <a href="" target="_blank">-->
<!--                    <dl class="mod-wrap mod-2">-->
<!--                        <dt>-->
<!--                            <img src="//oneimg4.jia.com/content/public/resource/12808457/2017/05/275197_field_7_1495076838.jpg" width="95" height="95">-->
<!--                        </dt>-->
<!--                        <dd>-->
<!--                            <h4>-->
<!--                                买贵怎么办？-->
<!--                            </h4>-->
<!--                            <p>-->
<!--                                亚桥租赁网为您协议价护航-->
<!--                            </p>-->
<!--                        </dd>-->
<!--                    </dl>-->
<!--                </a>-->
<!--            </li>-->
<!--            <li>-->
<!--                <a href="" target="_blank">-->
<!--                    <dl class="mod-wrap mod-3">-->
<!--                        <dt>-->
<!--                            <img src="//oneimg5.jia.com/content/public/resource/12808457/2017/04/275198_field_7_1493092697.jpg" width="95" height="95">-->
<!--                        </dt>-->
<!--                        <dd>-->
<!--                            <h4>-->
<!--                                家政亚桥租赁协议服务-->
<!--                            </h4>-->
<!--                            <p>-->
<!--                                第三方监管为您护航-->
<!--                            </p>-->
<!--                        </dd>-->
<!--                    </dl>-->
<!--                </a>-->
<!--            </li>-->
<!--            <li>-->
<!--                <a href="" target="_blank">-->
<!--                    <dl class="mod-wrap mod-4">-->
<!--                        <dt>-->
<!--                            <img src="//oneimg1.jia.com/content/public/resource/12808457/2017/05/275199_field_7_1494299392.png" width="95" height="95">-->
<!--                        </dt>-->
<!--                        <dd>-->
<!--                            <h4>-->
<!--                                亚桥租赁家政学堂-->
<!--                            </h4>-->
<!--                            <p>-->
<!--                                家政百事通公益交流-->
<!--                            </p>-->
<!--                        </dd>-->
<!--                    </dl>-->
<!--                </a>-->
<!--            </li>-->
<!--            <li>-->
<!--                <a href="" target="_blank">-->
<!--                    <dl class="mod-wrap mod-5">-->
<!--                        <dt>-->
<!--                            <img src="//oneimg2.jia.com/content/public/resource/12808457/2017/06/275200_field_7_1498455723.png" width="95" height="95">-->
<!--                        </dt>-->
<!--                        <dd>-->
<!--                            <h4>-->
<!--                                纯公益免费验房-->
<!--                            </h4>-->
<!--                            <p>-->
<!--                                同小区满5户即可参加-->
<!--                            </p>-->
<!--                        </dd>-->
<!--                    </dl>-->
<!--                </a>-->
<!--            </li>-->
<!--            <li>-->
<!--                <a href="" target="_blank">-->
<!--                    <dl class="mod-wrap mod-6">-->
<!--                        <dt>-->
<!--                            <img src="//oneimg3.jia.com/content/public/resource/12808457/2017/06/275201_field_7_1496281383.png" width="95" height="95">-->
<!--                        </dt>-->
<!--                        <dd>-->
<!--                            <h4>-->
<!--                                新房质量检测-->
<!--                            </h4>-->
<!--                            <p>-->
<!--                                领取680元验房卡-->
<!--                            </p>-->
<!--                        </dd>-->
<!--                    </dl>-->
<!--                </a>-->
<!--            </li>-->
<!--        </ul>-->
<!--        <div class="right-list-box">-->
<!--            <div class="box-hd">-->
<!--                <h3 class="png-fix-bg">售后跟进</h3>-->
<!--                <a class="more" href="" target="_blank">更多 <i class="iconfont jia-more1"></i></a>-->
<!--                <ul class="notice-list">-->
<!--                    <li>-->
<!--                        <span class="png-fix-bg">-->
<!--                            <a target="_blank" href="" title="[受理中]正适装饰无赖公司，骗子，大家一定不要被它坑了，骗走了血汗钱">-->
<!--                                [受理中]正适装饰无赖公司，骗子，大家一定不要被它坑了，骗走了血汗钱-->
<!--                            </a>-->
<!--                        </span>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <span class="png-fix-bg">-->
<!--                            <a target="_blank" href="" title="[表扬]表扬亚桥租赁监徐勇平">-->
<!--                                [表扬]表扬亚桥租赁监徐勇平-->
<!--                            </a>-->
<!--                        </span>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <span class="png-fix-bg">-->
<!--                            <a target="_blank" href="" title="[受理中]教训深刻">-->
<!--                                [受理中]教训深刻-->
<!--                            </a>-->
<!--                        </span>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <span class="png-fix-bg">-->
<!--                            <a target="_blank" href="" title="[表扬]亚桥租赁洪亮　监理包公">-->
<!--                                [表扬]亚桥租赁洪亮　监理包公-->
<!--                            </a>-->
<!--                        </span>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <span class="png-fix-bg last">-->
<!--                            <a target="_blank" href="" title="[已解决]与t6国际设计家政过程中有争议的问题现已解决">-->
<!--                                [已解决]与t6国际设计家政过程中有争议的问题现已解决-->
<!--                            </a>-->
<!--                        </span>-->
<!--                    </li>-->
<!--                </ul>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->

<div class="home-data-show">
    <div class="container content-wrapper">
        <div class="home-data-box">
            <ul>
                <li>
                    <span class="pos1"><span class="f40">11</span>万公里</span>
                    <span class="pos2"><i class="iconfont fa-map-o"></i> 累积服务里程</span>
                </li>
                <li>
                    <span class="pos1"><span class="f40">3.9</span>万米</span>
                    <span class="pos2"><i class="iconfont fa-heart-o"></i> 累积举起高度</span>
                </li>
                <li>
                    <span class="pos1"><span class="f40">100</span>多家</span>
                    <span class="pos2"><i class="iconfont fa-tasks"></i> 合作企业</span>
                </li>
                <li>
                    <span class="pos1"><span class="f40">4.8</span>分</span>
                    <span class="pos2"><i class="iconfont fa-star-o"></i> 平均服务星级</span>
                </li>
            </ul>
        </div>
        <div class="home-img-box">
            <img src="<?= $webUrl ?>images/common/index_data_represent.png" class="home-img">
            <p class="home-slogan-top">亚桥租赁多年行业经验</p>
            <p class="home-slogan-bottom">深 度 服 务 于 武 汉 及 周 边 地 区</p>
        </div>
    </div>
    <img class="home-bg" src="<?= $webUrl ?>images/common/index_data_bg.jpg">
</div>