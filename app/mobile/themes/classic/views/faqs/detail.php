<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use app\assets\Swiper3Asset;
use yii\helpers\Url;

$this->currentModel = $model;
$this->topTitle = '问答详情';

Swiper3Asset::register($this);

$css = <<<FOE
.public-box {
    border: none;
}
FOE;
$this->registerCss($css);

$js = <<<EOF2

EOF2;
$this->registerJs($js);

$webUrl = Yii::getAlias('@web/');
?>

<div class="public-box"></div>

<div class="question-detail">
    <div class="question-title">
        <h2><?= $model->title ?></h2>
        <div class="question-master">
            <dl>
                <dd>解答日期</dd>
                <dd><?= Yii::$app->getFormatter()->asDate($model->posttime, 'php:Y-m-d') ?></dd>
            </dl>
        </div>
    </div>
    <div class="reply-box">
        <ul>
            <li class="reply-list">
                <span class="reply-pic"><img src="<?= $webUrl ?>images/yaqiao/reply.png"></span>
                <div class="reply-main">
                    <p class="reply-text">
                        <?= strip_tags($model->diyfield_ask_content) ?>
                    </p>
                </div>
            </li>
        </ul>
    </div>
</div>

<div class="small-banner">
    <a href="<?= Url::to(['/online/price']) ?>">
        <img src="<?= $webUrl ?>images/yaqiao/price-banner.png" />
    </a>
</div>


<div class="related-recommend">
    <div class="question-top">
        <h2>相关推荐</h2>
    </div>
    <div class="related-box">
        <ul>
            <?php
            foreach ($faqModels as $faqModel) {
                $link = Url::to(['/faqs/detail', 'slug' => $model->slug]);
            ?>
                <li>
                    <a href="<?= $link ?>">
                        <div class="related-text" style="width: 100%;">
                            <h3><?= $faqModel->title ?></h3>
                            <p><?= strip_tags($faqModel->diyfield_ask_content) ?></p>
                            <dl>
                                <dd><?= Yii::$app->getFormatter()->asDateTime($faqModel->posttime, 'php:Y-m-d') ?></dd>
                            </dl>
                        </div>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>
<div class="myblack"></div>



