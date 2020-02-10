<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Html;

use yii\web\YiiAsset;
use backend\assets\LoginAsset;
use backend\assets\NotifyAsset;

/* @var $this \yii\web\View */
/* @var $content string */

YiiAsset::register($this);
NotifyAsset::register($this);//全局通知+提示
LoginAsset::register($this);

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
    <body class="admin-login">
        <?php $this->beginBody() ?>
        	<div class="login-box">
        		<?= $content ?>
            </div>
			<p class="login-foot"><?= Yii::$app->params['config_copyright'] ?> 粤ICP备<?= Yii::$app->params['config_icp_code'] ?>号</p>
        <?php $this->endBody(); ?>
    </body>
</html>
<?php $this->endPage(); ?>