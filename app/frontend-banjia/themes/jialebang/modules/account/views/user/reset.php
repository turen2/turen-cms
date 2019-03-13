<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '重置密码';
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
<div class="container">
    <?= $this->render('_step', ['point' => 3]) ?>
    <div class="fpass-content">
        <h3><span class="fpass-title"><?= Html::encode($this->title) ?></span></h3>
        <div class="fpass-case">
            <div class="fpass-detais">
                <?php $form = ActiveForm::begin(['id' => 'reset-form']); ?>
                <?php
                $errors = $model->getFirstErrors();
                $error = '';
                if(isset($errors['password'])) {
                    $error = $errors['password'];
                } elseif(isset($errors['verifyCode'])) {
                    $error = $errors['verifyCode'];
                }
                if($errors) { ?>
                    <div class="form-error"><i></i><label class="text"><?= $error ?></label></div>
                <?php } ?>
                <dl class="editable clearfix">
                    <dt><?= $model->getAttributeLabel('password') ?>：</dt>
                    <dd>
                        <?= Html::activePasswordInput($model, 'password', ['class' => 'input-text', 'autofocus' => true]) ?>
                        <span class="placeholder">请输入新密码</span>
                    </dd>
                </dl>
                <dl class="editable top1 clearfix">
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
                <?= Html::submitButton('确认', ['class' => 'btn-settlement']) ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
