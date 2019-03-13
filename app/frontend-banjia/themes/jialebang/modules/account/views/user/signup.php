<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use app\assets\Swiper2Asset;
use common\models\user\User;
use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\LayerAsset;
use common\models\ext\Ad;

$this->title = '免费注册';
$this->params['breadcrumbs'][] = $this->title;

Swiper2Asset::register($this);
LayerAsset::register($this);
$js = <<<EOF
var loginSwiper = new Swiper('.login-ad-banner .swiper-container', {
    loop: true,//循环
    autoplay : 3200,//可选选项，自动滑动
    pagination: '.login-ad-banner .pagination',
    grabCursor: true,
    paginationClickable: true,
    autoplayDisableOnInteraction: false,//用户操作后，autoplay将禁止
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

//验证码操作
var layerIndex = null;
var verifyCodeBtn = $('.get-verify-code');
verifyCodeBtn.on('click', function() {
    layer.tips('只想提示地精准些', '.get-verify-code', {
        tips: 1,
        time: 4000,
        content: $('#verify-code-form-box').html(),
    });
});
EOF;
$this->registerJs($js);
?>

<div class="login-wrap signup container clearfix">
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
            <li class="tab-li"><a href="javascript:;">免费注册新用户</a></li>
            <li class="tab-li"><a href="javascript:;"></a></li>
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
            } elseif(isset($errors['rePassword'])) {
                $error = $errors['rePassword'];
            } elseif(isset($errors['verifyCode'])) {
                $error = $errors['verifyCode'];
            } elseif(isset($errors['agreeProtocol'])) {
                $error = $errors['agreeProtocol'];
            }
            if($errors) { ?>
                <div class="form-error"><i></i><label class="text"><?= $error ?></label></div>
            <?php } ?>
            <?php if(Yii::$app->params['config_login_mode'] == User::USER_PHONE_MODE) { ?>
                <dl class="editable clearfix">
                    <dt><?= $model->getAttributeLabel('phone') ?>：</dt>
                    <dd>
                        <?= Html::activeTextInput($model, 'phone', ['class' => 'input-text']) ?>
                        <span class="placeholder">请输入手机号</span>
                    </dd>
                </dl>
            <?php } elseif(Yii::$app->params['config_login_mode'] == User::USER_EMAIL_MODE) { ?>
                <dl class="editable clearfix">
                    <dt><?= $model->getAttributeLabel('email') ?>：</dt>
                    <dd>
                        <?= Html::activeTextInput($model, 'email', ['class' => 'input-text']) ?>
                        <span class="placeholder">请输入邮箱</span>
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
                <dt><?= $model->getAttributeLabel('rePassword') ?>：</dt>
                <dd>
                    <?= Html::activePasswordInput($model, 'rePassword', ['class' => 'input-text', 'autocomplete' => 'off']) ?>
                    <span class="placeholder">请输入确认密码</span>
                </dd>
            </dl>
            <dl class="editable top3 clearfix">
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
                <?= Html::activeCheckbox($model, 'agreeProtocol', ['label' => $model->getAttributeLabel('agreeProtocol').Html::a(' 用户协议', ['help/detail', 'slug' => 'user-protocol'], ['target' => '_blank'])]) ?>
            </p>
            <div class="btn-box">
                <?= Html::submitButton('注    册', ['class' => 'btn-settlement', 'style' => "cursor:pointer;"]) ?>
            </div>
            <div class="link-box">
                <?= Html::a('已有账号直接登录', ['user/login'], ['class' => 'sign-up']) ?>
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