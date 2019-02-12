<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = '用户登录';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container">
    <?php $form = ActiveForm::begin(['enableAjaxValidation' => false, 'id' => 'loginForm', 'options' => ['class' => 'login-form']]); ?>
    <?= $form->field($model, 'verifyName')->textInput(['placeholder' => $model->getAttributeLabel('verifyName')]) ?>
    <?= $form->field($model, 'password')->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>
    <?= $form->field($model, 'verifyCode')->widget(Captcha::class, [
        'captchaAction' => '/account/user/captcha',
        'template' => '{input} {image}',
        'options' => ['class' => 'form-control', 'style' => 'width: 228px;', 'placeholder' => $model->getAttributeLabel('verifyCode')],//注意，widget与field之间的关系
        'imageOptions' => ['title' => '点击刷新', 'alt' => '验证码', 'style' => 'cursor: pointer;'],
    ]) ?>

    <?= $form->field($model, 'rememberMe')->checkbox() ?>

    <?php if($model->hasErrors()) { ?>
        <div class="alert alert-warning hide">忘记密码请联系管理员。</div>
    <?php } ?>

    <?= Html::submitButton('登 录', ['class' => 'btn btn-block btn-primary', 'style' => "cursor:pointer;"]) ?>
    <?php ActiveForm::end(); ?>
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
<br /><br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br /><br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br /><br />
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
