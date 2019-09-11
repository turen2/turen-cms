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

$this->title = '账户登录';
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
        "LoginForm[phone]": {
            "required": true,
            "isPhone": true
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
	    "LoginForm[phone]": {
            "required": '<i class="iconfont jia-close_b"></i>用户名/手机号码必填'
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
            <li class="tab-li on"><a href="javascript:;" class="sign-in">账户登录</a></li>
            <li class="tab-li"><?= Html::a('手机快捷登录', ['passport/quick'], ['class' => 'sign-quick']) ?></li>
        </ul>
        <div class="form-content">
            <?= $this->render('../_alert') ?>
            <?php $form = ActiveForm::begin(['enableAjaxValidation' => false, 'id' => 'loginForm', 'options' => ['class' => 'login-form']]); ?>
                <?php
                $errors = $model->getFirstErrors();
                $error = '';
                if(isset($errors['verifyCode'])) {
                    $error = $errors['verifyCode'];
                } elseif(isset($errors['phone'])) {
                    $error = $errors['phone'];
                } elseif(isset($errors['password'])) {
                    $error = $errors['password'];
                }
                if($errors) { ?>
                    <div class="form-error"><i class="iconfont jia-caution_b"></i><label class="text"><?= $error ?></label></div>
                <?php } ?>

                <div class="editable">
                    <?= Html::activeTextInput($model, 'phone', ['class' => 'input-text']) ?>
                    <span class="placeholder">请输入用户名/手机号</span>
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
                            'captchaAction' => '/account/passport/captcha',
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
                    <?= Html::a('新客户注册', ['passport/signup'], ['class' => 'sign-up-link', 'target' => '_blank']) ?>
                    <?= Html::a('忘记密码？', ['passport/forget'], ['class' => 'forget-pass-link fr', 'target' => '_blank']) ?>
                </div>
            <?php ActiveForm::end(); ?>

            <div class="login-short">
                <h3>使用社交账号登录：</h3>
                <?php
                $authAuthChoice = AuthChoice::begin([
                    'baseAuthUrl' => ['/account/passport/auth'],
                    'popupMode' => true,
                ]);
                foreach ($authAuthChoice->getClients() as $client) {
                    $clientId = $client->getId();
                    $htmlOptions = [];
                    $htmlOptions['popupWidth'] = 627;
                    $htmlOptions['popupHeight'] = 400;
                    $htmlOptions['class'] = $clientId;
                    echo $authAuthChoice->clientLink($client, '<span class="icon"><i class="iconfont jia-'.$clientId.'"></i></span>', $htmlOptions);
                }
                AuthChoice::end();
                ?>
            </div>
        </div>
    </div>
</div>