<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 * Date: 2019/1/7
 * Time: 18:20
 */
?>

<div class="<?= $style ?>-sidebox <?= $htmlClass ?> card">
    <?php if($style == 'tab') { ?>
        <div class="<?= $style ?>-sidebox-title">
            <h3><?= $title ?></h3>
            <?php if(!empty($moreLink)) { ?>
            <a target="_blank" class="link" href="<?= $moreLink ?>"><b>更多</b></a>
            <?php } ?>
        </div>
    <?php } elseif($style == 'gen') { ?>
        <h3>
            <p class="title"><?= $title ?></p>
            <?php if(!empty($moreLink)) { ?>
            <a target="_blank" class="link" href="<?= $moreLink ?>">更多</a>
            <?php } ?>
        </h3>
    <?php } ?>
    <div class="<?= $style ?>-sidebox-content">
        <div class="sidebox-<?= $type ?>">
            <?= $content ?>
        </div>
        <?php if(!empty($moreLink)) { ?>
        <?php //<p class="case-more"><a href="$moreLink">查看更多<i>∨</i></a></p> ?>
        <?php } ?>
    </div>
</div>
