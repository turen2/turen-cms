<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use common\helpers\ImageHelper;
use yii\helpers\StringHelper;
use yii\helpers\Url;

//默认参数：$model, $key, $index, $widget
//Html::encode($model->title)
$length = 100;//标题截取长度
$link = Url::to(['/service/detail', 'slug' => $model->slug]);
?>

<div class="cover <?= $index ?>">
    <img class="cover-image removeimg" alt="<?= $model->title ?>" title="<?= $model->title ?>" src="<?= empty($model->picurl)?ImageHelper::getNopic():Yii::$app->aliyunoss->getObjectUrl($model->picurl, true) ?>">
    <div class="overlay-panel fadeimg">
        <h3 class="card-title"><?= StringHelper::truncate($model->title, $length) ?></h3>
        <a class="hot-btn" href="<?= $link ?>" title="<?= $model->title ?>">查看详情</a>
    </div>
</div>