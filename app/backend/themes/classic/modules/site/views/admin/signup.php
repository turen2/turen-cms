<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \backend\models\admin\form\Signup */

$this->title = '商户注册';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php //echo Html::encode($this->title) ?>
<?php echo Html::errorSummary($model) // 错误信息集中显示?>

<div class="signinpanel">
    <div class="row">
        <div class="col-sm-7">
            <div class="signin-info">
                <div class="logopanel m-b">
                    <h1>[ <?= Yii::$app->name ?>网站管理后台 ]</h1>
                </div>
                <div class="m-b"></div>
                <h4>欢迎使用<strong>土人精准建站系统</strong></h4>
                <ul class="m-b">
                    <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 优势一</li>
                    <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 优势二</li>
                    <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 优势三</li>
                    <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 优势四</li>
                    <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 优势五</li>
                </ul>
                <strong>已经有管理账号？ <?= Html::a('请登录', ['/comm/user/login']) ?></strong>
            </div>
        </div>
        <div class="col-sm-5">
            <?php $form = ActiveForm::begin(['id' => 'signup-form']); ?>
                <p class="m-t-md">填写表单完成注册。</p>
                <?= $form->field($model, 'username', ['inputOptions' => ['placeholder' => $model->getAttributeLabel('username')]])->textInput(['class' => 'form-control uname'])->label(false) ?>
                <?= $form->field($model, 'email', ['inputOptions' => ['placeholder' => $model->getAttributeLabel('email')]])->textInput(['class' => 'form-control pemail m-b'])->label(false) ?>
                <?= $form->field($model, 'password', ['inputOptions' => ['placeholder' => $model->getAttributeLabel('password')]])->passwordInput(['class' => 'form-control pword m-b'])->label(false) ?>
                <?= $form->field($model, 'repassword', ['inputOptions' => ['placeholder' => $model->getAttributeLabel('repassword')]])->passwordInput(['class' => 'form-control pword m-b'])->label(false) ?>
                <?= Html::submitButton('注册', ['class' => 'btn btn-success btn-block', 'name' => 'login-button']) ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    
    <div class="row">
        <div class="col-sm-12">
            <ul class="footer-links clearfix">
                <li class="title">友情链接：</li>
                <li><a href="javascript: alert('正在开发中.....');">百度指数</a></li>
                <li><a href="javascript: alert('正在开发中.....');">谷歌搜索</a></li>
                <li><a href="javascript: alert('正在开发中.....');">精准推广</a></li>
                <li><a href="javascript: alert('正在开发中.....');">土人工作室</a></li>
                <li><a href="javascript: alert('正在开发中.....');">网站运营</a></li>
                <li><a href="javascript: alert('正在开发中.....');">网站运营</a></li>
                <li><a href="javascript: alert('正在开发中.....');">网站运营</a></li>
            </ul>
        </div>
    </div>
    
    <div class="signup-footer">
        <div class="text-center">
            &copy; <?= date('Y') ?> All Rights Reserved. <?= Yii::$app->name ?>
        </div>
    </div>
</div>