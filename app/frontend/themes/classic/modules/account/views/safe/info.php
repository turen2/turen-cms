<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use common\helpers\Util;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\LayerAsset;
use frontend\assets\NotifyAsset;
use frontend\assets\ValidationAsset;

$this->title = '账户安全';
$this->params['breadcrumbs'][] = $this->title;

LayerAsset::register($this);
NotifyAsset::register($this);
ValidationAsset::register($this);

$js = <<<EOF
$.notify.defaults({
    autoHideDelay: 2000,
    showDuration: 600,
    hideDuration: 200,
    globalPosition: 'top center'
});

//异步提交数据
$('.setting a.default-btn').on('click', function() {
    var template = $(this).data('template');
    var url = $(this).data('url');
    var name = $(this).parents('.setting').find('.title').text();
    layer.open({
        type: 1,
        title: name,
        closeBtn: 1,
        shadeClose: true,//点击背景关闭窗口，模态框
        shade: 0.5,
        move: false, //来禁止拖拽
        area: '480px', //宽高//此处只取宽
        skin: 'jia-modal',
        content: $('#'+template),//否则会出现多个id问题，必须是对象，自动克隆
        success: function(index, layero) {
            //$(index[0]).find('#phone-code-btn').on('click', function() {
                //console.log('发送手机验证码');
            //});
            
        },
        end: function(index, layero) {
            //$('body').off('click', '#phone-code-btn');
        }
    });
});
EOF;
$this->registerJs($js);
?>
<div id="password-template" style="display: none;">
    <?= Html::beginForm(Url::to(['/account/safe/update-password']), 'POST', ['onsubmit' => "return turen.user.passwordCheck(this);"]) ?>
    <div class="form-group">
        <?= Html::activeLabel($model, 'currentPassword') ?>
        <?= Html::activePasswordInput($model, 'currentPassword',  ['class' => 'form-control text']) ?>
    </div>
    <div class="form-group">
        <?= Html::activeLabel($model, 'password') ?>
        <?= Html::activePasswordInput($model, 'password',  ['class' => 'form-control text']) ?>
    </div>
    <div class="form-group">
        <?= Html::activeLabel($model, 'rePassword') ?>
        <?= Html::activePasswordInput($model, 'rePassword',  ['class' => 'form-control text']) ?>
    </div>
    <div class="form-group" style="margin: 0;">
        <div class="layui-layer-btn" style="padding: 8px 0px 24px;">
            <?= Html::submitButton('提交', ['class' => 'layui-layer-btn0']) ?>
            <?= Html::button('取消', ['class' => 'layui-layer-btn1', 'onclick' => 'layer.closeAll();']) ?>
        </div>
    </div>
    <?= Html::endForm() ?>
</div>
<div id="phone-template" style="display: none;">
    <?= Html::beginForm(Url::to(['/account/safe/bind-phone']), 'POST', ['onsubmit' => "return turen.user.phoneCheck(this);"]) ?>
    <?php if(!empty($userModel->phone)) { ?>
        <div class="form-group">
            <?= Html::label('原手机号') ?>
            <?= Html::textInput('phone', Util::HidePart($userModel->phone), ['class' => 'form-control text', 'disabled' => 'disabled']) ?>
        </div>
    <?php } ?>
    <div class="form-group">
        <?= Html::activeLabel($model, 'currentPassword') ?>
        <?= Html::activePasswordInput($model, 'currentPassword',  ['class' => 'form-control text', 'id' => 'phone-currentPassword']) ?>
    </div>
    <div class="form-group">
        <?= Html::activeLabel($model, 'phone') ?>
        <?= Html::activeTextInput($model, 'phone',  ['class' => 'form-control text']) ?>
    </div>
    <div class="form-group">
        <?= Html::activeLabel($model, 'phoneCode') ?>
        <?= Html::activeTextInput($model, 'phoneCode',  ['class' => 'form-control text']) ?>
        <?= Html::a('获取动态码', 'javascript:;', ['id' => 'phone-code-btn', 'class' => 'verifycode-btn', 'data-url' => Url::to(['/account/safe/phone-code']), 'onclick' => 'turen.user.phoneCode(this);']) ?>
    </div>
    <div class="form-group" style="margin: 0;">
        <div class="layui-layer-btn" style="padding: 8px 0px 24px;">
            <?= Html::submitButton('提交', ['class' => 'layui-layer-btn0']) ?>
            <?= Html::button('取消', ['class' => 'layui-layer-btn1', 'onclick' => 'layer.closeAll();']) ?>
        </div>
    </div>
    <?= Html::endForm() ?>
