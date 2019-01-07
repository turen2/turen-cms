<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 * Date: 2019/1/7
 * Time: 18:20
 */
?>

<div class="<?= $style ?>-sidebox">
    <?php if($style == 'tab') { ?>
        <div class="<?= $style ?>-sidebox-title">
            <h3><?= $title ?></h3>
            <a target="_blank" class="link" href="<?= $moreLink ?>"><b>更多</b></a>
        </div>
    <?php } elseif($style == 'gen') { ?>
        <h3>
            <p class="title"><?= $title ?></p>
            <a target="_blank" class="link" href="<?= $moreLink ?>">更多</a>
        </h3>
    <?php } ?>
    <div class="<?= $style ?>-sidebox-content <?= $htmlClass ?>">
        <?= $content ?>
    </div>
</div>
