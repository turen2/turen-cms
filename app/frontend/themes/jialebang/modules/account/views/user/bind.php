<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\assets\ValidationAsset;

$this->title = '绑定账号';
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
var validator = $('#bindForm').validate({
	rules: {
        "BindForm[email]": {
            "required": true,
            "email": true
        },
        "BindForm[password]": {
            "required": true,
            "minlength": 6
        },
        "BindForm[rePassword]": {
            "required": true,
            "minlength": 6,
            "equalTo": "#bindform-password"
        },
        "BindForm[verifyCode]": {
            "required": true
        }
    },
	messages: {
	    "BindForm[email]": {
            "required": '<i class="iconfont jia-close_b"></i>用户名/邮箱必填',
            "email": '<i class="iconfont jia-close_b"></i>电子邮箱格式不正确'
        },
        "BindForm[password]": {
            "required": '<i class="iconfont jia-close_b"></i>密码必填',
            "minlength": '<i class="iconfont jia-close_b"></i>密码不能小于6位'
        },
        "BindForm[rePassword]": {
            "required": '<i class="iconfont jia-close_b"></i>确认密码必填',
            "minlength": '<i class="iconfont jia-close_b"></i>确认密码不能小于6位',
            "equalTo": '<i class="iconfont jia-close_b"></i>两次输入的密码不一致'
        },
        "BindForm[verifyCode]": {
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
<div class="container bind-account">
    <div class="fpass-content">
        <h3><span class="fpass-title"><?= Html::encode($this->title) ?></span>请输入您在创建账户时提供的邮箱</h3>
        <div class="fpass-case">
            <div class="ext-account">
                <div class="img-box">
                    <img src="<?= $tmodel->getDisplayAvatar() ?>" />
                </div>
                <h6 class="user-h6"><?= $tmodel->getDisplayName() ?>，欢迎您！</h6>
            </div>
            <div class="fpass-detais">
                <?php $form = ActiveForm::begin(['id' => 'bindForm']); ?>
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
                }
                if($errors) { ?>
                    <div class="form-error"><i class="iconfont jia-caution_b"></i><label class="text"><?= $error ?></label></div>
                <?php } ?>
                <div class="editable">
                    <?= Html::activeTextInput($model, 'email', ['class' => 'input-text', 'autofocus' => true]) ?>
                    <span class="placeholder">请输入邮箱</span>
                </div>
                <div class="editable">
                    <?= Html::activePasswordInput($model, 'password', ['class' => 'input-text', 'autofocus' => false]) ?>
                    <span class="placeholder">请输入密码</span>
                </div>
                <div class="editable">
                    <?= Html::activePasswordInput($model, 'rePassword', ['class' => 'input-text', 'autofocus' => false]) ?>
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
                <?= Html::submitButton('下一步', ['class' => 'btn-settlement primary-btn br5']) ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
