<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

$this->currentModel = $model;
$webUrl = Yii::getAlias('@web/');

use common\tools\share\ShareWidget;
?>

<div class="info-bg">
    <div class="about-us-banner"></div>
    <div class="about-us-content container card">
        <?= $this->render('_tab', ['slug' => $model->slug]) ?>
        <div class="tabbox">
            <div class="pa tabbox-content about-infor">
                <?= $model->content ?>
                <?= ShareWidget::widget([
                    'title' => '分享至：',
                    'images' => $model->picurl?[Yii::$app->aliyunoss->getObjectUrl($model->picurl, true)]:[]
                ]);
                ?>
            </div>
        </div>
    </div>
</div>