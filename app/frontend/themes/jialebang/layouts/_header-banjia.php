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

$webUrl = Yii::getAlias('@web/');
?>

<div class="header">
    <div class="head head-top">
        <div class="container clearfix">
        	<div class="head-note fl">
                <i class="fa fa-bullhorn"></i>
                <span><span class="primary-color">公告：</span>
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
                <li><a href="<?= Url::to(['/member/user/login']) ?>">请登录</a></li>
                <li class="line">|</li>
                <li><a href="<?= Url::to(['/member/user/signup']) ?>">立即注册</a></li>
                <li class="line">|</li>
                <li class="drop">
                    <a class="drop-title" href="<?= Url::to(['/member/user/info']) ?>">用户中心<b></b></a>
                    <div class="drop-content">
                        <a href="<?= Url::to(['/member/order/list']) ?>" rel="nofollow">我的订单</a>
                        <a href="<?= Url::to(['/member/order/list']) ?>" rel="nofollow">我的咨询</a>
                        <a href="<?= Url::to(['/member/order/list']) ?>" rel="nofollow">我的预约</a>
                        <a href="<?= Url::to(['/member/order/list']) ?>">我的售后</a>
                    </div>
                </li>
                <li class="line">|</li>
                <li><a href="<?= Url::to(['/banjia/faqs/index']) ?>">常见问题</a></li>
                <li class="line">|</li>
                <li><a href="<?= Url::to(['/banjia/page/info', 'slug' => 'chexing-shibei']) ?>">车型识别</a></li>
                <li class="line">|</li>
                <li><a href="<?= Url::to(['/banjia/calendar/index']) ?>">搬家吉日</a></li>
            </ul>
        </div>
    </div>

    <div class="head head-bottom">
    	<div class="container clearfix">
    		<!-- logon -->
            <a href="" class="logo fl">
            	<img src="/images/logo.png">
        	</a>
        	
            <!-- 主导航 -->
            <?php
            $menus = Nav::NavById(Yii::$app->params['config_face_banjia_cn_main_nav_id']);
            $mainNav = $menus['main'];
            $subNav = $menus['sub'];
            ?>
            <div class="nav fr">
                <ul class="fl">
                    <li>
                    	<a class="" href="<?= Yii::$app->homeUrl ?>">
                    		<span class="nav-title">首页</span>
                		</a>
            		</li>
                    <?php foreach ($mainNav as $item) { ?>
                    <li>
                        <a href="<?= $item->linkurl ?>"<?= empty($item->target)?'':' target='.$item->target ?><?= empty($subNav[$item->id])?'':(' class="have-sub" data-subid="'.$item->id.'"') ?>>
                            <span class="nav-title"><?= $item->menuname ?></span>
                            <?php if(!empty($item->picurl)) { ?>
                                <img class="label" src="<?= empty($item->picurl)?ImageHelper::getNopic():Yii::$app->aliyunoss->getObjectUrl($item->picurl, true) ?>">
                            <?php } ?>
                        </a>
                    </li>
                    <?php } ?>
                </ul>
                <div class="nav-qrcode">
                    <a href="javascript:;">
                        <img class="wap" src="<?= $webUrl ?>images/common/nav_app.png">
                        <p class="nav-box nav-wap">
                            <img class="nav-qr" src="<?= $webUrl ?>images/common/xcx.png">
                            <br />
                            <span class="qr-txt">手机版访问</span>
                        </p>
                    </a>
                    <a href="javascript:;">
                        <img class="wx" src="<?= $webUrl ?>images/common/nav_weixin.png">
                        <p class="nav-box nav-wx">
                            <img class="nav-qr" src="<?= $webUrl ?>images/common/xcx.png">
                            <br />
                            <span class="qr-txt">官方客服</span>
                        </p>
                    </a>
                </div>
            </div>
    	</div>
    </div>
</div>

<div class="nav-bg">
    <?php foreach ($subNav as $pid => $items) { ?>
    <ul class="header-nav-hide clearfix" id="sub-<?= $pid ?>" style="width: <?= count($items)*120 ?>px;">
    <?php $ii = 0;  ?>
    <?php foreach ($items as $item) { ?>
    <?php $ii++; ?>
        <li><a<?= (count($items) == $ii)?' class="last"':'' ?> href="<?= $item->linkurl ?>"<?= empty($item->target)?'':' target="'.$item->target.'"' ?> title="<?= $item->menuname ?>"><img src="<?= empty($item->picurl)?ImageHelper::getNopic():Yii::$app->aliyunoss->getObjectUrl($item->picurl, true) ?>" /><span><?= $item->menuname ?></span></a></li>
    <?php } ?>
    </ul>
    <?php } ?>
</div>