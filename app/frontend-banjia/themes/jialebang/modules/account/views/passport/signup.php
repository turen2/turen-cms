<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use app\assets\ValidationAsset;
use yii\authclient\widgets\AuthChoice;
use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = '免费注册';
$this->params['breadcrumbs'][] = $this->title;

ValidationAsset::register($this);
$js = <<<EOF
//placeholder效果
$('.editable .input-text').each(function(i){
    if($(this).val() != '') {
        $(this).next('.placeholder').hide();
    }
}).on('focus', function() {
    $(this).next('.placeholder').hide();
}).on('blur', function() {
    if($(this).val() == '') {
        $(this).next('.placeholder').show();
    }
});

//验证码操作
//var layerIndex = null;
//var verifyCodeBtn = $('.get-verify-code');
//verifyCodeBtn.on('click', function() {
//    layer.tips('只想提示地精准些', '.get-verify-code', {
//        tips: 1,
//        time: 4000,
//        content: $('#verify-code-form-box').html(),
//    });
//});

//验证提示效果
var validator = $('#signupForm').validate({
	rules: {
        "SignupForm[phone]": {
            "required": true,
            "isPhone": true
        },
        "SignupForm[password]": {
            "required": true,
            "minlength": 6
        },
        "SignupForm[rePassword]": {
            "required": true,
            "minlength": 6,
            "equalTo": "#signupform-password"
        },
        "SignupForm[verifyCode]": {
            "required": true
        }
    },
	messages: {
	    "SignupForm[phone]": {
            "required": '<i class="iconfont jia-close_b"></i>用户名/手机号码必填',
            "isPhone": '<i class="iconfont jia-close_b"></i>手机号码格式错误'
        },
        "SignupForm[password]": {
            "required": '<i class="iconfont jia-close_b"></i>密码必填',
            "minlength": '<i class="iconfont jia-close_b"></i>密码不能小于6位'
        },
        "SignupForm[rePassword]": {
            "required": '<i class="iconfont jia-close_b"></i>密码必填',
            "minlength": '<i class="iconfont jia-close_b"></i>密码不能小于6位',
            "equalTo": '<i class="iconfont jia-close_b"></i>两次输入的密码不一致'
        },
        "SignupForm[verifyCode]": {
            "required": '<i class="iconfont jia-close_b"></i>验证码必填'
        }
    },
    errorElement: 'p',
	errorPlacement: function(error, element) {
		error.appendTo(element.parent());
	},
	submitHandler: function(form) {
        //form.submit();
        return true;
    }
});
EOF;
$this->registerJs($js);
?>

<div class="login-wrap signup container clearfix">
    <div class="ad-box">
        <?= $this->render('_user-banner') ?>
    </div>

    <div class="form-box">
        <ul class="form-tab clearfix">
            <li class="tab-li"><a href="javascript:;">免费注册新用户</a></li>
            <li class="tab-li"><a href="javascript:;"></a></li>
        </ul>
        <div class="form-content">
            <?php $form = ActiveForm::begin(['enableAjaxValidation' => false, 'id' => 'signupForm', 'options' => ['class' => 'signup-form']]); ?>
            <?php
            $errors = $model->getFirstErrors();
            $error = '';
            if(isset($errors['verifyCode'])) {
                $error = $errors['verifyCode'];
            } elseif(isset($errors['phone'])) {
                $error = $errors['phone'];
            } elseif(isset($errors['password'])) {
                $error = $errors['password'];
            } elseif(isset($errors['rePassword'])) {
                $error = $errors['rePassword'];
            } elseif(isset($errors['agreeProtocol'])) {
                $error = $errors['agreeProtocol'];
            }
            if($errors) { ?>
                <div class="form-error"><i class="iconfont jia-caution_b"></i><label class="text"><?= $error ?></label></div>
            <?php } ?>
            <div class="editable">
                <?= Html::activeTextInput($model, 'phone', ['class' => 'input-text']) ?>
                <span class="placeholder">请输入手机号码</span>
            </div>
            <div class="editable">
                <?= Html::activePasswordInput($model, 'password', ['class' => 'input-text', 'autocomplete' => 'off']) ?>
                <span class="placeholder">请输入密码</span>
            </div>
            <div class="editable">
                <?= Html::activePasswordInput($model, 'rePassword', ['class' => 'input-text', 'autocomplete' => 'off']) ?>
                <span class="placeholder">请输入确认密码</span>
            </div>
            <div class="editable">
                <?= Html::activeTextInput($model, 'verifyCode', ['class' => 'input-text', 'autocomplete' => 'off']) ?>
                <span class="placeholder">请输入验证码</span>
                <?= Captcha::widget([
                    'model' => $model,
                    'attribute' => 'verifyCode',
                    'captchaAction' => '/account/passport/captcha',
                    'template' => '{image}',
                    'options' => ['class' => 'form-control', 'placeholder' => $model->getAttributeLabel('verifyCode')],
                    'imageOptions' => ['title' => '点击刷新', 'alt' => '验证码', 'style' => 'cursor: pointer;'],
                ]) ?>
            </div>
            <p class="rem-check">
                <?= Html::activeCheckbox($model, 'agreeProtocol', ['label' => $model->getAttributeLabel('agreeProtocol').Html::a(' 用户协议', ['help/detail', 'slug' => 'user-protocol'], ['target' => '_blank'])]) ?>
            </p>
            <div class="btn-box">
                <?= Html::submitButton('注    册', ['class' => 'btn-settlement', 'style' => "cursor:pointer;"]) ?>
            </div>
            <div class="link-box">
                <?= Html::a('已有账号直接登录', ['passport/login'], ['class' => 'sign-up-link']) ?>
            </div>
            <?php ActiveForm::end(); ?>

            <div class="login-short">
                <h3>使用合作账号登录：</h3>
                <?= AuthChoice::widget([
                    'baseAuthUrl' => ['/account/passport/auth'],
                    'popupMode' => true,
                ]) ?>
            </div>
        </div>
    </div>
</div>