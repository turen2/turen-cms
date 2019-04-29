<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Json;
use common\models\account\Msg;
?>
<table class="table table-striped">
    <tbody>
    <tr>
        <td width="25%">消息类型</td>
        <td class="tpl-typename" width="75%"><?= Msg::TypeName($model->msg_type) ?></td>
    </tr>
    <?php $content = Json::decode($model->msg_content) ?>
    <?php if($model->msg_type == Msg::MSG_TYPE_FEEDBACK) { ?>
    <tr>
        <td width="25%">反馈问题</td>
        <td class="tpl-question" width="75%"><?= $content['question'] ?></td>
    </tr>
    <tr>
        <td width="25%">官方回复</td>
        <td class="tpl-answer" width="75%"><?= $content['answer'] ?></td>
    </tr>
    <?php } else { ?>
    <tr>
        <td width="25%">消息详情</td>
        <td class="tpl-content" width="75%"><?= $content['content'] ?></td>
    </tr>
    <?php } ?>
    <tr>
        <td width="25%">发布时间</td>
        <td class="tpl-date" width="75%"><?= Yii::$app->getFormatter()->asDate($model->created_at) ?></td>
    </tr>
    </tbody>
</table>