<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

/* @var $this \yii\web\View */
/* @var $content string */

use frontend\assets\IconfontAsset;
use frontend\assets\PinAsset;
use yii\helpers\Html;
use frontend\assets\AppAsset;
use yii\helpers\Url;
use yii\web\YiiAsset;

IconfontAsset::register($this);
YiiAsset::register($this);
PinAsset::register($this);
AppAsset::register($this);

$hostInfo = Yii::$app->getUrlManager()->getHostInfo();
$hostInfo = substr($hostInfo, 0, strpos($hostInfo, '://'));
$mobileUrl = Url::current([], $hostInfo);
$mobileUrl = str_replace('://hbyaqiao.', '://m.hbyaqiao.', $mobileUrl);

$webUrl = Yii::getAlias('@web/');
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<!--[if IE 7 ]><html lang="en" class="ie7 ielt8 ielt9 ielt10 en"><![endif]-->
<!--[if IE 8 ]><html lang="en" class="ie8 ielt9 ielt10 en"><![endif]-->
<!--[if IE 9 ]><html lang="en" class="ie9 ielt10 en"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html lang="<?= Yii::$app->language ?>">
<!--<![endif]-->
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <!--<meta http-equiv="X-UA-Compatible" content="IE=8"/>-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <?php $this->initSeo() ?>
    <title><?= Html::encode($this->title) ?> - <?= Yii::$app->params['config_site_name'] ?></title>
    <meta content="<?= Html::encode($this->keywords) ?>" name="keywords">
    <meta content="<?= Html::encode($this->description) ?>" name="description">
    <link type="image/x-icon" href="<?= $webUrl ?>favicon.ico" rel="shortcut icon">
    <?php $this->head() ?>
    <?= $this->render('_config') ?>

    <script src="<?= $webUrl ?>js/whatdevice.min.js"></script>

    <script>
        // 电脑中使用
        // whatdevice.go2mob('<?= $mobileUrl ?>');

        // 手机中使用
        // whatdevice.go2web('http://hbyaqiao.com?t=mobile');
    </script>

    <?php // 客户，流量代码 ?>
    <?= Yii::$app->params['config_count_code'] ?>
</head>
<body class="">
<?php $this->beginBody() ?>
<!--[if lt IE 9]><div class="alert alert-danger topframe" role="alert">你的浏览器实在<strong>太太太旧了</strong>，请 <a target="_blank" class="alert-link" href="http://browsehappy.com">立即升级</a> 以保障您的上网安全。</div><![endif]-->

<?= $this->render('_header') ?>

<div class="turen-<?= Yii::$app->controller->id ?>">
    <?= $content ?>
</div>

<?= $this->render('_footer') ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>