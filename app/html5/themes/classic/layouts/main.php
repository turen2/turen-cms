<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\assets\H5Asset;
use app\assets\AppAsset;

H5Asset::register($this);
AppAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" style="">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 user-scalable=no">
    <script>document.documentElement.style.fontSize =document.documentElement.clientWidth/750*40 +"px";</script>
    <?= Html::csrfMetaTags() ?>
    <meta name="format-detection" content="telephone=no">
    <title><?= Html::encode($this->title).'-'.Yii::$app->language.'-'.Yii::$app->viewPath ?></title>
    <link type="image/x-icon" href="./favicon.ico" rel="shortcut icon">
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="fui-page-group ">
	<div class="fui-page fui-page-current">
		<div class="fui-header fui-header-success">
			<div class="fui-header-left"></div>
			<div class="title">默认首页</div>
			<div class="fui-header-right"></div>
		</div>
		
		<?= $content ?>
		
	</div>
	
	<?php if(!empty(Yii::$app->params['maninav'])) { ?>
	<div class="fui-navbar">
		<a href="" class="external nav-item active">
    		<span class="icon icon-home"></span>
    		<span class="label">工作台</span>
		</a>
		<a href=".member" class="external nav-item">
    		<span class="icon icon-group"></span>
    		<span class="label">会员</span>
		</a>
		<a href="1" class="external nav-item">
			<span class="icon icon-rejectedorder"></span>
			<span class="label">订单</span>
		</a>
		<a href=".finance" class="external nav-item">
			<span class="icon icon-home"></span>
			<span class="label">财务</span>
		</a>
		<a href=".set" class="external nav-item">
			<span class="icon icon-set"></span>
			<span class="label">设置</span>
		</a>
	</div>
	<?php } ?>
	
	<div class="wap-qrcode-container">
		<p class="example1">豹品云淘官方商城</p>
		<div class="wap-qrcode-image" id="wap-qrcode">
			<canvas width="256" height="256"></canvas>
		</div>
		<p class="example1">微信“扫一扫”浏览</p>
	</div>
	<a class="diy-gotop external" style="position: fixed; overflow: hidden; z-index: 999; bottom: 55px; right: 10px; text-align: left; display: none;" id="gotop">
		<div style="background: #ff8000; opacity: 0.5; line-height: 34px; text-align: center; border-radius: 32px; height: 32px; width: 32px;">
			<i class="icon icon-top1" style="color: #ffffff; font-size: 22px;"></i>
		</div>
	</a>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>