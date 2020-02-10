<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

$webUrl = Yii::getAlias('@web/');

use common\tools\share\ShareWidget; ?>
<div class="about-us-banner"></div>
<div class="about-us-content container card">
    <?= $this->render('_tab', ['slug' => '']) ?>
    <div class="tabbox">
        <div class="pb tabbox-content add-ours">
            <div class="position">
                <?php if($jobModels) { ?>
                    <?php foreach ($jobModels as $jobModel) { ?>
                    <div>
                        <div class="infors">
                            <div class="infortitle"><?= $jobModel->title ?> <?= $jobModel->employ ?>人</div>
                            <div class="infortext">
                                <div class="texts">职位描述：</div>
                                <?= empty($jobModel->workdesc)?'无':$jobModel->workdesc ?>
                            </div>
                            <div class="infortext">
                                <div class="texts">任职要求：</div>
                                <?= empty($jobModel->content)?'无':$jobModel->content ?>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <?= ShareWidget::widget([
                        'title' => '分享至：',
                    ]);
                    ?>
                <?php } ?>
            </div>
        </div>
    </div>
</div>