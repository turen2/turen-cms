<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use app\widgets\SideBoxListWidget;
use app\widgets\SideLabelListWidget;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use common\models\cms\Column;
?>
<div class="page-info">
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
                'links' => Column::ModelBreadcrumbs($model, ['/banjia/page/info'], false),
            ]) ?>
        </div>
        <div class="turen-box m2s clearfix">
            <div class="midcontent">
                <div class="detail-text">
                    <div class="detail-title">
                        <?= Html::tag('h3', $model->title) ?>
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
                    </div>
                </div>
            </div>

            <div class="sidebox">
                <?= SideBoxListWidget::widget([
                    'style' => 'tab',
                    'htmlClass' => 'about-us',
                    'columnType' => 'block',
                    'blockId' => Yii::$app->params['config_face_banjia_cn_sidebox_contact_us_block_id'],
                ]); ?>

                <?= SideLabelListWidget::widget([
                    'shortColumnClassName' => 'Article',//栏目短类名
                    'htmlClass' => 'label-sidebox',
                    'title' => '相关标签',
                    'listNum' => 10,//最多显示的个数
                    'route' => ['/banjia/tag/list', 'type' => 'article'],
                ]); ?>
            </div>
        </div>
    </div>
</div>
