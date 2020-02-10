<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use common\helpers\Util;
use yii\helpers\Url;

$this->topTitle = '人才招募';

$webUrl = Yii::getAlias('@web/');
?>

<div class="public-box"></div>

<div class="small-banner" style="padding-top: .26rem;">
    <a href="<?= Url::to(['/online/price']) ?>">
        <img src="<?= $webUrl ?>images/yaqiao/price-banner.png" />
    </a>
</div>

<div class="guide-jobs">
    <div class="jobs-wrap">
        <ul>
            <?php if($jobModels) { ?>
                <?php foreach ($jobModels as $key => $jobModel) { ?>
                    <li class="jobs-list" data-key="<?= $key ?>">
                        <a href="javascript:;">
                            <div class="jobs">
                                <h3 style=""><?= $jobModel->title ?> <?= $jobModel->employ ?>人</h3>
                            </div>
                            <div class="job-content">
                                <p>职位描述：</p>
                                <p><?= empty($jobModel->workdesc)?'无':(strip_tags(Util::ContentPasswh($jobModel->workdesc), '<div><p><img><h1><h2><h3><h4><h5><h6><span><a>')) ?></p>

                                <p>任职要求：</p>
                                <p><?= empty($jobModel->content)?'无':(strip_tags(Util::ContentPasswh($jobModel->content), '<div><p><img><h1><h2><h3><h4><h5><h6><span><a>')) ?></p>
                                <dl>
                                    <dd><img class="job-content-praise" src="<?= $webUrl ?>images/yaqiao/time2.png"><?= Yii::$app->getFormatter()->asDate($jobModel->posttime, 'Y年m月d日') ?></dd>
                                </dl>
                            </div>
                        </a>
                    </li>
                <?php } ?>
            <?php } ?>
        </ul>
        <div class="myblack"></div>
    </div>
</div>

