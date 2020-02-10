<?php

use yii\helpers\Url;

$link = Url::to(['/case/detail', 'slug' => $model->slug]);

$webUrl = Yii::getAlias('@web/');
?>

<a href="<?= $link ?>">
    <div class="casebook-pic">
        <img class="item-bg" alt="<?= $model->title ?>" title="<?= $model->title ?>" src="<?= Yii::$app->aliyunoss->getObjectUrl($model->picurl, true) ?>" />
        <span><?= $model->diyfield_case_address ?></span></div>
    <div class="casebook-text">
        <h3 class="item-h3"><?= $model->title ?></h3>
        <dl>
            <dd><i class="iconfont jia-eye"></i> <?= $model->hits ?></dd>
            <dd><span></span></dd>
            <dd><?= Yii::$app->getFormatter()->asDateTime($model->posttime, 'php:Y/m/d') ?></dd>
        </dl>
        <div class="casebook-designer item-box">
            <i><img class="item-next" src="<?= $webUrl ?>images/yaqiao/next.png"></i>
        </div>
    </div>
</a>