</div>
<div id="email-template" style="display: none;">
    <?= Html::beginForm(Url::to(['/account/safe/bind-email']), 'POST', ['onsubmit' => "return turen.user.emailCheck(this);"]) ?>
    <?php if(!empty($userModel->email)) { ?>
        <div class="form-group">
            <?= Html::label('原邮箱地址') ?>
            <?= Html::textInput('email', Util::HidePart($userModel->email), ['class' => 'form-control text', 'disabled' => 'disabled']) ?>
        </div>
    <?php } ?>
    <div class="form-group">
        <?= Html::activeLabel($model, 'currentPassword') ?>
        <?= Html::activePasswordInput($model, 'currentPassword',  ['class' => 'form-control text', 'id' => 'email-currentPassword']) ?>
    </div>
    <div class="form-group">
        <?= Html::activeLabel($model, 'email') ?>
        <?= Html::activeTextInput($model, 'email',  ['class' => 'form-control text']) ?>
    </div>
    <div class="form-group">
        <?= Html::activeLabel($model, 'emailCode') ?>
        <?= Html::activeTextInput($model, 'emailCode',  ['class' => 'form-control text']) ?>
        <?= Html::a('获取动态码', 'javascript:;', ['id' => 'email-code-btn', 'class' => 'verifycode-btn', 'data-url' => Url::to(['/account/safe/email-code']), 'onclick' => 'turen.user.emailCode(this);']) ?>
    </div>
    <div class="form-group" style="margin: 0;">
        <div class="layui-layer-btn" style="padding: 8px 0px 24px;">
            <?= Html::submitButton('提交', ['class' => 'layui-layer-btn0']) ?>
            <?= Html::button('取消', ['class' => 'layui-layer-btn1', 'onclick' => 'layer.closeAll();']) ?>
        </div>
    </div>
    <?= Html::endForm() ?>
</div>

<div class="user-center">
    <div class="container clearfix">
        <?= $this->render('../_account_sidebox') ?>
        <div class="user-content card info">
            <div class="user-content-head">
                <div class="title"><?= $this->title ?></div>
            </div>
            <div class="user-content-body" style="margin-bottom: 60px;">
                <?php $safeLevel = !empty($userModel->password_hash) + !empty($userModel->phone) + !empty($userModel->email); ?>
                <div class="security warning">
                    <?php if($safeLevel == 0) { ?>
                        <span class="icon"><i class="iconfont jia-caution_b"></i></span>
                        <span class="title">安全等级</span>
                        <span class="progress"></span>
                        <span class="progress"></span>
                        <span class="progress"></span>
                        <span class="level">危</span>
                    <?php } elseif($safeLevel == 1) { ?>
                        <span class="icon"><i class="iconfont jia-caution_b"></i></span>
                        <span class="title">安全等级</span>
                        <span class="progress done"></span>
                        <span class="progress"></span>
                        <span class="progress"></span>
                        <span class="level">低</span>
                    <?php } elseif($safeLevel == 2) { ?>
                        <span class="icon"><i class="iconfont jia-caution_b"></i></span>
                        <span class="title">安全等级</span>
                        <span class="progress done"></span>
                        <span class="progress done"></span>
                        <span class="progress"></span>
                        <span class="level">中</span>
                    <?php } elseif($safeLevel == 3) { ?>
                        <span class="icon"><i class="iconfont jia-yes_b"></i></span>
                        <span class="title">安全等级</span>
                        <span class="progress done"></span>
                        <span class="progress done"></span>
                        <span class="progress done"></span>
                        <span class="level">高</span>
                    <?php }  ?>
                </div>
                <div class="setting">
                    <span class="icon"><i class="iconfont jia-lock"></i></span>
                    <span class="title">登录密码</span>
                    <span class="content"><?= empty($userModel->password_hash)?'您的账户未设置登录密码存在安全风险':'经常更改密码有助于保护您的帐号安全' ?></span>
                    <span class="action">
                        <?= empty($userModel->password_hash)?'<span class="status">未设置</span>':'<span class="status status-done">已设置</span>' ?>
                        <a href="javascript:;" data-template="password-template" class="default-btn br5 password-btn"><?= empty($userModel->password_hash)?'设置':'修改' ?></a>
                  </span>
                </div>
                <div class="setting">
                    <span class="icon"><i class="iconfont jia-Phone"></i></span>
                    <span class="title">手机绑定</span>
                    <span class="content"><?= empty($userModel->phone)?'用于找回登录密码':('已绑定手机：'.Util::HidePart($userModel->phone)) ?></span>
                    <span class="action">
                        <?= empty($userModel->phone)?'<span class="status">未绑定</span>':'<span class="status status-done">已绑定</span>' ?>
                        <a href="javascript:;" data-template="phone-template" class="default-btn br5 phone-btn"><?= empty($userModel->phone)?'绑定':'修改' ?></a>
                    </span>
                </div>
                <div class="setting">
                    <span class="icon"><i class="iconfont jia-mailmessage"></i></span>
                    <span class="title">邮箱设置</span>
                    <span class="content"><?= empty($userModel->email)?'可用于接受优惠邮件或找回登录密码':('已绑定邮箱：'.Util::HidePart($userModel->email)) ?></span>
                    <span class="action">
                        <?= empty($userModel->email)?'<span class="status">未绑定</span>':'<span class="status status-done">已绑定</span>' ?>
                        <a href="javascript:;" data-template="email-template" class="default-btn br5 email-btn"><?= empty($userModel->email)?'绑定':'修改' ?></a>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>