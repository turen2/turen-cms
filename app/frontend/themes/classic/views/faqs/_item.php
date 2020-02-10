<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 * Date: 2019/1/14
 * Time: 14:34
 */
use yii\helpers\Html;

//$model, $key, $index, $widget
?>
<li class="<?= (empty($index) && !$notfirst)?'first':''; ?><?= ($notfirst)?'ajax':''; ?>">
    <?php
    $options = ['style' => ''];
    if(!empty($model->colorval) || !empty($model->boldval)) {
        Html::addCssStyle($options, ['color' => $model->colorval, 'font-weight' => $model->boldval]);
    }
    echo Html::tag('h5',$model->title , ['class' => 'info-title', 'style' => $options['style']]);
    ?>
    <span class="post-time"><i class="iconfont jia-calendar1"></i>
        <?= Yii::$app->getFormatter()->asDateTime($model->posttime, 'php:Y年m月d日') ?>
    </span>
    <p class="info-content">
        <?= strip_tags($model->diyfield_ask_content) ?>
    </p>
    <?php
    if(!empty($model->flag)) {
        echo '<span class="ask-label">';
        echo '<i class="iconfont fa-tags"></i> ';
        $flags = explode(',', $model->flag);
        foreach ($flags as $flag) {
            echo '<a href="javascript:;"><i class="iconfont jia-label"></i> '.$flag.'</a>';
        }
        echo '</span>';
    }
    ?>
</li>