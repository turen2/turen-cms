<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Html;
?>
<div class="new-notify">
    <p>Please check the new order:</p>
    <?php foreach ($params as $key => $param) { ?>
    <p><?= $key ?>:<?= $param ?></p>
    <?php } ?>
</div>