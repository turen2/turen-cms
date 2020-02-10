<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \backend\models\admin\form\Login */

$this->title = '登录-后台管理面板';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php // Html::errorSummary($model) ?>

<div class="login-head">
	<img alt="" height="66px" src="<?= Yii::$app->aliyunoss->getObjectUrl(Yii::$app->params['config_backend_logo'], true) ?>">
</div>

<?php $form = ActiveForm::begin(['enableAjaxValidation' => false, 'id' => 'loginForm', 'options' => ['class' => 'login-form']]); ?>
    <?= $form->field($model, 'username')->textInput(['placeholder' => $model->getAttributeLabel('username')]) ?>
    <?= $form->field($model, 'password')->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>
    <?= $form->field($model, 'verifyCode')->widget(Captcha::class, [
        'captchaAction' => '/site/admin/captcha',
        'template' => '{input} {image}',
        'options' => ['class' => 'form-control', 'style' => 'width: 228px;', 'placeholder' => $model->getAttributeLabel('verifyCode')],//注意，widget与field之间的关系
        'imageOptions' => ['title' => '点击刷新', 'alt' => '验证码', 'style' => 'cursor: pointer;'],
    ]) ?>
    
    <?php if(Yii::$app->params['config.loginSafeProblem']) { ?>
        <?= $form->field($model, 'questionId')->dropDownList(Yii::$app->params['config.safeQuestion'], ['placeholder' => $model->getAttributeLabel('questionId')]) ?>
    	<?= $form->field($model, 'answer')->textInput(['placeholder' => $model->getAttributeLabel('answer')]) ?>
    <?php } ?>
    
    <?= $form->field($model, 'rememberMe')->checkbox() ?>
    
    <?php if($model->hasErrors()) { ?>
    <div class="alert alert-warning hide">忘记密码请联系管理员。</div>
    <?php } ?>
    
    <?= Html::submitButton('登 录', ['class' => 'btn btn-block btn-primary', 'style' => "cursor:pointer;"]) ?>
<?php ActiveForm::end(); ?>