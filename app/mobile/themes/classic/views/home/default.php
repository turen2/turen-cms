<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use yii\helpers\Json;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use mobile\assets\Swiper3Asset;
use common\helpers\ImageHelper;
use common\models\cms\Article;
use common\models\cms\Photo;
use common\models\diy\Faqs;
use common\models\ext\Ad;
use common\models\shop\Product;

Swiper3Asset::register($this);
$js = <<<EOF
var swiper = new Swiper('.my-main-banner', {
    pagination: '.swiper-pagination',
    paginationClickable: true,
    spaceBetween: 30,
    loop: true,
    observer: true,
    observeParents: true,
    autoplayDisableOnInteraction: false,
    autoplay: 3000
});

var swiper2 = new Swiper('.my-show-pic01', {
    paginationClickable: true,
    spaceBetween: 10,
    loop: true,
    centeredSlides: true,
    slidesPerView: '3',
    slidesOffsetBefore: 65,
});

var swipers3a = new Swiper('#meitu-3a', {
    paginationClickable: true,
    spaceBetween: 10,
    loop: true,
    centeredSlides: true,
    slidesPerView: '3',
    slidesOffsetBefore: 65,
    observer: true,
    observerParents: true,
    onSlideChangeEnd: function (swiper) {
        swiper.update(); //swiper更新
    }
});

var swiper3 = new Swiper('.my-case', {
    pagination: '.swiper-pagination',
    paginationClickable: true,
    spaceBetween: 30,
    loop: true
});

var swiper4 = new Swiper('.my-review', {
    pagination: '.swiper-pagination',
    effect: 'coverflow',
    grabCursor: true,
    centeredSlides: true,
    slidesPerView: '2.2',
    loop: true,
    coverflow: {
        rotate: 50,
        stretch: 0,
        depth: 100,
        modifier: 1,
        slideShadows: true
    }
});

$('.mainindex li').click(function () {
    var index = $(this).index()
    $(this).addClass('maintab-color').siblings().removeClass('maintab-color')
    $('.gonglue .gltab').eq(index).css('display', 'block').siblings().css('display', 'none')
    $('.news-center.more').attr('href', $(this).find('a').data('href'))
});
EOF;
$this->registerJs($js);

$webUrl = Yii::getAlias('@web/');
?>
<div class="banner">
    <div class="swiper-container myloop my-main-banner">
        <div class="swiper-wrapper">
            <?php $mainAds = Ad::AdListByAdTypeId(Yii::$app->params['config_face_cn_home_main_ad_type_id']); ?>
            <?php if($mainAds) { ?>
                <?php foreach ($mainAds as $index => $mainAd) { ?>
                <div class="swiper-slide">
                    <a href="<?= $mainAd['linkurl'] ?>">
                        <img title="<?= $mainAd['title'] ?>" src="<?= empty($mainAd['picurl'])?ImageHelper::getNopic():Yii::$app->aliyunoss->getObjectUrl($mainAd['picurl'], true) ?>" />
                    </a>
                </div>
                <?php } ?>
            <?php } else { ?>
                未设置主幻灯片
            <?php } ?>
        </div>
        <div class="swiper-pagination"></div>
    </div>
</div>

<div class="menu">
    <ul class="menu-box">
        <li class="menu-list">
            <a href="#freeform">
                <span><img class="menu-pic" src="<?= $webUrl ?>images/yaqiao/menu2.png"><img class="menu-tips" src="<?= $webUrl ?>images/yaqiao/menu-tips.png"></span>
                <p>免费报价</p>
            </a>
        </li>
        <li class="menu-list">
            <a href="<?= Url::to(['/case/list']) ?>">
                <span><img class="menu-pic" src="<?= $webUrl ?>images/yaqiao/menu6.png"></span>
                <p>现场案例</p>
            </a>
        </li>
        <li class="menu-list">
            <a href="<?= Url::to(['/news/list']) ?>">
                <span><img class="menu-pic" src="<?= $webUrl ?>images/yaqiao/menu7.png"></span>
                <p>行业动态</p>
            </a>
        </li>
        <li class="menu-list">
            <a href="<?= Url::to(['/chexing/list']) ?>">
                <span><img class="menu-pic" src="<?= $webUrl ?>images/yaqiao/menu5.png"></span>
                <p>车型展示</p>
            </a>
        </li>
        <li class="menu-list">
            <a href="<?= Url::to(['/faqs/list']) ?>">
                <span><img class="menu-pic" src="<?= $webUrl ?>images/yaqiao/menu8.png"></span>
                <p>常见问答</p>
            </a>
        </li>
    </ul>
