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

$this->title = '找回密码';
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
var validator = $('#forgetForm').validate({
	rules: {
        "ForgetForm[email]": {
            "required": true,
            "email": true
        },
        "ForgetForm[verifyCode]": {
            "required": true
        }
    },
	messages: {
	    "ForgetForm[email]": {
            "required": '<i class="iconfont jia-close_b"></i>用户名/邮箱必填',
            "email": '<i class="iconfont jia-close_b"></i>电子邮箱格式不正确'
        },
        "ForgetForm[verifyCode]": {
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
<div class="container">
    <?= $this->render('_step', ['point' => 1]) ?>
    <div class="fpass-content">
        <h3><span class="fpass-title"><?= Html::encode($this->title) ?></span>请输入您在创建账户时提供的邮箱</h3>
        <div class="fpass-case">
            <div class="fpass-detais">
                <?php $form = ActiveForm::begin(['id' => 'forgetForm']); ?>
                <?php
                $errors = $model->getFirstErrors();
                $error = '';
                if(isset($errors['verifyCode'])) {
                    $error = $errors['verifyCode'];
                } elseif(isset($errors['email'])) {
                    $error = $errors['email'];
                }
                if($errors) { ?>
                    <div class="form-error"><i class="iconfont jia-caution_b"></i><label class="text"><?= $error ?></label></div>
                <?php } ?>
                <div class="editable">
                    <?= Html::activeTextInput($model, 'email', ['class' => 'input-text', 'autofocus' => true]) ?>
                    <span class="placeholder">请输入邮箱</span>
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
