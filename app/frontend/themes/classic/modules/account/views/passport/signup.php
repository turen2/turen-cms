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
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = '免费注册';
$this->params['breadcrumbs'][] = $this->title;

ValidationAsset::register($this);

$validationCaptchaCodeUrl = Url::to(['passport/validate-captcha']);
$phoneCodeUrl = Url::to(['passport/phone-code']);
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
        },
        "SignupForm[phoneCode]": {
            "required": true
        }
    },
	messages: {
	    "SignupForm[phone]": {
            "required": '<i class="iconfont jia-close_b"></i>手机号码必填',
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
        },
        "SignupForm[phoneCode]": {
            "required": '<i class="iconfont jia-close_b"></i>手机验证码必填'
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

//手机验证码效果
var getCodeBtn = $("#phone-code-btn");//获取验证码按钮
var phoneInput = $('#signupform-phone');
var phoneCodeInput = $('#signupform-phonecode');
var verifyCodeInput = $('#signupform-verifycode');
var verifyCodeBox = verifyCodeInput.parent();
var verifycodeImage = $('#signupform-verifycode-image');

var phone = /^[1][3578][0-9]{9}$/;//手机号码规则
var codeReg = /^\d+$/;//整数规则
var count = 99; //间隔函数，1秒执行
var InterValObj1; //timer变量，控制时间
var curCount1;//当前剩余秒数
var btnStatus = 1;//按钮状态
var successVerifyCode = '';//图形验证码成功后，记录码值
getCodeBtn.on('click', function() {
    //判断隐藏效果
    if(verifyCodeBox.hasClass('hide')) {
        //判断手机码是否为空，且格式正确
        var error = '';
        if(phoneInput.val() == '') {//还没有填充手机号
            error = '手机号码必填';
        }
        if(phoneInput.val() != '' && !phone.test(phoneInput.val())) {//手机格式是否正确
            error = '手机号码格式错误';
        }
        if(error != '') {
            phoneInput.parent().find('p.error').remove();
            phoneInput.parent().append('<p id="signupform-phone-error" class="error"><i class="iconfont jia-close_b"></i>'+error+'</p>');
        } else {
            verifyCodeBox.removeClass('hide');
        }
        //直接返回，不向后面执行
        return;
    }
    
    //同步判断图片验证码//ajax同步请求
    if(btnStatus == 0) {
        return false;//动态码请求中，按钮保持无效
    }
    var error = '';
    if(verifyCodeInput.val() == '') {//还没有填充数字验证码
        error = '图形验证码必填';
    }
    if(verifyCodeInput.val() != '') {
        $.ajax({
            url: '{$validationCaptchaCodeUrl}',
            type: 'GET',
            async: false,//使用同步请求，锁住浏览器
            dataType: 'json',
            context: $(this),
            cache: false,
            data: {verifycode: $.trim(verifyCodeInput.val())},
            success: function(res) {
                console.log(res);
                if (res['state']) {
                    error = '';//验证通过
                    successVerifyCode = verifyCodeInput.val();//备注成功请求的图形验证码
                } else {
                    error = '图形验证码验证错误';//验证不通过
                    //刷新图形验证码
                    verifycodeImage.click();
                }
            }
        });
    }
    verifyCodeBox.find('p.error').remove();
    if(error != '') {
        verifyCodeBox.append('<p id="signupform-verifycode-error" class="error"><i class="iconfont jia-close_b"></i>'+error+'</p>');
        //直接返回，不向后面执行
        return;
    }
    
    //发送验证码效果
    //console.log('发送验证码');
    curCount1 = count;
    //设置button效果，开始计时
    btnStatus = 0;
    $(this).html( + curCount1 + "秒再获取");
    $.ajax({
        url: '{$phoneCodeUrl}',
        type: 'GET',
        dataType: 'json',
        context: $(this),
        cache: false,
        data: {phone: $.trim(phoneInput.val()), verifycode: $.trim(successVerifyCode), signTemplate: 'signup_code'},
        success: function(res) {
            if (res['state']) {
                console.log(res.msg);
                //验证码框获取焦点
                phoneCodeInput.focus();
            } else {
                btnStatus = 1;//启用按钮
                getCodeBtn.html("重新发送");
            }
        }
    });
    InterValObj1 = window.setInterval(function() {
        if (curCount1 == 0) {
            window.clearInterval(InterValObj1);//停止计时器
            btnStatus = 1;//启用按钮
            getCodeBtn.html("重新发送");
        } else {
            curCount1--;
            getCodeBtn.html( + curCount1 + "秒再获取");
        }
    }, 1000);//启动计时器，1秒执行一次
});

//失去/获取焦点时触发
phoneInput.on('blur', function() {
    if(verifyCodeBox.hasClass('hide')) {
        //判断手机码是否为空，且格式正确
        var error = '';
        if(phoneInput.val() == '') {//还没有填充手机号
            error = '手机号码必填';
        }
        if(phoneInput.val() != '' && !phone.test(phoneInput.val())) {//手机格式是否正确
            error = '手机号码格式错误';
        }
        if(error != '') {
            phoneInput.parent().find('p.error').remove();
            phoneInput.parent().append('<p id="signupform-phone-error" class="error"><i class="iconfont jia-close_b"></i>'+error+'</p>');
        } else {
            verifyCodeBox.removeClass('hide');
        }
        //直接返回，不向后面执行
        return;
    }
});
phoneCodeInput.on('focus', function() {
    if(verifyCodeBox.hasClass('hide')) {
        //判断手机码是否为空，且格式正确
        var error = '';
        if(phoneInput.val() == '') {//还没有填充手机号
            error = '手机号码必填';
        }
        if(phoneInput.val() != '' && !phone.test(phoneInput.val())) {//手机格式是否正确
            error = '手机号码格式错误';
        }
        if(error != '') {
            phoneInput.parent().find('p.error').remove();
            phoneInput.parent().append('<p id="signupform-phone-error" class="error"><i class="iconfont jia-close_b"></i>'+error+'</p>');
        } else {
            verifyCodeBox.removeClass('hide');
        }
        //直接返回，不向后面执行
        return;
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
            } elseif(isset($errors['phoneCode'])) {
                $error = $errors['phoneCode'];
            } elseif(isset($errors['password'])) {
                $error = $errors['password'];
            } elseif(isset($errors['rePassword'])) {
                $error = $errors['rePassword'];
            } elseif(isset($errors['agreeProtocol'])) {
                $error = $errors['agreeProtocol'];
            } elseif(isset($errors['phone'])) {
                $error = $errors['phone'];
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
                <span class="placeholder">请确认密码</span>
            </div>
            <div class="editable hide">
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
            <div class="editable">
                <?= Html::activeTextInput($model, 'phoneCode', ['class' => 'input-text', 'autocomplete' => 'off']) ?>
                <span class="placeholder">请输入手机动态码</span>
                <a href="javascript:;" class="verifycode-btn" id="phone-code-btn">获取动态码</a>
            </div>
            <p class="rem-check">
                <?= Html::activeCheckbox($model, 'agreeProtocol', ['label' => $model->getAttributeLabel('agreeProtocol').Html::a(' 用户注册协议', ['/help/index', 'slug' => 'user-protocol'], ['target' => '_blank'])]) ?>
            </p>
            <div class="btn-box">
                <?= Html::submitButton('注    册', ['class' => 'btn-settlement primary-btn br5', 'style' => "cursor:pointer;"]) ?>
            </div>
            <div class="link-box">
                <?= Html::a('已有账号直接登录', ['passport/login'], ['class' => 'sign-up-link']) ?>
            </div>
            <?php ActiveForm::end(); ?>

            <div class="login-short">
                <?php
                $authAuthChoice = AuthChoice::begin([
                    'baseAuthUrl' => ['/account/passport/auth'],
                    'popupMode' => true,
                ]);

                $clients = $authAuthChoice->getClients();
                if(!empty($clients)) {
                    echo '<h3>使用社交账号登录：</h3>';
                }

                foreach ($clients as $client) {
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