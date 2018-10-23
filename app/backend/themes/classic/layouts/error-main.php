<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
use yii\helpers\Html;

use yii\web\YiiAsset;
use app\assets\WebAsset;
use app\assets\FontAwesomeAsset;
use app\assets\NotifyAsset;

YiiAsset::register($this);
FontAwesomeAsset::register($this);
NotifyAsset::register($this);//全局通知+提示
WebAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title.' - '.Yii::$app->name)?></title>
        <link type="image/x-icon" href="./favicon.ico" rel="shortcut icon">
        <?php $this->head() ?>
        <?= $this->render('_config') ?>
    </head>
    <body>
    <?php $this->beginBody() ?>
    
    <?= $content ?>
    
    <?php $this->endBody(); ?>
    </body>
</html>
<?php $this->endPage(); ?>