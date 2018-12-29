<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\assets\AppBanjiaAsset;
use app\assets\FontAwesomeAsset;

FontAwesomeAsset::register($this);
AppBanjiaAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link type="image/x-icon" href="/favicon.ico" rel="shortcut icon">
    <?php $this->head() ?>
    <?= $this->render('_config') ?>
</head>
<body class="">
<?php $this->beginBody() ?>

<?= $this->render('_header-banjia') ?>

<div class="banjia-home">
    <?= $content ?>
</div>

<?= $this->render('_footer-banjia') ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>