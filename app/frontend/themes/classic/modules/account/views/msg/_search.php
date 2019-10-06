<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Url;
use common\models\account\Msg;

$type = $model->msg_type;
?>

<ul class="tabs">
    <li class="<?= empty($type)?'active':'' ?>">
        <a href="<?= Url::to(['/account/msg/list']) ?>">全部消息</a>
    </li>
    <?php foreach (Msg::TypeList() as $key => $value) { ?>
    <li class="<?= ($type == $key)?'active':'' ?>">
        <a href="<?= Url::to(['/account/msg/list', 'type' => $key]) ?>"><?= $value ?></a>
    </li>
    <?php } ?>
</ul>