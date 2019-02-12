<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = '免费注册';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container">
    <div class="verify-code">
        <?php
        $verifyCodeform = ActiveForm::begin([
            'action' => ['/account/user/signup-verify-code'],
            'options' => ['class' => 'verify-code-form'],
            'enableClientValidation' => false,
        ]); ?>
        <?= $verifyCodeform->field($verifyModel, 'verifyCode')->widget(Captcha::class, [
            'captchaAction' => '/account/user/captcha',
            'template' => '{input} {image}',
            'options' => ['class' => 'form-control', 'style' => 'width: 228px;', 'placeholder' => $verifyModel->getAttributeLabel('verifyCode')],//注意，widget与field之间的关系
            'imageOptions' => ['title' => '点击刷新', 'alt' => '验证码', 'style' => 'cursor: pointer;'],
        ]) ?>
        <?= Html::submitButton('确认', ['class' => 'btn btn-block btn-primary', 'style' => "cursor:pointer;"]) ?>
        <?php ActiveForm::end(); ?>
    </div>

    <br /><br /><br /><br /><br /><br /><br />

    <div class="signup-form">
        <?php $form = ActiveForm::begin(['enableAjaxValidation' => false, 'id' => 'loginForm', 'options' => ['class' => 'login-form']]); ?>
        <?= $form->field($signupModel, 'phone')->textInput(['placeholder' => $signupModel->getAttributeLabel('phone')]) ?>
        <?= $form->field($signupModel, 'password')->passwordInput(['placeholder' => $signupModel->getAttributeLabel('password')]) ?>
        <?= $form->field($signupModel, 'phoneCode')->passwordInput(['placeholder' => $signupModel->getAttributeLabel('phoneCode')]) ?>
        <a href="javascript:;">获取验证码</a>
        <br />
        <?= Html::submitButton('注 册', ['class' => 'btn btn-block btn-primary', 'style' => "cursor:pointer;"]) ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>

