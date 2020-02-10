<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use frontend\assets\ValidationAsset;
use yii\authclient\widgets\AuthChoice;
use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = '用户登录';
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
        "LoginForm[email]": {
            "required": true,
            "email": true
        },
        "LoginForm[password]": {
            "required": true,
            "minlength": 6
        },
        "LoginForm[verifyCode]": {
            "required": true
        },
    },
	messages: {
	    "LoginForm[email]": {
            "required": '<i class="iconfont jia-close_b"></i>用户名/邮箱必填',
            "email": '<i class="iconfont jia-close_b"></i>电子邮箱格式不正确'
        },
        "LoginForm[password]": {
            "required": '<i class="iconfont jia-close_b"></i>密码必填',
            "minlength": '<i class="iconfont jia-close_b"></i>密码不能小于6位'
        },
        "LoginForm[verifyCode]": {
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

<div class="login-wrap container clearfix">
    <div class="ad-box">
        <?= $this->render('_user-banner') ?>
    </div>

    <div class="form-box">
        <ul class="form-tab clearfix">
            <li class="tab-li on"><a href="javascript:;" class="sign-in">账号登录</a></li>
            <li class="tab-li"><?= Html::a('新用户注册', ['user/signup'], ['class' => 'sign-up']) ?></li>
        </ul>
        <div class="form-content">
            <?= $this->render('../_alert') ?>
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
                }
                if($errors) { ?>
                    <div class="form-error"><i class="iconfont jia-caution_b"></i><label class="text"><?= $error ?></label></div>
                <?php } ?>
                <div class="editable">
                    <?= Html::activeTextInput($model, 'email', ['class' => 'input-text']) ?>
                    <span class="placeholder">请输入用户名/邮箱</span>
                </div>
                <div class="editable">
                    <?= Html::activePasswordInput($model, 'password', ['class' => 'input-text', 'autocomplete' => 'off']) ?>
                    <span class="placeholder">请输入密码</span>
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
                    <?= Html::activeCheckbox($model, 'rememberMe') ?>
                </p>
                <div class="btn-box">
                    <?= Html::submitButton('登    录', ['class' => 'btn-settlement primary-btn br5', 'style' => "cursor:pointer;"]) ?>
                </div>
                <div class="link-box">
                    <?= Html::a('忘记密码？', ['user/forget'], ['class' => 'forget-pass-link', 'target' => '_blank']) ?>
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