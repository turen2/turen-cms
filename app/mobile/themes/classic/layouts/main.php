<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\YiiAsset;
use app\assets\AnimateAsset;
use app\assets\IconfontAsset;
use app\assets\AppAsset;

AnimateAsset::register($this);
IconfontAsset::register($this);
YiiAsset::register($this);
AppAsset::register($this);

//$this->registerJs();
//$this->registerCss();

$hostInfo = Yii::$app->getUrlManager()->getHostInfo();
$hostInfo = substr($hostInfo, 0, strpos($hostInfo, '://'));
$pcUrl = Url::current([], $hostInfo);
$pcUrl = str_replace('://m.hbyaqiao.', '://hbyaqiao.', $pcUrl);

$webUrl = Yii::getAlias('@web/');
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="format-detection" content="telphone=no, email=no">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
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
        // whatdevice.go2mob('手机网站网址');

        // 手机中使用
        // whatdevice.go2web('<?= $pcUrl ?>');
    </script>

    <?php // 移动客户，流量代码 ?>
    <?= Yii::$app->params['config_mobile_count_code'] ?>
</head>
<body class="">
<?php $this->beginBody() ?>

<?= $this->render('_header', ['url' => $this->topUrl, 'title' => $this->title]) ?>

<?= $content ?>

<?= $this->render('_footer') ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>