<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use frontend\assets\ToTopAsset;
use common\helpers\ImageHelper;
use common\models\cms\Block;
use common\models\ext\LinkType;
use common\models\ext\Link;
use common\models\ext\Nav;
use yii\helpers\Html;
use yii\helpers\Url;

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

$blockModel = Block::findOne(['id' => Yii::$app->params['config_face_cn_left_bottom_block_id']]);
if($blockModel) {
    $aboutUsTitle = $blockModel->title;
    $aboutUsContent = $blockModel->content;
} else {
    $aboutUsTitle = '碎片标题';
    $aboutUsContent = '在后台碎片管理添加';
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
    				<h3>从业资质</h3>
    				<div class="inner-con designer-recom">
                        <a href="javascript:;" class="external" title="营业执照">
                            <img src="<?= $webUrl ?>images/zizhi/111.jpg">
                        </a>
    					<a href="javascript:;" class="external" title="优秀企业">
    						<img src="<?= $webUrl ?>images/zizhi/222.jpg">
						</a>
    					<a href="javascript:;" class="external" title="安全生产">
    						<img src="<?= $webUrl ?>images/zizhi/333.jpg">
						</a>
    					<a href="javascript:;" class="external" title="诚信企业">
    						<img src="<?= $webUrl ?>images/zizhi/555.jpg">
						</a>
    					<a href="javascript:;" class="external" title="资质等级证书">
    						<img src="<?= $webUrl ?>images/zizhi/666.jpg">
						</a>
    				</div>
    			</div>
    			<div class="inner-block third">
                    <?php
                    $bottomLinkType = LinkType::findOne(['id' => Yii::$app->params['config_face_cn_bottom_link_type_id']]);
                    $bottomLinks = Link::find()->current()->active()->where(['link_type_id' => Yii::$app->params['config_face_cn_bottom_link_type_id']])->orderBy(['orderid' => SORT_DESC])->all();
                    ?>
    				<h3><?= is_null($bottomLinkType)?'':$bottomLinkType->typename ?><span class="more-friend-link"><a target="_blank" href="<?= Url::to(['/faqs/index']) ?>" class="external">更多帮助 »</a></span></h3>
    				<ul class="wp-tag-cloud">
                        <?php
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
                            <img src="<?= empty(Yii::$app->params['config_mobile_qr'])?ImageHelper::getNopic():Yii::$app->aliyunoss->getObjectUrl(Yii::$app->params['config_mobile_qr'], true) ?>">
                            <p>手机版一扫"掌"握！</p>
    					</div>
    				</div>
    			</div>
        	</div>
            <p class="footer-nav">
                <!-- 底部导航 -->
                <?php
                $menus = Nav::NavById(Yii::$app->params['config_face_cn_bottom_nav_id']);
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
        	<p class="footer-c">2016-<?= date('Y') ?> ©版权所有：<?= Yii::$app->params['config_copyright'] ?> -
                <?= Yii::$app->params['config_icp_code'] ?> <a target="_blank" href="http://www.turen2.com">技术支持</a>
                <span><?php echo number_format( (microtime(true) - YII_BEGIN_TIME), 3) . 's'; ?></span>
                <img src="<?= $webUrl ?>images/baidu.gif" alt="百度统计" />
            </p>
        </div>
    </div>
</div>

<?= $this->render('_fixed_nav') ?>

<div class="call-me">
    <div class="center-box container">
        <span class="left-part"><img src="<?= empty(Yii::$app->params['config_frontend_logo'])?ImageHelper::getNopic():Yii::$app->aliyunoss->getObjectUrl(Yii::$app->params['config_frontend_logo'], true) ?>"></span>
        <span class="mid-part">仅需3秒钟马上出发，一站式服务！</span>
        <span class="right-part"><i>Customer Hot Line</i><b>400-400-4000</b></span>
        <a href="" id="custon_button1" class="call-btn">立即咨询</a>
        <a href="" class="bre-btn">立即下单</a>
    </div>
</div>