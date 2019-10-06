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

//验证提示效果
var validator = $('#loginForm').validate({
	rules: {
        "SignupForm[email]": {
            "required": true,
            "email": true
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
        },
    },
	messages: {
	    "SignupForm[email]": {
            "required": '<i class="iconfont jia-close_b"></i>用户名/邮箱必填',
            "email": '<i class="iconfont jia-close_b"></i>电子邮箱格式不正确'
        },
        "SignupForm[password]": {
            "required": '<i class="iconfont jia-close_b"></i>密码必填',
            "minlength": '<i class="iconfont jia-close_b"></i>密码不能小于6位'
        },
        "SignupForm[rePassword]": {
            "required": '<i class="iconfont jia-close_b"></i>确认密码必填',
            "minlength": '<i class="iconfont jia-close_b"></i>确认密码不能小于6位',
            "equalTo": '<i class="iconfont jia-close_b"></i>两次输入的密码不一致'
        },
        "SignupForm[verifyCode]": {
            "required": '<i class="iconfont jia-close_b"></i>验证码必填'
        },
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
            <?php $form = ActiveForm::begin(['enableAjaxValidation' => false, 'id' => 'loginForm', 'options' => ['class' => 'login-form']]); ?>
            <?php
            $errors = $model->getFirstErrors();
            $error = '';
            if(isset($errors['verifyCode'])) {
                $error = $errors['verifyCode'];
            } elseif(isset($errors['email'])) {
                $error = $errors['email'];
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
                <?= Html::activeTextInput($model, 'email', ['class' => 'input-text']) ?>
                <span class="placeholder">请输入邮箱</span>
            </div>
            <div class="editable">
                <?= Html::activePasswordInput($model, 'password', ['class' => 'input-text', 'autocomplete' => 'off']) ?>
                <span class="placeholder">请输入密码</span>
            </div>
            <div class="editable">
                <?= Html::activePasswordInput($model, 'rePassword', ['class' => 'input-text', 'autocomplete' => 'off']) ?>
                <span class="placeholder">请确认密码</span>
            </div>
            <div class="editable">
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
            </div>
            <p class="rem-check">
                <?= Html::activeCheckbox($model, 'agreeProtocol', ['label' => $model->getAttributeLabel('agreeProtocol').Html::a(' 用户协议', ['help/detail', 'slug' => 'user-protocol'], ['target' => '_blank'])]) ?>
            </p>
            <div class="btn-box">
                <?= Html::submitButton('注    册', ['class' => 'btn-settlement primary-btn br5', 'style' => "cursor:pointer;"]) ?>
            </div>
            <div class="link-box">
                <?= Html::a('已有账号直接登录', ['user/login'], ['class' => 'sign-up-link']) ?>
            </div>
            <?php ActiveForm::end(); ?>

            <div class="login-short">
                <h3>使用合作账号登录：</h3>
                <?= AuthChoice::widget([
                    'baseAuthUrl' => ['/account/user/auth'],
                    'popupMode' => true,
                ]) ?>
            </div>
        </div>
    </div>
</div>