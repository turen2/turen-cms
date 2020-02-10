<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 * Date: 2019/1/14
 * Time: 14:34
 */
use yii\helpers\Html;
use yii\helpers\Url;

$webUrl = Yii::getAlias('@web/');

//$model, $key, $index, $widget
$link = Url::to(['/faqs/detail', 'slug' => $model->slug]);

$options = ['style' => ''];
if(!empty($model->colorval) || !empty($model->boldval)) {
    Html::addCssStyle($options, ['color' => $model->colorval, 'font-weight' => $model->boldval]);
}
?>

<a href="<?= $link ?>">
    <div class="question">
        <?= Html::tag('h3', $model->title , ['style' => $options['style']]); ?>
    </div>
    <div class="answer">
        <p><span>答</span><font><?= strip_tags($model->diyfield_ask_content) ?></font></p>
        <dl>
            <dd><img class="answer-praise" src="<?= $webUrl ?>images/yaqiao/time2.png"><?= Yii::$app->getFormatter()->asDateTime($model->posttime, 'php:Y年m月d日') ?></dd>
        </dl>
    </div>
</a>