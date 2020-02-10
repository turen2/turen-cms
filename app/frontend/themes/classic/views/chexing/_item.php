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
$length = 38;//标题截取长度
$link = Url::to(['/chexing/detail', 'slug' => $model->slug]);
?>

<?php
$str = substr($model->picurl, strpos($model->picurl, '==') + 2);
$pathInfo = pathinfo($str);
$infoArr = explode('x', $pathInfo['filename']);
$width = $infoArr[0];
$height = $infoArr[1];
$halfHeight = ceil($height*125/$width);
$halfHeight = empty($halfHeight)?'125':$halfHeight;
?>

<a href="<?= $link ?>" title="<?= $model->title ?>">
    <img title="<?= $model->title ?>" src="<?= empty($model->picurl)?ImageHelper::getNopic():Yii::$app->aliyunoss->getObjectUrl($model->picurl, true) ?>" style="margin-top: -<?= $halfHeight ?>px;" />
</a>

<div class="info">
    <?php
    $options = ['style' => ''];
    if(!empty($model->colorval) || !empty($model->boldval)) {
        Html::addCssStyle($options, ['color' => $model->colorval, 'font-weight' => $model->boldval]);
    }
    echo Html::a('<span class="title">'.StringHelper::truncate($model->title, $length).'</span>', $link, ['class' => 'textname', 'title' => $model->title, 'style' => $options['style']]);
    ?>
</div>