<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use common\models\cms\Column;
use app\widgets\SideBoxListWidget;
use app\widgets\SideLabelListWidget;
use app\widgets\ContentMoreWidget;

$this->currentModel = $model;
$dlength = 90;
?>

<div class="baike-detail">
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
                'links' => Column::ModelBreadcrumbs($model, ['/baike/list'], false),
            ]) ?>
        </div>
        <div class="turen-box m2s clearfix">
            <div class="midcontent">
                <div class="detail-text">
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
                                <li><span>浏览数：</span><?= $model->hits ?></li>
                            </ul>
                            <a href="">
                                <span><img src="https://statics.zxzhijia.com/zxzj2017/new2018/images/star.png"/></span>
                                <b>收藏</b>
                            </a>
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
                    </div>
                    <div class="detail-main">
                        <dl>
                            <dt>
                                <div class="fenxiang">
                                    <div class="fenxiang_1">
                                        <div class="bdsharebuttonbox bdshare-button-style0-16" data-bd-bind="1547005450752">
                                            <a href="#" class="bds_more" data-cmd="more"></a>
                                            <a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a>
                                            <a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a>
                                            <a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a>
                                            <a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a>
                                            <a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a>
                                        </div>
                                    </div>
                                </div>
                            </dt>
                            <dd>
                                <a href="javascript:void(0)" id="dianzan"><span></span><b id="currdz">1</b></a>
                            </dd>
                        </dl>
                        <ul>
                            <li>
                                <?php  if($prevModel) { ?>
                                    <a href="<?= Url::to(['/baike/detail', 'slug' => $prevModel->slug]) ?>">
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
                                <?php  if($nextModel) { ?>
                                    <a href="<?= Url::to(['/baike/detail', 'slug' => $nextModel->slug]) ?>">
                                        <span class="ap8"></span>
                                        <b>上一篇：<?= $nextModel->title ?></b>
                                    </a>
                                <?php } else { ?>
                                    <a href="javascript:;">
                                        <span class="ap8"></span>
                                        <b>上一篇：没有了</b>
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
                        'flagName' => '还看',
                        'listNum' => 6,
                        'route' => ['/baike/detail'],
                    ]); ?>

                    <?= ContentMoreWidget::widget([
                        'title' => '相关阅读',
                        'htmlClass' => 'detail-add',
                        'columnType' => 'article',
                        'columnId' => $model->columnid,
                        'flagName' => '相关',
                        'listNum' => 6,
                        'route' => ['/baike/detail'],
                    ]); ?>
                </div>

            </div>
            <div class="sidebox">
                <?= SideBoxListWidget::widget([
                    'style' => 'gen',
                    'title' => '现场案例',
                    'htmlClass' => 'case-photo-list',
                    'moreLink' => Url::to(['/case/list']),

                    'columnType' => 'photo',
                    'flagName' => Yii::$app->params['config_face_banjia_cn_sidebox_current_photo_column_flag'],
                    'columnId' => 	76,//现场案例
                    'listNum' => 6,
                    'route' => ['/case/detail'],
                ]); ?>

                <?= SideLabelListWidget::widget([
                    'shortColumnClassName' => 'Photo',//栏目短类名
                    'htmlClass' => '',
                    'title' => '相关标签',
                    'listNum' => 10,//最多显示的个数
                    'route' => ['/tag/list', 'type' => 'photo'],
                ]); ?>
            </div>
        </div>
    </div>
</div>