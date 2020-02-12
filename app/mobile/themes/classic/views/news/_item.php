<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use yii\helpers\Html;
use yii\helpers\Url;

//默认参数：$model, $key, $index, $widget
//Html::encode($model->title)
$link = Url::to(['/news/detail', 'slug' => $model->slug]);
$options = ['style' => ''];
if(!empty($model->colorval) || !empty($model->boldval)) {
    Html::addCssStyle($options, ['color' => $model->colorval, 'font-weight' => $model->boldval]);
}

$webUrl = Yii::getAlias('@web/');
?>

<a href="<?= $link ?>">
    <?php if(!empty($model->picurl)) { ?>
    <div class="related-pic">
        <img src="<?= Yii::$app->aliyunoss->getObjectUrl($model->picurl, true) ?>" style="width:2.8rem;height: 2.3rem;" />
    </div>
    <?php } ?>
    <div class="related-text"<?= empty($model->picurl)?' style="width: 100%;padding-bottom: .16rem;"':'' ?>>
        <?= Html::tag('h3', $model->title, ['style' => $options['style']]) ?>
        <p>
            <?php
            if(empty($model->description)) {
                $des = $model->content;//去除图片链接
            } else {
                $des = $model->description;
            }
            echo strip_tags($des);
            ?>
        </p>
        <dl>
            <dd><i class="iconfont jia-eye"></i> <?= $model->base_hits + $model->hits ?></dd>
            <dd><span></span></dd>
            <dd><?= Yii::$app->getFormatter()->asDate($model->posttime) ?></dd>
        </dl>
    </div>
</a>


