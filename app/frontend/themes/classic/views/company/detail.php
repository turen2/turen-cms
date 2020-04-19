<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
/* @var $this yii\web\View */

use common\models\cms\Article;
use common\tools\like\LikeWidget;
use common\tools\share\ShareWidget;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use common\models\cms\Column;
use frontend\widgets\SideBoxListWidget;
use frontend\widgets\SideLabelListWidget;
use frontend\widgets\ContentMoreWidget;

$this->currentModel = $model;
$dlength = 90;
?>

<div class="company-detail">
    <div class="container">
        <div class="breadcrumb-box clearfix">
            <span class="location"><b>当前位置：</b></span>
            <?= Breadcrumbs::widget([
                'encodeLabels' => false,
                'options' => ['class' => 'pagination clearfix'],
                'tag' => 'ul',
                'homeLink' => null,
                'itemTemplate' => "<li>{link}</li>\n",
                //'activeItemTemplate' => "<li class=\"active\">{link}</li>\n",
                'links' => Column::ModelBreadcrumbs($model, ['/company/list'], false, 2),
            ]) ?>
        </div>
        <div class="turen-box m2s clearfix">
            <div class="midcontent">
                <div class="detail-text card">
                    <div class="detail-title">
                        <?php
                        $options = ['style' => ''];
                        if(!empty($model->colorval) || !empty($model->boldval)) {
                            Html::addCssStyle($options, ['color' => $model->colorval, 'font-weight' => $model->boldval]);
                        }
                        echo Html::tag('h3', $model->title, ['style' => $options['style']]);
                        ?>
                        <div class="detail-date">
                            <ul>
                                <li><span>日期：</span><?= Yii::$app->getFormatter()->asDateTime($model->posttime, 'php:Y年m月d日') ?></li>
                                <li><span>发布人：</span><?= $model->author ?></li>
                                <li><span>浏览数：</span><?= $model->base_hits + $model->hits ?></li>
                            </ul>
                            <?= LikeWidget::widget([
                                'modelClass' => Article::class,
                                'modelId' => $model->id,
                                'upName' => '赞',
                                'downName' => '踩',
                                'followName' => false,
                                'route' => ['/company/like'],
                            ]); ?>
                        </div>
                    </div>
                    <div class="detail-digest">
                        <div class="detail-digest-line">
                            <p>
                                <?php
                                if(empty($model->description)) {
                                    $des = $model->content;//去除图片链接
                                } else {
                                    $des = $model->description;
                                }
                                echo StringHelper::truncate(strip_tags($des), $dlength);
                                ?>
                            </p>
                            <span>摘要<i></i></span>
                        </div>
                    </div>
                    <div class="detail-content">
                        <?= $model->content; ?>
                        <?= ShareWidget::widget([
                            'title' => '分享至：',
                            'images' => $model->picurl?[Yii::$app->aliyunoss->getObjectUrl($model->picurl, true)]:[]
                        ]);
                        ?>
                    </div>
                    <div class="detail-main">
                        <ul>
                            <li>
                                <?php  if($prevModel) { ?>
                                    <a href="<?= Url::to(['/company/detail', 'slug' => $prevModel->slug]) ?>">
                                        <span class="ap8"></span>
                                        <b>上一篇：<?= $prevModel->title ?></b>
                                    </a>
                                <?php } else { ?>
                                    <a href="javascript:;">
                                        <span class="ap8"></span>
                                        <b>上一篇：没有了</b>
                                    </a>
                                <?php } ?>
                            </li>
                            <li style="float: right;">
                                <?php if($nextModel) { ?>
                                    <a href="<?= Url::to(['/company/detail', 'slug' => $nextModel->slug]) ?>">
                                        <span class="ap9"></span>
                                        <b>下一篇：<?= $nextModel->title ?></b>
                                    </a>
                                <?php } else { ?>
                                    <a href="javascript:;">
                                        <span class="ap9"></span>
                                        <b>下一篇：没有了</b>
                                    </a>
                                <?php } ?>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="detail-more">
                    <?= ContentMoreWidget::widget([
                        'title' => '看过本文还看过',
                        'htmlClass' => '',
                        'columnType' => 'article',
                        'columnId' => $model->columnid,
                        'flagName' => Yii::$app->params['config_face_cn_company_column_seemore_flag'],
                        'listNum' => 6,
                        'route' => ['/company/detail'],
                    ]); ?>

                    <?= ContentMoreWidget::widget([
                        'title' => '相关阅读',
                        'htmlClass' => 'detail-add',
                        'columnType' => 'article',
                        'columnId' => $model->columnid,
                        'flagName' => Yii::$app->params['config_face_cn_company_column_related_flag'],
                        'listNum' => 6,
                        'route' => ['/company/detail'],
                    ]); ?>
                </div>

            </div>
            <div class="sidebox">
                <?= $this->render('/common/_sidebox_share', ['title' => '好文分享', 'images' => [Yii::$app->aliyunoss->getObjectUrl($model->picurl, true)]]) ?>

                <?= SideBoxListWidget::widget([
                    'style' => 'gen',
                    'title' => '相关推荐',
                    'htmlClass' => 'company-article-list',
                    'moreLink' => Url::to(['/company/list']),

                    'columnType' => 'article',
                    'flagName' => Yii::$app->params['config_face_cn_comopany_column_sidebox_flag'],
                    'columnId' => $model->columnid,//现场案例
                    'listNum' => 6,
                    'route' => ['/company/detail'],
                ]); ?>

                <?= SideLabelListWidget::widget([
                    'shortColumnClassName' => 'Article',//栏目短类名
                    'htmlClass' => 'company-article-label',
                    'title' => '相关标签',
                    'listNum' => 10,//最多显示的个数
                    'route' => ['/tag/list', 'type' => 'article'],
                ]); ?>
            </div>
        </div>
    </div>
</div>