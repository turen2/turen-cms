<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use common\models\user\User;
use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = '用户登录';
$this->params['breadcrumbs'][] = $this->title;
?>

<br />
<br />

<div class="container">
    <div class="login-form">
        <?php $form = ActiveForm::begin(['enableAjaxValidation' => false, 'id' => 'loginForm', 'options' => ['class' => 'login-form']]); ?>
        <?php if(Yii::$app->params['config_login_mode'] == User::USER_PHONE_MODE) { ?>
            <?= $form->field($model, 'phone')->textInput(['placeholder' => $model->getAttributeLabel('phone')]) ?>
        <?php } elseif(Yii::$app->params['config_login_mode'] == User::USER_EMAIL_MODE) { ?>
            <?= $form->field($model, 'email')->textInput(['placeholder' => $model->getAttributeLabel('email')]) ?>
        <?php } ?>
        <?= $form->field($model, 'password')->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>
        <?= $form->field($model, 'verifyCode')->widget(Captcha::class, [
            'captchaAction' => '/account/user/captcha',
            'template' => '{input} {image}',
            'options' => ['class' => 'form-control', 'style' => 'width: 228px;', 'placeholder' => $model->getAttributeLabel('verifyCode')],
            'imageOptions' => ['title' => '点击刷新', 'alt' => '验证码', 'style' => 'cursor: pointer;'],
        ]) ?>

        <?= $form->field($model, 'rememberMe')->checkbox() ?>

        <?php if($model->hasErrors()) { ?>
            <div class="alert alert-warning hide">忘记密码请联系管理员。</div>
        <?php } ?>

        <?= Html::submitButton('登 录', ['class' => 'btn btn-block btn-primary', 'style' => "cursor:pointer;"]) ?>
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