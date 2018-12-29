<?php 
$webUrl = Yii::getAlias('@web/');

use app\models\CmsBlock;

$blockModel = CmsBlock::find()->current()->where(['id' => 2])->one();
if($blockModel) {
    $aboutUsTitle = $blockModel->title;
    $aboutUsContent = $blockModel->content;
} else {
    $aboutUsTitle = 'bottom_aboutus标题';
    $aboutUsContent = '在后台碎片管理添加，简码为“bottom_aboutus”';
}
?>

<div class="footer">
    <div class="footer-content">
        <div class="container">
        	<div class="footer-ulist clearfix">
        		<div class="inner-block first">
    				<h3><?= $aboutUsTitle ?></h3>
    				<div class="inner-con">
                        <?= $aboutUsContent ?>
    				</div>
    			</div>
    			<div class="inner-block second">
    				<h3>主要业务</h3>
    				<div class="inner-con designer-recom">
    					<a href="" class="external" title="家政服务">
    						<img src="<?= $webUrl ?>images/nav/small-jzfw.png">
						</a>
    					<a href="" class="external" title="管道疏通">
    						<img src="<?= $webUrl ?>images/nav/small-gdst.png">
						</a>
    					<a href="" class="external" title="环保除虫">
    						<img src="<?= $webUrl ?>images/nav/small-hbqc.png">
						</a>
    					<a href="" class="external" title="搬家搬运">
    						<img src="<?= $webUrl ?>images/nav/small-bjby.png">
						</a>
    				</div>
    			</div>
    			<div class="inner-block third">
    				<h3>了解家乐邦<span class="more-friend-link"><a href="" class="external">更多帮助 »</a></span></h3>
    				<ul class="wp-tag-cloud">
                    	<li><a href="" title="">经验分享经验分享</a></li>
                    	<li><a href="" title="">网页设计网页设计</a></li>
                    	<li><a href="" title="">PS教程PS教程</a></li>
                    	<li><a href="" title="">酷站酷站酷站</a></li>
                    	<li><a href="" title="">App设计App设计</a></li>
                    	<li><a href="" title="">职场规划职场</a></li>
                    	<li><a href="" title="">神器推荐器推荐</a></li>
                    	<li><a href="" title="">ICONICON</a></li>
                    </ul>
    			</div>
    			<div class="inner-block last">
    				<h3>手机版访问</h3>
    				<div class="inner-con">
    					<div class="wap-qrcode">
    						<img src="<?= $webUrl ?>images/qrcode.png" />
    						<p>手机版一扫"掌"握！</p>
    					</div>
    				</div>
    			</div>
        	</div>
            <p class="footer-nav">
                <a href="">首页</a> |
                <a href="">关于家乐邦</a> |
                <a href="">媒体报道</a> |
                <a href="">人才招聘</a> |
                <a href="">联系我们</a> |
                <a href="">商务合作</a> |
                <a href="">帮助中心</a> |
                <a href="">联系客服</a> |
                <a href="">手机客版</a>
            </p>
        	<p class="footer-c">© 2017-2018  - xxxxxxxxxxx有限公司 旗下网站 - xICP备8577444406</p>
        </div>
    </div>
</div>

<!-- 快捷服务 -->
<div class="fixe-right">
    <a href="javascript:;">联系客服</a>
    <a href="javascript:;">在线预约</a>
    <a href="javascript:;">免费报价</a>
    <a href="javascript:;">
        <div style="display: none; opacity: 0; left: -163px;">
            <p>
                <img src="<?= $webUrl ?>images/xcx.png">
                <span>扫描小程序</span>
                <em>看装修直播</em>
            </p>
            <p>
                <img src="<?= $webUrl ?>images/shequn.png">
                <span>立即扫码入群</span>
                <em>领一手优惠福利</em>
            </p>
            <img src="<?= $webUrl ?>images/fixe_ma_2.png">
        </div>
    </a>
    <a href="javascript:;"></a>
</div>
