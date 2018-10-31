<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\assets\AppAsset;

AppAsset::register($this);
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
    <title><?= Html::encode($this->title).'PC端' ?></title>
    <link type="image/x-icon" href="./favicon.ico" rel="shortcut icon">
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<p style="border: 1px solid green;">这里是pc模板布局.....</p>
<p style="border: 1px solid blue;">当前语言包：<?= Yii::$app->language ?>，当前模板：<?= Yii::$app->viewPath ?></p>
<?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>