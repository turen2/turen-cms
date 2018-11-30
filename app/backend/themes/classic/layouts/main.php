<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Html;

use app\widgets\Alert;
use yii\base\Widget;
use yii\web\YiiAsset;
use app\assets\WebAsset;
use app\assets\FontAwesomeAsset;
use app\assets\NotifyAsset;
use app\assets\PureboxAsset;

/* @var $this \yii\web\View */
/* @var $content string */

YiiAsset::register($this);
FontAwesomeAsset::register($this);
NotifyAsset::register($this);//全局通知+提示
PureboxAsset::register($this);//全局确认框+弹窗+提示
WebAsset::register($this);

$baseUrl = Yii::getAlias('@web');
// $this->registerJs("
//         $(document).ready(function() {
//             //
//         })
// ");
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
    <?= $this->topAlert ?>
    <?= Alert::widget();// 持久信息层 ?>
    <div class="top-toolbar">
    	<span class="title"><?= $this->title ?></span>
    	<?= $this->topFilter ?>
    	<a href="javascript:location.reload();" class="reload"><i class="fa fa-refresh"></i> 刷新</a>
	</div>
    
    <?= $content ?>
    
    <div class="loading4"></div>
	<div class="masklayer"></div>
    <?php $this->endBody(); ?>
    </body>
</html>
<?php $this->endPage(); ?>