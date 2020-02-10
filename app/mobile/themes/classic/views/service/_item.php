<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use common\helpers\ImageHelper;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

//默认参数：$model, $key, $index, $widget
//Html::encode($model->title)
$link = Url::to(['/service/detail', 'slug' => $model->slug]);

$options = ['style' => 'text-align: center;'];
if(!empty($model->colorval) || !empty($model->boldval)) {
    Html::addCssStyle($options, ['color' => $model->colorval, 'font-weight' => $model->boldval]);
}
$img = empty($model->picurl)?ImageHelper::getNopic():Yii::$app->aliyunoss->getObjectUrl($model->picurl, true);

$webUrl = Yii::getAlias('@web/');
?>

<a href="<?= $link ?>">
    <div class="about-pic">
        <img src="<?= $img ?>">
    </div>
    <div class="about-text" style="height: 0.5rem;">
        <?= Html::tag('p', $model->title, ['style' => $options['style']]); ?>
    </div>
</a>
