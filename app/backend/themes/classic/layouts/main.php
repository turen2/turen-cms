<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Html;

use yii\base\Widget;
use yii\web\YiiAsset;
use backend\widgets\Alert;
use backend\assets\PaceAsset;
use backend\assets\WebAsset;
use backend\assets\FontAwesomeAsset;
use backend\assets\NotifyAsset;
use backend\assets\PureboxAsset;

/* @var $this \yii\web\View */
/* @var $content string */

PaceAsset::register($this);
YiiAsset::register($this);
FontAwesomeAsset::register($this);
NotifyAsset::register($this);//全局通知+提示
PureboxAsset::register($this);//全局确认框+弹窗+提示
WebAsset::register($this);

$baseUrl = Yii::getAlias('@web');
$this->registerJs("
    // $(document).ready(function() {
    // })
    paceOptions = {
        elements: true
    };
", \yii\web\View::POS_BEGIN);
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
    	<a onclick="$(this).find('i').addClass('fa-spin');" href="javascript:location.reload();" class="reload"><i class="fa fa-refresh"></i> 刷新</a>
        <?= $this->urlLink; ?>
	</div>
    
    <?= $content ?>
    
    <div class="loading4"></div>
	<div class="masklayer"></div>
    <?php $this->endBody(); ?>
    </body>
</html>
<?php $this->endPage(); ?>