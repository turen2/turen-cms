<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\assets\ValidationAsset;

$this->title = '重置密码';
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
var validator = $('#resetForm').validate({
	rules: {
        "ResetForm[password]": {
            "required": true,
            "minlength": 6
        },
        "ResetForm[rePassword]": {//不能为空，而且还必须正确
            "required": true,
            "minlength": 6,
            "equalTo": "#resetform-password"
        }
    },
	messages: {
	    "ResetForm[password]": {
            "required": '<i class="iconfont jia-close_b"></i>新密码必填',
            "minlength": '<i class="iconfont jia-close_b"></i>新密码不能小于6位'
        },
        "ResetForm[rePassword]": {
            "required": '<i class="iconfont jia-close_b"></i>确认新密码必填',
            "minlength": '<i class="iconfont jia-close_b"></i>确认新密码不能小于6位',
            "equalTo": '<i class="iconfont jia-close_b"></i>两次输入的密码不一致'
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
    <?= $this->render('_step', ['point' => 3]) ?>
    <div class="fpass-content">
        <h3><span class="fpass-title"><?= Html::encode($this->title) ?></span></h3>
        <div class="fpass-case">
            <div class="fpass-detais">
                <?php $form = ActiveForm::begin(['id' => 'resetForm']); ?>
                <?php
                $errors = $model->getFirstErrors();
                $error = '';
                if(isset($errors['rePassword'])) {
                    $error = $errors['rePassword'];
                } elseif(isset($errors['password'])) {
                    $error = $errors['password'];
                }
                if($errors) { ?>
                    <div class="form-error"><i class="iconfont jia-caution_b"></i><label class="text"><?= $error ?></label></div>
                <?php } ?>
                <div class="editable">
                    <?= Html::activePasswordInput($model, 'password', ['class' => 'input-text', 'autofocus' => false]) ?>
                    <span class="placeholder">请输入新密码</span>
                </div>
                <div class="editable">
                    <?= Html::activePasswordInput($model, 'rePassword', ['class' => 'input-text', 'autofocus' => false]) ?>
                    <span class="placeholder">请确认新密码</span>
                </div>
                <?= Html::submitButton('确认', ['class' => 'btn-settlement primary-btn br5']) ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
