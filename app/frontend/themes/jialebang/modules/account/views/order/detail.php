<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Json;
?>
<table class="table table-striped">
    <tbody>
        <tr>
            <td width="25%">服务单号</td>
            <td width="75%"><?= $model->ui_service_num ?></td>
        </tr>
        <tr>
            <td width="25%">服务项目</td>
            <td width="75%"><?= $model->ui_title ?></td>
        </tr>
        <tr>
            <td width="25%">内容详情</td>
            <td width="75%">
                <?php
                if(!empty($model->ui_content)) {
                    $lines = [];
                    foreach (Json::decode($model->ui_content) as $key => $item) {
                        $lines[] = $key.'：'.$item;
                    }
                    echo implode('，', $lines);
                } else {
                    echo '没有内容';
                }
                ?>
            </td>
        </tr>
        <tr>
            <td width="25%">发布位置</td>
            <td width="75%"><?= $model->ui_ipaddress ?></td>
        </tr>
        <tr>
            <td width="25%">创建时间</td>
            <td width="75%"><?= Yii::$app->getFormatter()->asDatetime($model->ui_submit_time) ?></td>
        </tr>
        <tr>
            <td width="25%">服务状态</td>
            <td width="75%"><?= $model->getStateName() ?></td>
        </tr>
        <tr>
            <td width="25%">客服回复</td>
            <td width="75%"><?= $model->ui_answer ?></td>
        </tr>
    </tbody>
</table>
