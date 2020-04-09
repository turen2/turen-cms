<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
/* @var $this yii\web\View */

use mobile\widgets\SideBoxListWidget;
use yii\helpers\Url;
use common\helpers\Util;
use common\models\cms\Article;
use common\tools\like\LikeWidget;
use common\tools\share\ShareWidget;

$this->currentModel = $model;
$columnModel = $model->column;
$this->topTitle = $columnModel->cname; // 栏目标题

$css = <<<FOE
FOE;
$this->registerCss($css);

$js = <<<EOF
    // 
EOF;
$this->registerJs($js);

$webUrl = Yii::getAlias('@web/');
?>

<div class="guide-detail">
    <div class="guide-detail-title">
        <h2><?= $model->title ?></h2>
        <ul>
            <li>发布时间：<?= Yii::$app->getFormatter()->asDateTime($model->posttime, 'php:Y-m-d') ?></li>
            <li><span></span></li>
            <li>点击次数：<?= $model->base_hits + $model->hits ?></li>
        </ul>
    </div>
    <div class="guide-detail-text" id="infoContent">
        <?= strip_tags(Util::ContentPasswh($model->content), '<div><p><img><h1><h2><h3><h4><h5><h6><span><a>') ?>
    </div>
    <div class="guide-detail-box">
        <h4>
            <?= ShareWidget::widget([
                'title' => '分享到：',
                'images' => $model->picurl?[Yii::$app->aliyunoss->getObjectUrl($model->picurl, true)]:[]
            ]);
            ?>
            <?= LikeWidget::widget([
                'modelClass' => Article::class,
                'modelId' => $model->id,
                'upName' => '赞',
                'downName' => false,
                'followName' => false,
                'route' => ['/news/like'],
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
                <a title="<?= $prevModel->title ?>" href="<?= Url::to(['/news/detail', 'slug' => $prevModel->slug]) ?>"><?= $prevModel->title ?></a>
            <?php } else { ?>
                <a title="没有了" href="javascript:;">没有了</a>
            <?php } ?>
            </dd>
            <dd>
            下一篇：
            <?php  if($nextModel) { ?>
                <a title="<?= $nextModel->title ?>" href="<?= Url::to(['/news/detail', 'slug' => $nextModel->slug]) ?>"><?= $nextModel->title ?></a>
            <?php } else { ?>
                <a title="没有了" href="javascript:;">没有了</a>
            <?php } ?>
            </dd>
        </dl>
    </div>
</div>

<div class="myblack"></div>
<div class="price-banner">
    <a href="<?= Url::to(['/online/price']) ?>">
        <img src="<?= $webUrl ?>images/yaqiao/price-banner.png" />
    </a>
</div>

<?= SideBoxListWidget::widget([
    'title' => '相关推荐',
    'htmlClass' => 'news-article-list',
    'moreLink' => Url::to(['/news/list']),

    'columnType' => 'article',
    'flagName' => 	Yii::$app->params['config_face_cn_news_column_sidebox_flag'],
    'columnId' => $model->columnid,//当前的栏目
    'route' => ['/news/detail'],
]); ?>

<div class="myblack"></div>



