<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\PinAsset;
use yii\helpers\Html;
use app\assets\AppBanjiaAsset;
use app\assets\FontAwesomeAsset;
use yii\web\YiiAsset;

FontAwesomeAsset::register($this);
YiiAsset::register($this);
PinAsset::register($this);
AppBanjiaAsset::register($this);

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
    <!--<meta name="renderer" content="webkit">-->
    <!--<meta http-equiv="X-UA-Compatible" content="IE=8"/>-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?>-<?= Yii::$app->params['config_site_name'] ?></title>
    <link type="image/x-icon" href="/favicon.ico" rel="shortcut icon">
    <?php $this->head() ?>
    <?= $this->render('_config') ?>
</head>
<body class="">
<?php $this->beginBody() ?>
<!--[if lt IE 9]><div class="alert alert-danger topframe" role="alert">你的浏览器实在<strong>太太太旧了</strong>，请 <a target="_blank" class="alert-link" href="http://browsehappy.com">立即升级</a> 以保障您的上网安全。</div><![endif]-->

<?= $this->render('_header-banjia') ?>

<div class="turen-<?= Yii::$app->controller->id ?>">
    <?= $content ?>
</div>

<?= $this->render('_footer-banjia') ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>