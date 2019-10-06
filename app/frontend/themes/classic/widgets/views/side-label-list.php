<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 * Date: 2019/1/7
 * Time: 18:20
 */
use yii\helpers\Html;
?>

<div class="<?= $htmlClass ?> card">
    <h3><?= $title ?></h3>
    <ul>
        <?php
        foreach ($tagList as $tag) {
            echo Html::begintag('li');
            $route['tag'] = $tag['name'];
            echo Html::a($tag['name'], $route, ['target' => '_blank']);
            echo Html::endTag('li');
        }
        ?>
    </ul>
</div>