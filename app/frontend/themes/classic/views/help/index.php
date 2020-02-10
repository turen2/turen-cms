<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

$this->columnModel = $columnModel;
$webUrl = Yii::getAlias('@web/');

use app\widgets\SideBoxListWidget;
use common\tools\share\ShareWidget;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url; ?>

<div class="container">
    <div class="turen-box m2s clearfix">
        <div class="midcontent">
            <div class="help-box">
            <?php if($slug) { ?>
                <h4 class="htitle"><?= $currentModel->title ?></h4>
                <div class="hcontent">
                    <?= $currentModel->content ?>
                    <?= ShareWidget::widget([
                        'title' => '分享至：',
                        'images' => $currentModel->picurl?[Yii::$app->aliyunoss->getObjectUrl($currentModel->picurl, true)]:[]
                    ]);
                    ?>
                </div>
            <?php } else { ?>
                <ul class="hlist">
                <?php foreach ($models as $index => $model) { ?>
                    <li>
                        <h5>
                            <?php
                            $options = ['style' => ''];
                            if(!empty($model->colorval) || !empty($model->boldval)) {
                                Html::addCssStyle($options, ['color' => $model->colorval, 'font-weight' => $model->boldval]);
                            }
                            echo Html::a(StringHelper::truncate($model->title, 100), ['help/index', 'slug' => $model->slug], ['class' => 'textname', 'title' => $model->title, 'style' => $options['style']]);
                            ?>
                        </h5>
                        <p>
                            <?php
                            if(empty($model->description)) {
                                $des = $model->content;//去除图片链接
                            } else {
                                $des = $model->description;
                            }
                            echo StringHelper::truncate(strip_tags($des), 200);
                            ?>
                        </p>
                    </li>
                <?php } ?>
                </ul>
            <?php } ?>
            </div>
        </div>
        <div class="sidebox">
            <div class="tab-sidebox about-us card">
                <div class="tab-sidebox-title">
                    <h3><?= $columnModel->cname ?></h3>
                </div>
                <div class="tab-sidebox-content">
                    <div class="sidebox-block">
                        <ul class="help-side">
                            <?php foreach ($models as $index => $model) { ?>
                                <li><a href="<?= Url::to(['help/index', 'slug' => $model->slug]) ?>"><?= $model->title ?></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <?= SideBoxListWidget::widget([
                'style' => 'tab',
                'htmlClass' => 'about-us',
                'columnType' => 'block',
                'blockId' => Yii::$app->params['config_face_cn_sidebox_contact_us_block_id'],
            ]); ?>
        </div>
    </div>
</div>
