<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use app\assets\Swiper3Asset;
use app\widgets\SideBoxListWidget;
use common\helpers\ImageHelper;
use common\helpers\Util;
use common\tools\share\ShareWidget;
use yii\helpers\Url;

$model = $curModel;
$this->currentModel = $model;
$this->topTitle = '业务详情';

Swiper3Asset::register($this);

$css = <<<FOE
.guide-detail-box {
    padding: 0 0.5rem 0.3rem;
    margin-top: 0.5rem;
}
FOE;
$this->registerCss($css);

$js = <<<EOF2

EOF2;
$this->registerJs($js);

$webUrl = Yii::getAlias('@web/');
?>

<div class="case-banner">
    <a href="<?= Url::to(['/online/price']) ?>">
        <img width="100%" src="<?= empty($model->picurl)?ImageHelper::getNopic():Yii::$app->aliyunoss->getObjectUrl($model->picurl, true) ?>" />
    </a>
</div>

<div class="casebook-detail">
    <div class="casebook-title">
        <h2><?= $model->title ?></h2>
        <div class="casebook-contact">
            <div class="casebook-box">
                <div class="casebook-name">
                    <dl>
                        <dd><?= empty($model->author)?'admin':$model->author ?></dd>
                        <dd><i></i></dd>
                        <dd>查看 <?= $model->hits ?></dd>
                    </dl>
                </div>
            </div>
            <a class="contact-btn" href="tel:<?= Yii::$app->params['config_hotline'] ?>">出租电话</a>
        </div>
    </div>
</div>
<div class="des-detail-last">
    <div class="detail-type">
        <ul>
            <li>
                <div class="detail-tips">
                    <h5>业务范围</h5>
                    <span></span>
                </div>
                <div class="detail-pho">
                    <?= strip_tags(Util::ContentPasswh($model->diyfield_service_item), '<div><p><img><h1><h2><h3><h4><h5><h6><span><a>') ?>
                </div>
            </li>
            <li>
                <div class="detail-tips">
                    <h5>业务价格</h5>
                    <span></span>
                </div>
                <div class="detail-pho">
                    <?= strip_tags(Util::ContentPasswh($model->diyfield_service_price), '<div><p><img><h1><h2><h3><h4><h5><h6><span><a>') ?>
                </div>
            </li>
        </ul>
    </div>

    <div class="price-banner" style="margin-bottom: -.6rem;">
        <a href="<?= Url::to(['/online/price']) ?>">
            <img src="<?= $webUrl ?>images/yaqiao/price-banner.png" />
        </a>
    </div>

    <div class="guide-detail-box">
        <h4>
            <?= ShareWidget::widget([
                'title' => '分享到：',
                'images' => $model->picurl?[Yii::$app->aliyunoss->getObjectUrl($model->picurl, true)]:[]
            ]);
            ?>
        </h4>
        <div class="guide-detail-end">
            <span></span>
            <p>End</p>
            <span></span>
        </div>
        <dl>
            <dd>
                上一篇：
                <?php  if($prevModel) { ?>
                    <a title="<?= $prevModel->title ?>" href="<?= Url::to(['/service/detail', 'slug' => $prevModel->slug]) ?>"><?= $prevModel->title ?></a>
                <?php } else { ?>
                    <a title="没有了" href="javascript:;">没有了</a>
                <?php } ?>
            </dd>
            <dd>
                下一篇：
                <?php  if($nextModel) { ?>
                    <a title="<?= $nextModel->title ?>" href="<?= Url::to(['/service/detail', 'slug' => $nextModel->slug]) ?>"><?= $nextModel->title ?></a>
                <?php } else { ?>
                    <a title="没有了" href="javascript:;">没有了</a>
                <?php } ?>
            </dd>
        </dl>
    </div>
    <div class="myblack"></div>
</div>

<?= SideBoxListWidget::widget([
    'title' => '相关推荐',
    'htmlClass' => 'service-product-list',
    'moreLink' => Url::to(['/service/list']),

    'columnType' => 'product',
    'flagName' => 	Yii::$app->params['config_face_cn_sidebox_current_product_column_flag'],
    'columnId' => $model->columnid,//当前的栏目
    'route' => ['/service/detail'],
]); ?>

<div class="myblack"></div>