<?php
/* @var $this yii\web\View */

$this->title = '常见问答';
$links = [];
$links[] = ['label' => '<li class="active"><span>&gt;</span></li>'];
$links[] = ['label' => $this->title];

use app\widgets\SideBoxListWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Breadcrumbs; ?>

<div class="faqs-index">
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
                'links' => $links,
            ]) ?>
        </div>

        <div class="turen-box">
            <div class="turen-box m2s clearfix">
                <div class="midcontent">
                    <div class="detail-text">
                        <div class="detail-title">
                            <h3>常见问答</h3>
                            <p class="">嘉乐邦，一站式搬家服务。</p>
                        </div>
                        <div class="detail-content ask-info">
                            <div class="ask-form">
                                <?php $form = ActiveForm::begin(); ?>
                                    <?= $model->getAttributeLabel('question')?>
                                    <?= Html::activeInput('text', $model, 'question') ?>
                                    <?= $model->getAttributeLabel('nickname')?>
                                    <?= Html::activeInput('text', $model, 'nickname') ?>
                                    <?= $model->getAttributeLabel('phone')?>
                                    <?= Html::activeInput('text', $model, 'phone') ?>
                                    <?= $model->getAttributeLabel('phoneCode')?>
                                    <?= Html::activeInput('text', $model, 'phoneCode') ?>
                                    <?= $model->getAttributeLabel('verifyCode')?>
                                    <?= Html::activeInput('text', $model, 'verifyCode') ?>
                                    <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
                                <?php ActiveForm::end(); ?>
                            </div>
                            <ul class="info-top">
                                <li class="fl"><a class="active" href="">全部问答</a></li>
                                <li class="fl"><a href="">搬家必答</a></li>
                                <li class="fl"><a href="">最新问答</a></li>
                            </ul>
                            <div class="info-body">
                                <ul>
                                    <li class="first">
                                        <h5 class="info-title" target="_blank">卧室梳妆台可以对着床摆放？有哪些风水讲究</h5>
                                        <span class="post-time"><i class="fa fa-clock-o"></i> 2018-12-11 11:13:02</span>
                                        <p class="info-content">在卧室中，除了床之外，梳妆台也是非常重要的家具，不仅可以帮助收纳化妆等用品，而且还可以起到一定的装饰效果，因此，备受人们的喜爱。不过，卧室梳妆台的摆放也是很有讲究的，从风水上来说，卧室梳妆台不宜正对着床摆放，这样半夜醒来时容易被镜子中的自己吓到，导致精神过于紧张，不利于提高居住者的睡眠质量。另外，如果梳妆台正对着床摆放的话，那么，还容易影响家中的财运，所以，大家在摆放卧室梳妆台时，一定要注意风水上的讲究。</p>
                                        <span class="ask-label">
                                            <i class="fa fa-tags"></i>
                                            <a href="javascript:;">搬家必答</a>
                                            <a href="javascript:;">最新问答</a>
                                        </span>
                                    </li>
                                    <li>
                                        <h5 class="info-title" target="_blank">卧室梳妆台可以对着床摆放？有哪些风水讲究</h5>
                                        <span class="post-time"><i class="fa fa-clock-o"></i> 2018-12-11 11:13:02</span>
                                        <p class="info-content more">
                                            在卧室中，除了床之外，梳妆台也是非常重要的家具，不仅可以帮助收纳化妆等用品，而且还可以起到一定的装饰效果，因此，备受人们的喜爱。不过，卧室梳妆台的摆放也是很有讲究的，从风水上来说，卧室梳妆台不宜正对着床摆放，这样半夜醒来时容易被镜子中的自己吓到，导致精神过于紧张，不利于提高居住者的睡眠质量。另外，如果梳妆台正对着床摆放的话，那么，还容易影响家中的财运，所以，大家在摆放卧室梳妆台时，一定要注意风水上的讲究。
                                            <a class="more-btn" href="javascript:;">更多</a>
                                        </p>
                                        <span class="ask-label"></span>
                                    </li>
                                    <li>
                                        <h5 class="info-title" target="_blank">卧室梳妆台可以对着床摆放？有哪些风水讲究</h5>
                                        <span class="post-time"><i class="fa fa-clock-o"></i> 2018-12-11 11:13:02</span>
                                        <p class="info-content">在卧室中，除了床之外，梳妆台也是非常重要的家具，不仅可以帮助收纳化妆等用品，而且还可以起到一定的装饰效果，因此，备受人们的喜爱。不过，卧室梳妆台的摆放也是很有讲究的，从风水上来说，卧室梳妆台不宜正对着床摆放，这样半夜醒来时容易被镜子中的自己吓到，导致精神过于紧张，不利于提高居住者的睡眠质量。另外，如果梳妆台正对着床摆放的话，那么，还容易影响家中的财运，所以，大家在摆放卧室梳妆台时，一定要注意风水上的讲究。</p>
                                        <span class="ask-label"></span>
                                    </li>
                                    <li>
                                        <h5 class="info-title" target="_blank">卧室梳妆台可以对着床摆放？有哪些风水讲究</h5>
                                        <span class="post-time"><i class="fa fa-clock-o"></i> 2018-12-11 11:13:02</span>
                                        <p class="info-content">在卧室中，除了床之外，梳妆台也是非常重要的家具，不仅可以帮助收纳化妆等用品，而且还可以起到一定的装饰效果，因此，备受人们的喜爱。不过，卧室梳妆台的摆放也是很有讲究的，从风水上来说，卧室梳妆台不宜正对着床摆放，这样半夜醒来时容易被镜子中的自己吓到，导致精神过于紧张，不利于提高居住者的睡眠质量。另外，如果梳妆台正对着床摆放的话，那么，还容易影响家中的财运，所以，大家在摆放卧室梳妆台时，一定要注意风水上的讲究。</p>
                                        <span class="ask-label"></span>
                                    </li>
                                    <li>
                                        <h5 class="info-title" target="_blank">卧室梳妆台可以对着床摆放？有哪些风水讲究</h5>
                                        <span class="post-time"><i class="fa fa-clock-o"></i> 2018-12-11 11:13:02</span>
                                        <p class="info-content">在卧室中，除了床之外，梳妆台也是非常重要的家具，不仅可以帮助收纳化妆等用品，而且还可以起到一定的装饰效果，因此，备受人们的喜爱。不过，卧室梳妆台的摆放也是很有讲究的，从风水上来说，卧室梳妆台不宜正对着床摆放，这样半夜醒来时容易被镜子中的自己吓到，导致精神过于紧张，不利于提高居住者的睡眠质量。另外，如果梳妆台正对着床摆放的话，那么，还容易影响家中的财运，所以，大家在摆放卧室梳妆台时，一定要注意风水上的讲究。</p>
                                        <span class="ask-label"></span>
                                    </li>
                                    <li>
                                        <h5 class="info-title" target="_blank">卧室梳妆台可以对着床摆放？有哪些风水讲究</h5>
                                        <span class="post-time"><i class="fa fa-clock-o"></i> 2018-12-11 11:13:02</span>
                                        <p class="info-content">在卧室中，除了床之外，梳妆台也是非常重要的家具，不仅可以帮助收纳化妆等用品，而且还可以起到一定的装饰效果，因此，备受人们的喜爱。不过，卧室梳妆台的摆放也是很有讲究的，从风水上来说，卧室梳妆台不宜正对着床摆放，这样半夜醒来时容易被镜子中的自己吓到，导致精神过于紧张，不利于提高居住者的睡眠质量。另外，如果梳妆台正对着床摆放的话，那么，还容易影响家中的财运，所以，大家在摆放卧室梳妆台时，一定要注意风水上的讲究。</p>
                                        <span class="ask-label"></span>
                                    </li>
                                    <li>
                                        <h5 class="info-title" target="_blank">卧室梳妆台可以对着床摆放？有哪些风水讲究</h5>
                                        <span class="post-time"><i class="fa fa-clock-o"></i> 2018-12-11 11:13:02</span>
                                        <p class="info-content">在卧室中，除了床之外，梳妆台也是非常重要的家具，不仅可以帮助收纳化妆等用品，而且还可以起到一定的装饰效果，因此，备受人们的喜爱。不过，卧室梳妆台的摆放也是很有讲究的，从风水上来说，卧室梳妆台不宜正对着床摆放，这样半夜醒来时容易被镜子中的自己吓到，导致精神过于紧张，不利于提高居住者的睡眠质量。另外，如果梳妆台正对着床摆放的话，那么，还容易影响家中的财运，所以，大家在摆放卧室梳妆台时，一定要注意风水上的讲究。</p>
                                        <span class="ask-label"></span>
                                    </li>
                                    <li>
                                        <h5 class="info-title" target="_blank">卧室梳妆台可以对着床摆放？有哪些风水讲究</h5>
                                        <span class="post-time"><i class="fa fa-clock-o"></i> 2018-12-11 11:13:02</span>
                                        <p class="info-content">在卧室中，除了床之外，梳妆台也是非常重要的家具，不仅可以帮助收纳化妆等用品，而且还可以起到一定的装饰效果，因此，备受人们的喜爱。不过，卧室梳妆台的摆放也是很有讲究的，从风水上来说，卧室梳妆台不宜正对着床摆放，这样半夜醒来时容易被镜子中的自己吓到，导致精神过于紧张，不利于提高居住者的睡眠质量。另外，如果梳妆台正对着床摆放的话，那么，还容易影响家中的财运，所以，大家在摆放卧室梳妆台时，一定要注意风水上的讲究。</p>
                                        <span class="ask-label"></span>
                                    </li>
                                </ul>
                                <a class="ask-more" href="javascript;">点击加载更多</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sidebox">
                    <div class="tab-sidebox">
                        <div class="tab-sidebox-title">
                            <h3>搬家费用测算</h3>
                        </div>
                        <div class="tab-sidebox-content">
                            <div class="sidebox-block test-price">
                                <p>//http://www.365azw.com/share/jiancai</p>
                                <p>测试</p>
                                <p>测试</p>
                                <p>测试</p>
                            </div>
                        </div>
                    </div>
                    <?= SideBoxListWidget::widget([
                        'style' => 'tab',
                        'htmlClass' => 'about-us',
                        'columnType' => 'block',
                        'blockId' => Yii::$app->params['config_face_banjia_cn_sidebox_contact_us_block_id'],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>


