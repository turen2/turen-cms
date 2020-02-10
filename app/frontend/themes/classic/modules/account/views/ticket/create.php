<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\ValidationAsset;

$this->title = '提交工单';

ValidationAsset::register($this);

$js = <<<EOF
//验证提示效果
var validator = $('#ticketCreateForm').validate({
	rules: {
	    "Ticket[t_relate_id]": {
            "required": true
        },
        "Ticket[t_title]": {
            "required": true,
            "maxlength": 200
        },
        "Ticket[t_phone]": {
            "isPhone": true
        },
        "Ticket[t_email]": {//不能为空，而且还必须正确
            "email": true
        }
    },
	messages: {
	    "Ticket[t_relate_id]": {
            "required": '<i class="iconfont jia-close_b"></i>服务单号必填'
        },
	    "Ticket[t_title]": {
            "required": '<i class="iconfont jia-close_b"></i>工单主题必填',
            "maxlength": '<i class="iconfont jia-close_b"></i>工单主题不能超过200个字'
        },
        "Ticket[t_phone]": {
            "isPhone": '<i class="iconfont jia-close_b"></i>接收短信通知的手机号码格式错误'
        },
        "Ticket[t_email]": {
            "email": '<i class="iconfont jia-close_b"></i>接收邮件通知的邮箱地址格式错误'
        }
    },
    errorElement: 'p',
	errorPlacement: function(error, element) {
		error.appendTo(element.parent());
	},
	submitHandler: function(form) {
        //form.submit();
        return true;
    }
});
EOF;
$this->registerJs($js);
?>
<div class="user-center">
    <div class="container clearfix">
        <?= $this->render('../_account_sidebox') ?>
        <div class="user-content card info">
            <div class="user-content-head">
                <div class="title"><?= $this->title ?><a href="<?= Url::to(['/account/ticket/list']) ?>" class="primary-btn br5 fr">返回列表</a></div>
            </div>
            <div class="user-content-body">
                <?= $this->render('../_alert') ?>
                <div class="alert alert-warning">
                    操作流程：选择要反馈的服务单 -> 详情描述问题 -> 填写接收消息的手机号或者邮箱 -> 提交等待，即可
                </div>
                <?= $form = Html::beginForm('', 'POST', ['id' => 'ticketCreateForm', 'class' => 'ticket-form']) ?>
                <div class="form-group">
                    <?= Html::activeLabel($model, 't_relate_id') ?>
                    <?= Html::activeTextInput($model, 't_relate_id',  ['class' => 'form-control text']) ?>
                </div>
                <div class="form-group">
                    <?= Html::activeLabel($model, 't_title') ?>
                    <?= Html::activeTextarea($model, 't_title', ['class' => 'form-control textarea']) ?>
                </div>
                <div class="form-group">
                    <?= Html::activeLabel($model, 't_files') ?>
                    <?= Html::activeTextInput($model, 't_files',  ['class' => 'form-control text']) ?>
                </div>
                <div class="form-group">
                    <?= Html::activeLabel($model, 't_phone') ?>
                    <?= Html::activeTextInput($model, 't_phone',  ['class' => 'form-control text']) ?>
                </div>
                <div class="form-group">
                    <?= Html::activeLabel($model, 't_email') ?>
                    <?= Html::activeTextInput($model, 't_email',  ['class' => 'form-control text']) ?>
                </div>
                <div class="form-group">
                    <button id="user-ticket-save-btn" data-loading-text="正在保存..." type="submit" class="primary-btn br5">提交</button>
                </div>
                <?= Html::endForm() ?>
            </div>
        </div>
    </div>
</div>
