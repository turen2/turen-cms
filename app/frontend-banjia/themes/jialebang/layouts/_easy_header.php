<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use common\models\cms\Block;
use common\models\ext\Nav;
use common\helpers\ImageHelper;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;
use app\assets\LimarqueeAsset;

$webUrl = Yii::getAlias('@web/');
LimarqueeAsset::register($this);
$js = <<<EOF
$('.scroll-note').liMarquee({
    scrollamount: 30,
    //circular: false,//非无疑滚动
    drag: false,//禁止拖动
    runshort: false//内容不足不滚动
});
EOF;
$this->registerJs($js);
?>

<div class="head-top" style="display: none;">
    <div class="container clearfix">
        <div class="head-note fl">
                <span class="fl">
                    <i class="fa fa-bullhorn"></i>
                    <span class="primary-color">公告：</span>
                </span>
            <span class="scroll-note fl">
                <?php
                $blockModel = Block::find()->current()->where(['id' => Yii::$app->params['config_face_banjia_cn_left_top_block_id']])->one();
                if($blockModel) {
                    echo HtmlPurifier::process($blockModel->content, function($config) {
                        $config->set('HTML.Allowed', 'a[href]');
                        $config->set('HTML.TargetBlank', true);
                        $config->set('AutoFormat.RemoveEmpty', true);
                    });
                } else {
                    echo '<span>请创建简码为“top_note”的碎片。</span>';
                }
                ?>
                </span>
        </div>
        <ul class="head-list fr">
            <?php if(Yii::$app->getUser()->isGuest) { ?>
                <li><a href="<?= Url::to(['/account/user/login']) ?>">请登录</a></li>
                <li class="line">|</li>
                <li><a href="<?= Url::to(['/account/user/signup']) ?>">免费注册</a></li>
            <?php } else { ?>
                <li style="padding-right: 12px;">欢迎 <?= Yii::$app->getUser()->getIdentity()->username ?> [<a style="display: inline;padding: 0 2px 0 2px;" href="<?= Url::to(['/account/user/logout']) ?>" data-method="post">退出</a>]</li>
            <?php } ?>
            <li class="line">|</li>
            <li class="drop">
                <a class="drop-title" href="<?= Url::to(['/account/user/info']) ?>">客户中心<b></b></a>
                <div class="drop-content">
                    <a href="<?= Url::to(['/account/order/list']) ?>" rel="nofollow">服务订单</a>
                    <a href="<?= Url::to(['/account/ticket/list']) ?>" rel="nofollow">工单管理</a>
                    <a href="<?= Url::to(['/account/company/info']) ?>" rel="nofollow">企业资质</a>
                    <a href="<?= Url::to(['/account/msg/list']) ?>" rel="nofollow">消息中心</a>
                </div>
            </li>
            <li class="line">|</li>
            <li><a href="<?= Url::to(['/faqs/index']) ?>">常见问题</a></li>
            <li class="line">|</li>
            <li><a href="<?= Url::to(['/page/info', 'slug' => 'chexing-shibei']) ?>">车型识别</a></li>
            <li class="line">|</li>
            <li><a href="<?= Url::to(['/calendar/index']) ?>">搬家吉日</a></li>
        </ul>
    </div>
</div>

<div class="easy-header">
    <div class="container">
        <a class="fl" href="<?= Yii::$app->homeUrl ?>">
            <img class="easy-logo" src="<?= empty(Yii::$app->params['config_frontend_logo'])?ImageHelper::getNopic():Yii::$app->aliyunoss->getObjectUrl(Yii::$app->params['config_frontend_logo'], true) ?>">
        </a>
        <a href="<?= Yii::$app->getHomeUrl() ?>" class="top-link fr" style="padding-right: 60px;font-size: 14px;color: #999;">跳转到首页>></a>
    </div>
</div>