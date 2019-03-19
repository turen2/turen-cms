<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use common\models\user\User;
use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '绑定账号';
$this->params['breadcrumbs'][] = $this->title;

$js = <<<EOF
//placeholder效果
$('.editable .input-text').each(function(i){
    if($(this).val() == '') {
        $(this).next('.placeholder').show();
    }
}).on('focus', function() {
    $(this).next('.placeholder').hide();
}).on('blur', function() {
    if($(this).val() == '') {
        $(this).next('.placeholder').show();
    }
});
EOF;
$this->registerJs($js);
?>
<div class="container bind-account">
    <div class="fpass-content">
        <h3><span class="fpass-title"><?= Html::encode($this->title) ?></span>
            <?php if(Yii::$app->params['config_login_mode'] == User::USER_PHONE_MODE) { ?>
                请输入您在创建账户时提供的手机号
            <?php } elseif(Yii::$app->params['config_login_mode'] == User::USER_EMAIL_MODE) { ?>
                请输入您在创建账户时提供的邮箱
            <?php } ?></h3>
        <div class="fpass-case">
            <div class="ext-account">
                <div class="img-box">
                    <img src="<?= $tmodel->getDisplayAvatar() ?>" />
                </div>
                <h6 class="user-h6"><?= $tmodel->getDisplayName() ?>，欢迎您！</h6>
            </div>
            <div class="fpass-detais">
                <?php $form = ActiveForm::begin(['id' => 'bind-form']); ?>
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
                    <div class="form-error"><i></i><label class="text"><?= $error ?></label></div>
                <?php } ?>
                <dl class="editable clearfix">
                    <dt><?= $model->getAttributeLabel('email') ?>：</dt>
                    <dd>
                        <?= Html::activeTextInput($model, 'email', ['class' => 'input-text', 'autofocus' => true]) ?>
                        <span class="placeholder">请输入邮箱</span>
                    </dd>
                </dl>
                <dl class="editable top1 clearfix">
                    <dt><?= $model->getAttributeLabel('password') ?>：</dt>
                    <dd>
                        <?= Html::activePasswordInput($model, 'password', ['class' => 'input-text', 'autofocus' => true]) ?>
                        <span class="placeholder">请输入密码</span>
                    </dd>
                </dl>
                <dl class="editable top2 clearfix">
                    <dt><?= $model->getAttributeLabel('rePassword') ?>：</dt>
                    <dd>
                        <?= Html::activePasswordInput($model, 'rePassword', ['class' => 'input-text', 'autofocus' => true]) ?>
                        <span class="placeholder">请输入确认密码</span>
                    </dd>
                </dl>
                <?php //$form->field($model, 'email')->textInput(['autofocus' => true]) ?>
                <dl class="editable top3 clearfix">
                    <dt><?= $model->getAttributeLabel('verifyCode') ?>：</dt>
                    <dd>
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
                    </dd>
                </dl>
                <?= Html::submitButton('下一步', ['class' => 'btn-settlement']) ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
