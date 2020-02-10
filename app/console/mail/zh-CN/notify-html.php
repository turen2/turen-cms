<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Html;

$this->title = '亚桥租赁预约通知';
?>
<div class="new-notify">
    <p>有新预约，请查收：</p>
    <?php foreach ($params as $key => $param) { ?>
        <p><?= $key ?>：<?= $param ?></p>
    <?php } ?>
</div>
<p>赶紧回电话，回复越早越有机会！</p>