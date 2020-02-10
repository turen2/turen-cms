<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 * Date: 2019/1/7
 * Time: 18:20
 */

$webUrl = Yii::getAlias('@web/');
?>

<div class="related-recommend <?= $htmlClass ?>">
    <div class="question-top">
        <h2><?= $title ?></h2>
        <?php if(!empty($moreLink)) { ?>
            <a class="more" href="<?= $moreLink ?>"><img src="<?= $webUrl ?>images/yaqiao/more.png"></a>
        <?php } ?>
    </div>
    <div class="related-box">
        <?= $content ?>
    </div>
</div>