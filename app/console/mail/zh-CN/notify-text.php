<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
?>
有新预约，请查收：<?= PHP_EOL ?>
<?php foreach ($params as $key => $param) { ?>
    <?= $key ?>：<?= $param ?>
    <?= PHP_EOL ?>
<?php } ?>