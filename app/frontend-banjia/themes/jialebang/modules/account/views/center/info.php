<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use yii\helpers\Html;
use app\assets\Jcrop;
use app\assets\ValidationAsset;

$this->title = '基本资料';
$this->params['breadcrumbs'][] = $this->title;

Jcrop::register($this);//图片剪切
ValidationAsset::register($this);

$js = <<<EOF
$('#profile-avatar').on('mouseover', function() {
    $('.image-upload-mask').removeClass('hide');
});
$('.image-upload-mask').on('mouseleave', function() {
    $(this).addClass('hide');
});

//验证提示效果
var validator = $('#centerInfoForm').validate({
	rules: {
        "InfoForm[username]": {
            "required": true
        },
        "InfoForm[avatar]": {
            "required": true
        },
        "InfoForm[sex]": {//不能为空，而且还必须正确
            "required": true
        }
    },
	messages: {
	    "InfoForm[username]": {
            "required": '<i class="iconfont jia-close_b"></i>用户名必填'
        },
        "InfoForm[avatar]": {
            "required": '<i class="iconfont jia-close_b"></i>用户头像必填'
        },
        "InfoForm[sex]": {
            "required": '<i class="iconfont jia-close_b"></i>性别必填'
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
        <?= $this->render('../_account_sidebox', ['route' => 'center']) ?>
        <div class="user-content card info">
            <div class="user-content-head">
                <div class="title"><?= $this->title ?></div>
            </div>
            <div class="user-content-body">
                <?= $this->render('../_alert') ?>
                <?= $form = Html::beginForm('', 'POST', ['id' => 'centerInfoForm']) ?>
                    <div class="form-group image-upload">
                        <img class="avatar br4" id="profile-avatar"src="https://xue.koubei.com/files/default/2019/04-19/162933d392fa460322.jpg" />
                        <div class="image-upload-mask br4 hide">
                            <div class="image-upload-text"><i class="iconfont jia-camera"></i> 修改头像</div>
                        </div>
                        <?= Html::activeFileInput($model, 'avatar',  ['class' => 'form-control text']) ?>
                        <p class="image-upload-tip">请上传jpg, gif, png格式的图片, 建议图片大小不超过2MB</p>
                    </div>
                    <div class="form-group">
                        <?= Html::activeLabel($model, 'username') ?>
                        <?= Html::activeTextInput($model, 'username',  ['class' => 'form-control text']) ?>
                    </div>
                    <div class="form-group">
                        <?= Html::activeLabel($model, 'sex') ?>
                        <?= Html::activeRadioList($model, 'sex', [0 => '女性', 1 => '男性'], ['class' => 'form-control radio', 'separator' => '&nbsp;&nbsp;']) ?>
                    </div>
                    <div class="form-group">
                        <?= Html::activeLabel($model, 'intro') ?>
                        <?= Html::activeTextarea($model, 'intro', ['class' => 'form-control textarea']) ?>
                    </div>
                    <div class="form-group">
                        <button id="user-center-save-btn" data-loading-text="正在保存..." type="submit" class="primary-btn br5">保存</button>
                    </div>
                <?= Html::endForm() ?>
            </div>
        </div>
    </div>
</div>