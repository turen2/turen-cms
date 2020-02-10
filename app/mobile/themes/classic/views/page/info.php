<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use common\helpers\Util;
use yii\helpers\Url;

$this->currentModel = $model;

$webUrl = Yii::getAlias('@web/');
?>

<div class="public-box"></div>

<div class="about-banner">
    <a href="<?= Url::to(['/online/price']) ?>">
        <img src="<?= $webUrl ?>images/yaqiao/about-us-banner.png" />
    </a>
</div>

<?= $this->render('_tab', ['slug' => $model->slug]) ?>

<div class="aboutus-company">
    <div class="profile">
        <?= strip_tags(Util::ContentPasswh($model->content), '<div><p><img><h1><h2><h3><h4><h5><h6><span><a>') ?>
        <?php if(strpos(Url::current(), 'lian-xi') !== false) { ?>
        <img src="<?= $webUrl ?>images/yaqiao/us-map.png" />
        <?php } ?>
    </div>
</div>
<div class="myblack"></div>

<?php
/*
ShareWidget::widget([
    'title' => '分享至：',
    'images' => $model->picurl?[Yii::$app->aliyunoss->getObjectUrl($model->picurl, true)]:[]
]);
*/
?>
