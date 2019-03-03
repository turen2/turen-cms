<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
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

<?= VerifyCodeWidget::widget([
    'templateId' => 'verify-code-form-box',
    'verifyUrl' => Url::to(['/account/user/signup-verify-code']),
]); ?>

<div class="container">
    <div class="signup-form">
        <?php $form = ActiveForm::begin(['enableAjaxValidation' => false, 'id' => 'loginForm', 'options' => ['class' => 'login-form']]); ?>
        <?= $form->field($signupModel, 'phone')->textInput(['placeholder' => $signupModel->getAttributeLabel('phone')]) ?>
        <?= $form->field($signupModel, 'password')->passwordInput(['placeholder' => $signupModel->getAttributeLabel('password')]) ?>
        <?= $form->field($signupModel, 'phoneCode')->passwordInput(['placeholder' => $signupModel->getAttributeLabel('phoneCode')]) ?>
        <a href="javascript:;" class="get-verify-code">获取验证码</a>
        <br />
        <?= Html::submitButton('注 册', ['class' => 'btn btn-block btn-primary', 'style' => "cursor:pointer;"]) ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>

