<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use app\assets\LayerAsset;
use app\assets\NotifyAsset;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '账户安全';
$this->params['breadcrumbs'][] = $this->title;

LayerAsset::register($this);
NotifyAsset::register($this);

$js = <<<EOF
$.notify.defaults({
    autoHideDelay: 2000,
    showDuration: 400,
    hideDuration: 200,
    globalPosition: 'top center'
});

$('.setting a.default-btn').on('click', function() {
    var template = $(this).data('template');
    var url = $(this).data('url');
    var name = $(this).parents('.setting').find('.title').text();
    layer.open({
        type: 1,
        title: name,
        closeBtn: 1,
        shadeClose: true,
        shade: 0.5,
        area: '480px', //宽高//此处只取宽
        skin: 'jia-modal',
        content: $('#'+template),
        btn: ['取消', '提交'],
        btn1: function(index, layero) { //按钮【按钮一】的回调
            layer.close(index);
        },
        btn2: function(index, layero) { //按钮【按钮二】的回调
            layer.close(index);
            //ajax提交
            $.ajax({
                url: url,
                type: 'POST',
                async: true,//异步请求
                dataType: 'html',
                context: $(this),
                cache: false,
                data: $('#'+template).find('input').serializeArray(),//系列化所有表单数据
                success: function(res) {
                    //
                }
            });
            $.notify('修改成功！', 'success');
        }
    });
});
EOF;
$this->registerJs($js);
?>
<div id="password-template" style="display: none;">
    <?= Html::beginForm() ?>
        <div class="form-group">
            <?= Html::activeLabel($model, 'currentPassword') ?>
            <?= Html::activeTextInput($model, 'currentPassword',  ['class' => 'form-control text']) ?>
        </div>
        <div class="form-group">
            <?= Html::activeLabel($model, 'password') ?>
            <?= Html::activeTextInput($model, 'password',  ['class' => 'form-control text']) ?>
        </div>
        <div class="form-group cd-mb24">
            <?= Html::activeLabel($model, 'rePassword') ?>
            <?= Html::activeTextInput($model, 'rePassword',  ['class' => 'form-control text']) ?>
        </div>
    <?= Html::endForm() ?>
</div>
<div id="question-template" style="display: none;">bbbbbbbbbbbbb</div>
<div id="phone-template" style="display: none;">ccccccccccccc</div>
<div id="email-template" style="display: none;">ddddddddddddd</div>

<div class="user-center">
    <div class="container clearfix">
        <?= $this->render('../_account_sidebox', ['route' => 'center']) ?>
        <div class="user-content card info">
            <div class="user-content-head">
                <div class="title"><?= $this->title ?></div>
            </div>
            <div class="user-content-body">
                <div class="security warning">
                    <span class="icon"><i class="iconfont jia-caution_b"></i></span>
                    <span class="title">安全等级</span>
                    <span class="progress done"></span>
                    <span class="progress done"></span>
                    <span class="progress"></span>
                    <span class="level">中</span>
                </div>
                <div class="setting">
                    <span class="icon"><i class="iconfont jia-lock"></i></span>
                    <span class="title">登录密码</span>
                    <span class="content">经常更改密码有助于保护您的帐号安全</span>
                    <span class="action">
                        <span class="status status-done">已设置</span>
                        <a href="javascript:;" data-url="<?= Url::to(['/account/safe/update-password']) ?>" data-template="password-template" class="default-btn br5 password-btn">修改</a>
                  </span>
                </div>
                <div class="setting">
                    <span class="icon"><i class="iconfont jia-securityguarantee"></i></span>
                    <span class="title">安全问题</span>
                    <span class="content">设置安全问题，保护帐号密码安全，也可用于找回支付密码</span>
                    <span class="action">
                        <span class="status">未设置</span>
                        <a href="javascript:;" data-url="<?= Url::to(['/account/safe/safe-question']) ?>" data-template="question-template" class="default-btn br5 question-btn">设置</a>
                    </span>
                </div>
                <div class="setting">
                    <span class="icon"><i class="iconfont jia-Phone"></i></span>
                    <span class="title">手机绑定</span>
                    <span class="content">已绑定手机：137****4524</span>
                    <span class="action">
                        <span class="status status-done">已绑定</span>
                        <a href="javascript:;" data-url="<?= Url::to(['/account/safe/bind-phone']) ?>" data-template="phone-template" class="default-btn br5 phone-btn">修改</a>
                    </span>
                </div>
                <div class="setting">
                    <span class="icon"><i class="iconfont jia-mailmessage"></i></span>
                    <span class="title">邮箱设置</span>
                    <span class="content">可用于找回登录密码</span>
                    <span class="action">
                        <span class="status">未设置</span>
                        <a href="javascript:;" data-url="<?= Url::to(['/account/safe/bind-email']) ?>" data-template="email-template" class="default-btn br5 email-btn">绑定</a>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>