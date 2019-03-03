<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use app\assets\ToTopAsset;
use common\models\cms\Block;
use common\models\ext\Link;
use common\models\ext\Nav;
use yii\helpers\Html;

$webUrl = Yii::getAlias('@web/');
ToTopAsset::register($this);
$js = <<<EOF
$('.to-top').toTop({
    autohide: false,
    speed: 500,
    position: false
});
EOF;
$this->registerJs($js);

$blockModel = Block::find()->current()->where(['id' => Yii::$app->params['config_face_banjia_cn_left_bottom_block_id']])->one();
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
    				<h3>了解家乐邦<span class="more-friend-link"><a target="_blank" href="http://turen.com/banjia/faqs/index.html" class="external">更多帮助 »</a></span></h3>
    				<ul class="wp-tag-cloud">
                        <?php
                        $bottomLinks = Link::find()->current()->where(['link_type_id' => Yii::$app->params['config_face_banjia_cn_bottom_link_type_id']])->orderBy(['orderid' => SORT_DESC])->all();
                        foreach ($bottomLinks as $bottomLink) {
                            echo '<li>'.Html::a($bottomLink->webname, $bottomLink->linkurl).'</li>';
                        }
                        ?>
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
                <!-- 底部导航 -->
                <?php
                $menus = Nav::NavById(Yii::$app->params['config_face_banjia_cn_bottom_nav_id']);
                $bottomNav = $menus['main'];
                //$subBottomNav = $menus['sub'];

                foreach ($bottomNav as $index => $item) {
                    echo Html::a($item->menuname, $item->linkurl, ['target' => $item->target]);
                    if($index != count($bottomNav)-1) {
                        echo ' |';
                    }
                }
                ?>
            </p>
        	<p class="footer-c">2016-<?= date('Y') ?> <?= Yii::$app->params['config_copyright'] ?> - <?= Yii::$app->params['config_icp_code'] ?> <a target="_blank" href="http://www.turen2.com">技术支持</a></p>
        </div>
    </div>
</div>

<div class="call-me">
    <div class="center-box container">
        <span class="left-part"><img src="/images/logo.png"></span>
        <span class="mid-part">仅需3秒钟马上出发，一站式服务！</span>
        <span class="right-part"><i>Customer Hot Line</i><b>400-400-4000</b></span>
        <a href="" id="custon_button1" class="call-btn">立即咨询</a>
        <a href="" class="bre-btn">立即下单</a>
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
    <a class="to-top" href="javascript:;"></a>
</div>
