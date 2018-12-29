<?php
use app\models\CmsBlock;
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
                    $blockModel = CmsBlock::find()->current()->where(['id' => 1])->one();
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
                        <a href="<?= Url::to(['/member/order/list']) ?>">我的售后</a>
                    </div>
                </li>
                <li class="line">|</li>
                <li><a href="javascript:void(0);">常见问题</a></li>
                <li class="line">|</li>
                <li><a href="javascript:void(0)">搬家吉日</a></li>
            </ul>
        </div>
    </div>

    <div class="head head-bottom">
    	<div class="container clearfix">
    		<!-- logon -->
            <a href="" class="logo fl">
            	<img src="/images/logo.png">
        	</a>
        	
            <!-- 导航 -->
            <div class="nav fr">
                <ul class="fl">
                    <li>
                    	<a class="on" href="<?= Url::home() ?>">
                    		<span class="nav-title">首页</span>
                		</a>
            		</li>
            		<li>
                    	<a href="">
                    		<span class="nav-title">计价器</span>
                            <img class="nav-new" src="<?= $webUrl ?>images/common/new_3.png">
                		</a>
                    </li>
                    <li>
                    	<a href="" class="have-sub" data-subid="25">
                    		<span class="nav-title">业务范围</span>
                            <img class="nav-icon" src="<?= $webUrl ?>images/common/nav.png">
                    		<img class="hot" src="<?= $webUrl ?>images/common/hot.gif">
                		</a>
                    </li>
                    <li>
                    	<a href="">
                    		<span class="nav-title">服务流程</span>
                		</a>
            		</li>
                    <li>
                        <a href="">
                        	<span class="nav-title">案例展示</span>
                        </a>
                    </li>
                    <li>
                        <a href="" class="have-sub" data-subid="30">
                            <span class="nav-title">资讯中心</span>
                            <img class="nav-icon" src="<?= $webUrl ?>images/common/nav.png">
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span class="nav-title">在线客服</span>
                        </a>
                    </li>
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
    <ul class="header-nav-hide clearfix" id="sub-25" style="width: 1080px;">
        <li><a href=""><img src="<?= $webUrl ?>images/987.jpg" /><span>居民搬家</span></a></li>
        <li><a href=""><img src="<?= $webUrl ?>images/987.jpg" /><span>办公室搬迁</span></a></li>
        <li><a href=""><img src="<?= $webUrl ?>images/987.jpg" /><span>厂房搬迁</span></a></li>
        <li><a href=""><img src="<?= $webUrl ?>images/987.jpg" /><span>学校搬迁</span></a></li>
        <li><a href=""><img src="<?= $webUrl ?>images/987.jpg" /><span>钢琴搬运</span></a></li>
        <li><a href=""><img src="<?= $webUrl ?>images/987.jpg" /><span>仓库搬迁</span></a></li>
        <li><a href=""><img src="<?= $webUrl ?>images/987.jpg" /><span>服务器搬迁</span></a></li>
        <li><a href=""><img src="<?= $webUrl ?>images/987.jpg" /><span>空调移机</span></a></li>
        <li><a href="" class="last"><img src="<?= $webUrl ?>images/987.jpg" /><span>长途搬家</span></a></li>
    </ul>
    <ul class="header-nav-hide clearfix hide" id="sub-30" style="width: 360px;">
        <li><a href=""><img src="<?= $webUrl ?>images/987.jpg" /><span>搬家百科</span></a></li>
        <li><a href=""><img src="<?= $webUrl ?>images/987.jpg" /><span>行业动态</span></a></li>
        <li><a href="" class="last"><img src="<?= $webUrl ?>images/987.jpg" /><span>常见问题</span></a></li>
    </ul>
</div>