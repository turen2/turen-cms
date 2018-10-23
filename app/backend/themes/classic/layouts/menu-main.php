<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Html;

$baseUrl = Yii::getAlias('@web');
//用户相关，重点注意
//if (Yii::$app->user->getIsGuest()) {
    //return;//后面的代码将不再执行，返回void
//}
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="renderer" content="webkit">
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