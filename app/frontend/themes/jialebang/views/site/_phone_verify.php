<?php
//展示验证码
//获取手机动态码
//提交
use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin([
    'id' => 'phoneVerifyForm',
    'enableAjaxValidation' => true,
    'options' => ['class' => 'phone-verify-form']
]); ?>

<?= $form->field($model, 'verifyCode')->widget(Captcha::class, [
    'captchaAction' => '/site/captcha',
    'template' => '{input}{image}',
    'options' => ['class' => 'form-control', 'placeholder' => $model->getAttributeLabel('verifyCode')],
    'imageOptions' => ['title' => '点击刷新', 'alt' => '验证码', 'style' => 'cursor: pointer;'],
]) ?>
<br />
<?= $form->field($model, 'phone') ?>
<br />
<?= $form->field($model, 'phoneCode') ?>
<br />
<?= Html::submitButton('Submit') ?>
<?php ActiveForm::end(); ?>
