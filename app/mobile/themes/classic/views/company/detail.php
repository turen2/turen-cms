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
use common\models\cms\Column;
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
    'htmlClass' => 'company-article-list',
    'moreLink' => Url::to(['/company/list']),

    'columnType' => 'article',
    'flagName' => 	Yii::$app->params['config_face_cn_comopany_column_sidebox_flag'],
    'columnId' => $model->columnid,//当前的栏目
    'route' => ['/company/detail'],
]); ?>


<div class="related-recommend">
    <div class="question-top">
        <h2>相关推荐</h2>
    </div>
    <div class="related-box">
        <ul>
            <li>
                <a href="#">
                    <div class="related-pic">
                        <img src="<?= $webUrl ?>images/yaqiao/5d6cbeabafacf.jpg" style="height: 1.29rem;">
                    </div>
                    <div class="related-text">
                        <h3>住宅精装修设计技巧 购买精装修房有什...</h3>
                        <p>住宅进行装修时，精装修大家比较喜欢，...</p>
                        <dl>
                            <dd>2019-12-01</dd>
                        </dl>
                    </div>
                </a>
            </li>
            <li>
                <a href="#">
                    <div class="related-pic">
                        <img src="<?= $webUrl ?>images/yaqiao/5d6dd1463fed1.jpg" style="height: 1.29rem;">
                    </div>
                    <div class="related-text">
                        <h3>集成墙面真的有那么好吗 集成墙面品牌...</h3>
                        <p>集成墙面作为现在最为流行最为环保的一...</p>
                        <dl>
                            <dd>2019-12-01</dd>
                        </dl>
                    </div>
                </a>
            </li>
            <li>
                <a href="#">
                    <div class="related-pic">
                        <img src="<?= $webUrl ?>images/yaqiao/5dad0812f36b0.jpg" style="height: 1.29rem;">
                    </div>
                    <div class="related-text">
                        <h3>
                            众多装修风格中韩式家装通过简洁明快有品位体现在业主眼前，因此得到业主装修首肯，进行设计韩式家装有不少讲究，需要明确韩式装修设计手法，以及设计所运用色彩，下面大家通过文章来详细了解下，韩式家装怎么设计?
                        </h3>
                        <p>众多装修风格中韩式家装通过简洁明快有...</p>
                        <dl>
                            <dd>2019-12-01</dd>
                        </dl>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</div>
<div class="myblack"></div>





