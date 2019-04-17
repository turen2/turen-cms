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
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = '手机快捷登录';
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
var validator = $('#phoneLoginForm').validate({
	rules: {
        "PhoneLoginForm[phone]": {
            "required": true,
            "isPhone": true
        },
        "PhoneLoginForm[verifyCode]": {//不能为空，而且还必须正确
            "required": true
        },
        "PhoneLoginForm[phoneCode]": {
            "required": true
        }
    },
	messages: {
	    "PhoneLoginForm[phone]": {
            "required": '<i class="iconfont jia-close_b"></i>手机号码必填',
            "isPhone": '<i class="iconfont jia-close_b"></i>手机号码格式错误'
        },
        "PhoneLoginForm[verifyCode]": {
            "required": '<i class="iconfont jia-close_b"></i>图形验证码必填'
        },
        "PhoneLoginForm[phoneCode]": {
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
var phoneInput = $('#phoneloginform-phone');
var phoneCodeInput = $('#phoneloginform-phonecode');
var verifyCodeInput = $('#phoneloginform-verifycode');
var verifyCodeBox = verifyCodeInput.parent();
var verifycodeImage = $('#phoneloginform-verifycode-image');

var phone = /^[1][3578][0-9]{9}$/;//手机号码规则
var codeReg = /^\d+$/;//整数规则
var count = 60; //间隔函数，1秒执行
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
            phoneInput.parent().append('<p id="phoneloginform-phone-error" class="error"><i class="iconfont jia-close_b"></i>'+error+'</p>');
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
        verifyCodeBox.append('<p id="phoneloginform-verifycode-error" class="error"><i class="iconfont jia-close_b"></i>'+error+'</p>');
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
        data: {phone: $.trim(phoneInput.val()), verifycode: $.trim(successVerifyCode)},
        success: function(res) {
            if (res['state']) {
                console.log(res.msg);
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
            phoneInput.parent().append('<p id="phoneloginform-phone-error" class="error"><i class="iconfont jia-close_b"></i>'+error+'</p>');
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
            phoneInput.parent().append('<p id="phoneloginform-phone-error" class="error"><i class="iconfont jia-close_b"></i>'+error+'</p>');
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

<div class="login-wrap container clearfix">
    <div class="ad-box">
        <?= $this->render('_user-banner') ?>
    </div>

    <div class="form-box">
        <ul class="form-tab clearfix">
            <li class="tab-li"><?= Html::a('账户登录', ['passport/login'], ['class' => 'sign-in']) ?></li>
            <li class="tab-li on"><?= Html::a('手机快捷登录', ['passport/quick'], ['class' => 'sign-quick']) ?></li>
        </ul>
        <div class="form-content">
            <?php $form = ActiveForm::begin(['enableAjaxValidation' => false, 'id' => 'phoneLoginForm', 'options' => ['class' => 'login-form']]); ?>
                <?php
                $errors = $model->getFirstErrors();
                $error = '';
                if(isset($errors['phone'])) {
                    $error = $errors['phone'];
                } elseif(isset($errors['phoneCode'])) {
                    $error = $errors['phoneCode'];
                }
                if($errors) { ?>
                    <div class="form-error"><i class="iconfont jia-caution_b"></i><label class="text"><?= $error ?></label></div>
                <?php } ?>

                <div class="editable">
                    <?= Html::activeTextInput($model, 'phone', ['class' => 'input-text']) ?>
                    <span class="placeholder">请输入手机号</span>
                </div>
                <div class="editable hide">
                    <?= Html::activeTextInput($model, 'verifyCode', ['class' => 'input-text', 'autocomplete' => 'off']) ?>
                    <span class="placeholder">请输入数字验证码</span>
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
                    <?= Html::activeCheckbox($model, 'rememberMe') ?>
                </p>
                <div class="btn-box">
                    <?= Html::submitButton('登    录', ['class' => 'btn-settlement', 'style' => "cursor:pointer;"]) ?>
                </div>
                <div class="link-box">
                    <?= Html::a('新客户注册', ['passport/signup'], ['class' => 'sign-up-link', 'target' => '_blank']) ?>
                    <?= Html::a('忘记密码？', ['passport/forget'], ['class' => 'forget-pass-link fr', 'target' => '_blank']) ?>
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