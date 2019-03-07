<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

$this->title = $model->title;
$webUrl = Yii::getAlias('@web/');

$js = <<<EOF
$('.aboutnav li').on('click', function() {
    var i = $(this).index();
    $('.aboutnav li').removeClass('on').eq(i).addClass('on');
    $('.tabbox-content').hide().eq(i).show();
});
EOF;
$this->registerJs($js);

$part = Yii::$app->getRequest()->get('part', 'pa');//pa、pb、pc、pd
?>

<style>
    .tabbox .tabbox-content {
        display: none;
    }
    .aboutnav .<?= $part ?>, .tabbox .<?= $part ?> {
        display: block;
    }
</style>

<div class="about-us-banner"></div>
<div class="container">
    <div class="aboutnav">
        <ul>
            <li class="<?= $part == 'pa'?'on':'' ?>"><?= $model->title ?></li>
            <li class="<?= $part == 'pb'?'on':'' ?>">加入我们</li>
<!--            <li class="<?= $part == 'pc'?'on':'' ?>">加入我们</li>-->
<!--            <li class="<?= $part == 'pd'?'on':'' ?>">加入我们</li>-->
        </ul>
    </div>
    <div class="tabbox">
        <div class="pa tabbox-content about-infor">
            <?= $model->content ?>
        </div>
        <div class="pb tabbox-content add-ours">
            <div class="addtop">
                <p>公司长期招聘出色并富有战斗力的合作伙伴，真诚邀请您的加入！</p>
                <p>有兴趣请发邮件至 <a href="mailto:hr@jialebang100.com">hr@jialebang100.com</a>，并注明申请职位名称。我们这帮家伙有多靠谱，只有你进来才知道。</p>
            </div>
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
                <?php } ?>
            </div>
        </div>
    </div>
</div>