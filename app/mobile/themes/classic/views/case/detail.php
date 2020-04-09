<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use mobile\assets\Swiper3Asset;
use mobile\widgets\SideBoxListWidget;
use common\helpers\ImageHelper;
use common\helpers\Util;
use common\models\cms\Photo;
use common\tools\like\LikeWidget;
use common\tools\share\ShareWidget;
use yii\helpers\Url;

$this->currentModel = $model;
$this->topTitle = '案例详情';

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

<div class="public-box"></div>

<div class="casebook-detail">
    <div class="casebook-title">
        <h2><?= $model->title ?></h2>
        <div class="casebook-contact">
            <div class="casebook-box">
                <div class="casebook-name">
                    <dl>
                        <dd><?= $model->author ?></dd>
                        <dd><i></i></dd>
                        <dd>查看 <?= $model->base_hits + $model->hits ?></dd>
                    </dl>
                </div>
            </div>
            <a class="contact-btn" href="tel:<?= Yii::$app->params['config_hotline'] ?>">出租电话</a>
        </div>
        <div class="casebook-describe">
            <p><?= strip_tags(Util::ContentPasswh($model->content), '<div><p><img><h1><h2><h3><h4><h5><h6><span><a>') ?></p>
        </div>
    </div>
    <div class="casebook-inform">
        <dl>
            <dd><b>地址：</b><?= $model->diyfield_case_address ?></dd>
        </dl>
        <dl>
            <dd><b>日期：</b><?= Yii::$app->getFormatter()->asDate($model->posttime, 'php:Y年m月d日') ?></dd>
        </dl>
    </div>
</div>
<div class="des-detail-last">
    <div class="detail-type">
        <ul>
            <?php $imgs = $model->picList() ?>
            <?php if($imgs) { ?>
                <?php foreach ($imgs as $index => $img) { ?>
                    <li>
                        <div class="detail-tips">
                            <h5><?= $img['txt'] ?></h5>
                            <span></span>
                        </div>
                        <div class="detail-pho">
                            <img width="100%" alt="<?= $img['txt'] ?>" title="<?= $img['txt'] ?>" src="<?= empty($img['pic'])?ImageHelper::getNopic():Yii::$app->aliyunoss->getObjectUrl($img['pic'], true) ?>" />
                        </div>
                    </li>
                <?php } ?>
            <?php } ?>
        </ul>
    </div>
    <div class="guide-detail-box">
        <h4>
            <?= ShareWidget::widget([
                'title' => '分享到：',
                'images' => $model->picurl?[Yii::$app->aliyunoss->getObjectUrl($model->picurl, true)]:[]
            ]);
            ?>
            <?= LikeWidget::widget([
                'modelClass' => Photo::class,
                'modelId' => $model->id,
                'upName' => '赞',
                'downName' => false,
                'followName' => false,
                'route' => ['/case/like'],
            ]); ?>
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
                    <a title="<?= $prevModel->title ?>" href="<?= Url::to(['/case/detail', 'slug' => $prevModel->slug]) ?>"><?= $prevModel->title ?></a>
                <?php } else { ?>
                    <a title="没有了" href="javascript:;">没有了</a>
                <?php } ?>
            </dd>
            <dd>
                下一篇：
                <?php  if($nextModel) { ?>
                    <a title="<?= $nextModel->title ?>" href="<?= Url::to(['/case/detail', 'slug' => $nextModel->slug]) ?>"><?= $nextModel->title ?></a>
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
    'htmlClass' => 'case-photo-list',
    'moreLink' => Url::to(['/case/list']),

    'columnType' => 'photo',
    'flagName' => 	Yii::$app->params['config_face_cn_case_column_sidebox_flag'],
    'columnId' => $model->columnid,//当前的栏目
    'route' => ['/case/detail'],
]); ?>

<div class="myblack"></div>