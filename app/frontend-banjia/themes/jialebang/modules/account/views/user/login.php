<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use app\assets\Swiper2Asset;
use common\models\ext\Ad;
use common\models\user\User;
use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = '客户登录';
$this->params['breadcrumbs'][] = $this->title;

Swiper2Asset::register($this);
$js = <<<EOF
var loginSwiper = new Swiper('.login-ad-banner .swiper-container', {
    loop: true,//循环
    autoplay : 3200,//可选选项，自动滑动
    pagination: '.login-ad-banner .pagination',
    grabCursor: true,
    paginationClickable: true,
    autoplayDisableOnInteraction: false,//客户操作后，autoplay将禁止
});
$('.login-ad-banner .arrow-right').on('click', function(e){
    e.preventDefault()
    loginSwiper.swipePrev()
});
$('.login-ad-banner .arrow-left').on('click', function(e){
    e.preventDefault()
    loginSwiper.swipeNext()
});

//placeholder效果
$('.editable .input-text').each(function(i){
    if($(this).val() == '') {
        $(this).next('.placeholder').show();
    }
}).on('focus', function() {
    $(this).next('.placeholder').hide();
}).on('blur', function() {
    if($(this).val() == '') {
        $(this).next('.placeholder').show();
    }
});
EOF;
$this->registerJs($js);
?>

<div class="login-wrap container clearfix">
    <div class="ad-box">
        <div class="login-ad-banner">
            <a class="arrow arrow-left" href="#"><span></span></a>
            <a class="arrow arrow-right" href="#"><span></span></a>
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <?php $loginMainAds = Ad::AdListByAdTypeId(Yii::$app->params['config_face_banjia_cn_login_signup_ad_type_id']); ?>
                    <?php if($loginMainAds) { ?>
                        <?php foreach ($loginMainAds as $index => $loginMainAd) { ?>
                            <div class="swiper-slide">
                                <a href="<?= $loginMainAd['linkurl'] ?>" target="_blank">
                                    <img title="<?= $loginMainAd['title'] ?>" src="<?= empty($loginMainAd['picurl'])?ImageHelper::getNopic():Yii::$app->aliyunoss->getObjectUrl($loginMainAd['picurl'], true) ?>" />
                                </a>
                            </div>
                        <?php } ?>
                    <?php } else { ?>
                        未设置登录/注册广告图
                    <?php } ?>
                </div>
            </div>
            <div class="pagination"></div>
        </div>
    </div>

    <div class="form-box">
        <ul class="form-tab clearfix">
            <li class="tab-li on"><a href="javascript:;">账号登录</a></li>
            <li class="tab-li"><a href="javascript:;">手机快捷登录</a></li>
        </ul>
        <div class="form-content">
            <?php $form = ActiveForm::begin(['enableAjaxValidation' => false, 'id' => 'loginForm', 'options' => ['class' => 'login-form']]); ?>
                <?php
                $errors = $model->getFirstErrors();
                $error = '';
                if(isset($errors['email'])) {
                    $error = $errors['email'];
                } elseif(isset($errors['phone'])) {
                    $error = $errors['phone'];
                } elseif(isset($errors['password'])) {
                    $error = $errors['password'];
                } elseif(isset($errors['verifyCode'])) {
                    $error = $errors['verifyCode'];
                }
                if($errors) { ?>
                    <div class="form-error"><i></i><label class="text"><?= $error ?></label></div>
                <?php } ?>
                <?php if(Yii::$app->params['config_login_mode'] == User::USER_PHONE_MODE) { ?>
                    <dl class="editable clearfix">
                        <dt><?= $model->getAttributeLabel('phone') ?>：</dt>
                        <dd>
                            <?= Html::activeTextInput($model, 'phone', ['class' => 'input-text']) ?>
                            <span class="placeholder">请输入客户名/手机号</span>
                        </dd>
                    </dl>
                <?php } elseif(Yii::$app->params['config_login_mode'] == User::USER_EMAIL_MODE) { ?>
                    <dl class="editable clearfix">
                        <dt><?= $model->getAttributeLabel('email') ?>：</dt>
                        <dd>
                            <?= Html::activeTextInput($model, 'email', ['class' => 'input-text']) ?>
                            <span class="placeholder">请输入客户名/邮箱</span>
                        </dd>
                    </dl>
                <?php } ?>
                <dl class="editable top1 clearfix">
                    <dt><?= $model->getAttributeLabel('password') ?>：</dt>
                    <dd>
                        <?= Html::activePasswordInput($model, 'password', ['class' => 'input-text', 'autocomplete' => 'off']) ?>
                        <span class="placeholder">请输入密码</span>
                    </dd>
                </dl>
                <dl class="editable top2 clearfix">
                    <dt><?= $model->getAttributeLabel('verifyCode') ?>：</dt>
                    <dd>
                        <?= Html::activeTextInput($model, 'verifyCode', ['class' => 'input-text', 'autocomplete' => 'off']) ?>
                        <span class="placeholder">请输入验证码</span>
                        <?= Captcha::widget([
                                'model' => $model,
                                'attribute' => 'verifyCode',
                                'captchaAction' => '/account/user/captcha',
                                'template' => '{image}',
                                'options' => ['class' => 'form-control', 'placeholder' => $model->getAttributeLabel('verifyCode')],
                                'imageOptions' => ['title' => '点击刷新', 'alt' => '验证码', 'style' => 'cursor: pointer;'],
                        ]) ?>
                    </dd>
                </dl>
                <p class="rem-check">
                    <?= Html::activeCheckbox($model, 'rememberMe') ?>
                </p>
                <div class="btn-box">
                    <?= Html::submitButton('登    录', ['class' => 'btn-settlement', 'style' => "cursor:pointer;"]) ?>
                </div>
                <div class="link-box">
                    <?= Html::a('新客户注册', ['user/signup'], ['class' => 'sign-up']) ?>
                    <?= Html::a('忘记密码？', ['user/forget'], ['class' => 'forget-pass', 'target' => '_blank']) ?>
                </div>
            <?php ActiveForm::end(); ?>

            <div class="login-short">
                <h3>使用合作账号登录：</h3>
                <ul class="clearfix">
                    <li class="qq"><a href=""></a></li>
                    <li class="sina"><a href=""></a></li>
                    <li class="weixin"><a href=""></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>