</div>

<div class="small-banner">
    <a href="<?= Url::to(['/online/price']) ?>">
        <img src="<?= $webUrl ?>images/yaqiao/price-banner.png" />
    </a>
</div>

<div class="guide">
    <ul class="guide-wrap">
        <li class="guide-list">
            <a href="#">
                <div class="guide-text">
                    <p><span>高空车出租车型推荐</span><img src="<?= $webUrl ?>images/yaqiao/recommend.png"></p>
                    <b>21.5米满足大多数场景</b>
                </div>
                <div class="guide-box">
                    <img src="<?= $webUrl ?>images/yaqiao/gaokong01.png">
                </div>
            </a>
        </li>
        <li class="guide-list guide-list-color">
            <a href="#">
                <div class="guide-text">
                    <p><span>热门叉车出租</span><img src="<?= $webUrl ?>images/yaqiao/hot.png"></p>
                    <b>25米移动叉车简单方便</b>
                </div>
                <div class="guide-box">
                    <img src="<?= $webUrl ?>images/yaqiao/gaokong02.png">
                </div>
            </a>
        </li>
    </ul>
</div>

<div class="main">
    <div class="maintitle">
        <a href=""><p>业务范围</p></a>
        <a class="more" href=""><img src="<?= $webUrl ?>images/yaqiao/more.png"></a>
    </div>
    <div class="beautify">
        <div class="swiper-container mylooptoo" id="meitu-3a">
            <div class="swiper-wrapper">
                <?php $hotServices = Product::find()->where(['columnid' => Yii::$app->params['config_face_cn_home_service_column_id']])->andWhere(['like', 'flag', Yii::$app->params['config_face_cn_home_service_column_flag']])->orderBy(['orderid' => SORT_DESC])->asArray()->all(); ?>
                <?php if($hotServices) { ?>
                    <?php foreach ($hotServices as $index => $hotService) { ?>
                        <div class="swiper-slide">
                            <a href="<?= Url::to(['service/detail', 'slug' => $hotService['slug']]) ?>">
                                <img alt="<?= $hotService['title'] ?>" title="<?= $hotService['title'] ?>" src="<?= empty($hotService['picurl'])?ImageHelper::getNopic():Yii::$app->aliyunoss->getObjectUrl($hotService['picurl'], true) ?>" />
                                <span></span>
                                <div class="beautify-text">
                                    <i></i>
                                    <p><?= $hotService['title'] ?></p>
                                </div>
                            </a>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<div class="main">
    <div class="maintitle">
        <a href=""><p>车型展示</p></a>
        <a class="more" href="<?= Url::to(['/chexing/list']) ?>"><img src="<?= $webUrl ?>images/yaqiao/more.png"></a>
    </div>
    <div class="designer">
        <div class="swiper-container mylooptoop my-show-pic01">
            <div class="swiper-wrapper">
                <?php $chexingPhotoes = Photo::find()->where(['columnid' => Yii::$app->params['config_face_mobile_cn_home_chexing_slide_column_id']])->andWhere(['like', 'flag', Yii::$app->params['config_face_mobile_cn_home_chexing_slide_column_flag']])->orderBy(['orderid' => SORT_DESC])->asArray()->all(); ?>
                <?php foreach ($chexingPhotoes as $index => $chexingPhoto) { ?>
                    <div class="swiper-slide">
                        <div class="des-pic">
                            <a href="<?= empty($chexingPhoto['linkurl'])?Url::to(['chexing/detail', 'slug' => $chexingPhoto['slug']]):$chexingPhoto['linkurl'] ?>">
                                <img title="<?= $chexingPhoto['title'] ?>" src="<?= empty($chexingPhoto['picurl'])?ImageHelper::getNopic():Yii::$app->aliyunoss->getObjectUrl($chexingPhoto['picurl'], true) ?>" />
                            </a>
                        </div>
                        <div class="des-text">
                            <b>
                                <a href="<?= empty($chexingPhoto['linkurl'])?Url::to(['chexing/detail', 'slug' => $chexingPhoto['slug']]):$chexingPhoto['linkurl'] ?>">
                                    <?= $chexingPhoto['title'] ?>
                                </a>
                            </b>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<div class="main case">
    <div class="maintitle">
        <a href=""><p>现场案例</p></a>
        <a class="more" href="<?= Url::to(['/case/list']) ?>"><img src="<?= $webUrl ?>images/yaqiao/more.png"></a>
    </div>
    <div class="casewrap">
        <div class="swiper-container myloopto my-case">
            <div class="swiper-wrapper">
                <?php $homeCases = Photo::find()->where(['columnid' => Yii::$app->params['config_face_cn_home_case_column_id']])->orderBy(['posttime' => SORT_DESC])->limit(12)->asArray()->all(); ?>
                <?php foreach ($homeCases as $index => $homeCase) { ?>

                    <?php if($index%3 == 0) { ?>
                        <div class="swiper-slide"><div class="casebox">
                    <?php } ?>

                    <div class="case-list" style="height: 2.4rem;">
                        <div class="case-pic" style="height: 2.2rem;padding: .1rem;background: white;">
                            <a href="<?= empty($homeCase['linkurl'])?Url::to(['case/detail', 'slug' => $homeCase['slug']]):$homeCase['linkurl'] ?>">
                                <img title="<?= $homeCase['title'] ?>" src="<?= empty($homeCase['picurl'])?ImageHelper::getNopic():Yii::$app->aliyunoss->getObjectUrl($homeCase['picurl'], true) ?>" style="height: 2.2rem;">
                            </a>
                        </div>
                        <div class="case-text" style="height: 2.4rem;">
                            <a href="<?= empty($homeCase['linkurl'])?Url::to(['case/detail', 'slug' => $homeCase['slug']]):$homeCase['linkurl'] ?>">
                                <b class="case-time"><?= Yii::$app->getFormatter()->asDate($homeCase['posttime'], 'php:Y / m / d') ?></b>
                                <h3><?= $homeCase['title'] ?></h3>
                                <ul>
                                    <li><i class="iconfont jia-eye"></i> <?= $homeCase['hits'] ?> 次</li>
                                    <li><?= $homeCase['diyfield_case_address'] ?></li>
                                </ul>
                                <p><?= $homeCase['description'] ?></p>
                            </a>
                            <div class="case-tips">
                                <img class="tip" src="<?= $webUrl ?>images/yaqiao/case-tips.png">
                                <img class="tips" src="<?= $webUrl ?>images/yaqiao/case-tips-color.png">
                            </div>
                        </div>
                    </div>

                    <?php if(($index+1)%3 == 0) { ?>
                        </div></div>
                    <?php } ?>

                <?php } ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</div>

<div class="main">
    <div class="maintitle">
        <a href=""><p>客户好评</p></a>
        <a class="more" href="<?= Url::to(['/faqs/list']) ?>"><img src="<?= $webUrl ?>images/yaqiao/more.png"></a>
    </div>
    <div class="company">
        <div class="swiper-container myloopt my-review">
            <div class="swiper-wrapper">
                <?php $userConments = Ad::AdListByAdTypeId(Yii::$app->params['config_face_cn_home_conment_ad_type_id']); ?>
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
                        <div class="company-pic">
                            <a href="javascript:;">
                                <img class="company-pho" title="<?= $userConment['title'] ?>" src="<?= empty($userConment['picurl'])?ImageHelper::getNopic():Yii::$app->aliyunoss->getObjectUrl($userConment['picurl'], true) ?>" />
                                <img class="company-rec" src="<?= $webUrl ?>images/yaqiao/recommend2.png" />
                            </a>
                        </div>
                        <div class="company-box">
                            <div class="company-text">
                                <a href="javascript:;"><p><?= $userConment['title'] ?></p></a>
                                <dl>
                                    <dd>好评率：
                                        <img src="<?= $webUrl ?>images/yaqiao/star-org.png">
                                        <img src="<?= $webUrl ?>images/yaqiao/star-org.png">
                                        <img src="<?= $webUrl ?>images/yaqiao/star-org.png">
                                        <img src="<?= $webUrl ?>images/yaqiao/star-org.png">
                                        <img src="<?= $webUrl ?>images/yaqiao/star-org.png">
                                    </dd>
                                    <dd>评语：<?= $userSayContent['sub_title1'] ?> <?= $userSayContent['sub_title2'] ?></dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</div>

<div class="main">
    <div class="maintitle">
        <p>资讯中心</p>
        <a class="news-center more" href="<?= Url::to(['/news/list']) ?>"><img src="<?= $webUrl ?>images/yaqiao/more.png"></a>
    </div>
    <div class="maintab mainindex">
        <ul>
            <li class="maintab-color">
                <a href="javascript:;" data-href="<?= Url::to(['/news/list']) ?>">
                    <span></span>
                    <p>行业动态</p>
                </a>
            </li>
            <li>
                <a href="javascript:;" data-href="<?= Url::to(['/company/list']) ?>">
                    <span></span>
                    <p>公司新闻</p>
                </a>
            </li>
            <li>
                <a href="javascript:;" data-href="<?= Url::to(['/faqs/list']) ?>">
                    <span></span>
                    <p>常见问题</p>
                </a>
            </li>
        </ul>
    </div>
    <div class="gonglue">
        <ul class="gltab">
            <?php $newsList = Article::ActiveList(Article::class, Yii::$app->params['config_face_cn_home_news_column_id'], 3, null, true); ?>
            <?php foreach ($newsList as $key => $news) { ?>
            <?php
            if(empty($news['description'])) {
                $des = $news['content'];//去除图片链接
            } else {
                $des = $news['description'];
            }
            $note = StringHelper::truncate(strip_tags($des), 100);
            ?>
                <?php if(!empty($news['picurl'])) { ?>
                    <li class="gl-list">
                        <div class="gl-text">
                            <a href="<?= Url::to(['news/detail', 'slug' => $news['slug']]) ?>">
                                <div class="gl-title">
                                    <span class="gl-bg<?= $key+1 ?>"></span>
                                    <h3><?= $news['title'] ?></h3>
                                </div>
                                <dl class="gl-share">
                                    <dd><i class="iconfont jia-eye"></i> <?= $news['hits'] ?> 次</dd>
                                    <dd><i class="iconfont jia-calendar1"></i> <?= Yii::$app->getFormatter()->asDate($news['posttime'], 'php:Y/m/d') ?></dd>
                                </dl>
                                <p><?= $note ?></p>
                            </a>
                        </div>
                        <div class="gl-pic">
                            <a href="<?= Url::to(['news/detail', 'slug' => $news['slug']]) ?>">
                                <img title="<?= $news['title'] ?>" src="<?= empty($news['picurl'])?ImageHelper::getNopic():Yii::$app->aliyunoss->getObjectUrl($news['picurl'], true) ?>">
                            </a>
                        </div>
                    </li>
                <?php } else { ?>
                    <li class="gl-list">
                        <div class="gl-text" style="width: 100%;padding-right: 0;">
                            <a href="<?= Url::to(['news/detail', 'slug' => $news['slug']]) ?>">
                                <div class="gl-title">
                                    <span class="gl-bg<?= $key+1 ?>"></span>
                                    <h3><?= $news['title'] ?></h3>
                                </div>
                                <dl class="gl-share">
                                    <dd><i class="iconfont jia-eye"></i> <?= $news['hits'] ?> 次</dd>
                                    <dd><i class="iconfont jia-calendar1"></i> <?= Yii::$app->getFormatter()->asDate($news['posttime'], 'php:Y/m/d') ?></dd>
                                </dl>
                                <p><?= $note ?></p>
                            </a>
                        </div>
                    </li>
                <?php } ?>
            <?php } ?>
        </ul>
        <ul class="gltab">
            <?php $companyList = Article::ActiveList(Article::class, Yii::$app->params['config_face_cn_home_company_column_id'], 3, null, true); ?>
            <?php foreach ($companyList as $key => $company) { ?>
                <?php
                if(empty($company['description'])) {
                    $des = $company['content'];//去除图片链接
                } else {
                    $des = $company['description'];
                }
                $note = StringHelper::truncate(strip_tags($des), 100);
                ?>
                <?php if(!empty($company['picurl'])) { ?>
                    <li class="gl-list">
                        <div class="gl-text">
                            <a href="<?= Url::to(['news/detail', 'slug' => $company['slug']]) ?>">
                                <div class="gl-title">
                                    <span class="gl-bg<?= $key+1 ?>"></span>
                                    <h3><?= $company['title'] ?></h3>
                                </div>
                                <dl class="gl-share">
                                    <dd><i class="iconfont jia-eye"></i> <?= $company['hits'] ?> 次</dd>
                                    <dd><i class="iconfont jia-calendar1"></i> <?= Yii::$app->getFormatter()->asDate($company['posttime'], 'php:Y/m/d') ?></dd>
                                </dl>
                                <p><?= $note ?></p>
                            </a>
                        </div>
                        <div class="gl-pic">
                            <a href="<?= Url::to(['news/detail', 'slug' => $company['slug']]) ?>">
                                <img title="<?= $company['title'] ?>" src="<?= empty($company['picurl'])?ImageHelper::getNopic():Yii::$app->aliyunoss->getObjectUrl($company['picurl'], true) ?>">
                            </a>
                        </div>
                    </li>
                <?php } else { ?>
                    <li class="gl-list">
                        <div class="gl-text" style="width: 100%;padding-right: 0;">
                            <a href="<?= Url::to(['news/detail', 'slug' => $company['slug']]) ?>">
                                <div class="gl-title">
                                    <span class="gl-bg<?= $key+1 ?>"></span>
                                    <h3><?= $company['title'] ?></h3>
                                </div>
                                <dl class="gl-share">
                                    <dd><i class="iconfont jia-eye"></i> <?= $company['hits'] ?> 次</dd>
                                    <dd><i class="iconfont jia-calendar1"></i> <?= Yii::$app->getFormatter()->asDate($company['posttime'], 'php:Y/m/d') ?></dd>
                                </dl>
                                <p><?= $note ?></p>
                            </a>
                        </div>
                    </li>
                <?php } ?>
            <?php } ?>
        </ul>
        <ul class="gltab">
            <?php $questionList = Faqs::find()->orderBy(['posttime' => SORT_DESC])->limit(3)->asArray()->all() ?>
            <?php foreach ($questionList as $key => $question) { ?>
            <li class="glquestion">
                <a href="<?= Url::to(['/faqs/detail', 'slug' => $question['slug']]) ?>">
                    <b>问</b>
                    <div class="gl-box">
                        <h3><?= $question['title'] ?></h3>
                        <p><?= strip_tags($question['diyfield_ask_content']) ?></p>
                        <div class="gl-btm">
                            <dl>
                                <dd>回答于</dd>
                                <dd><i></i></dd>
                                <dd><?= Yii::$app->getFormatter()->asDate($question['posttime'], 'php:Y/m/d') ?></dd>
                            </dl>
                        </div>
                    </div>
                </a>
            </li>
            <?php } ?>
        </ul>
    </div>
</div>

<?= $this->render('_call_price') ?>

<div class="myblack"></div>