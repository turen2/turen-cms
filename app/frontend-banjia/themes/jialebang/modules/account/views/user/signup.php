<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use common\models\user\User;
use yii\captcha\Captcha;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\LayerAsset;
use app\widgets\verifycode\VerifyCodeWidget;

$this->title = '免费注册';
$this->params['breadcrumbs'][] = $this->title;

LayerAsset::register($this);
$js = <<<EOF
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

<br />
<br />

<div class="container">
    <div class="signup-form">
        <?php $form = ActiveForm::begin(['enableAjaxValidation' => false, 'id' => 'loginForm', 'options' => ['class' => 'login-form']]); ?>
        <?php if(Yii::$app->params['config_login_mode'] == User::USER_PHONE_MODE) { ?>
            <?= $form->field($signupModel, 'phone')->textInput(['placeholder' => $signupModel->getAttributeLabel('phone')]) ?>
        <?php } elseif(Yii::$app->params['config_login_mode'] == User::USER_EMAIL_MODE) { ?>
            <?= $form->field($signupModel, 'email')->textInput(['placeholder' => $signupModel->getAttributeLabel('email')]) ?>
        <?php } ?>
        <?= $form->field($signupModel, 'password')->passwordInput(['placeholder' => $signupModel->getAttributeLabel('password')]) ?>
        <?= $form->field($signupModel, 'rePassword')->passwordInput(['placeholder' => $signupModel->getAttributeLabel('rePassword')]) ?>
        <?= $form->field($signupModel, 'verifyCode')->widget(Captcha::class, [
            'captchaAction' => '/account/user/captcha',
            'template' => '{input} {image}',
            'options' => ['class' => 'form-control', 'style' => 'width: 228px;', 'placeholder' => $signupModel->getAttributeLabel('verifyCode')],
            'imageOptions' => ['title' => '点击刷新', 'alt' => '验证码', 'style' => 'cursor: pointer;'],
        ]) ?>
        <?= Html::submitButton('注 册', ['class' => 'btn btn-block btn-primary', 'style' => "cursor:pointer;"]) ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>

<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />