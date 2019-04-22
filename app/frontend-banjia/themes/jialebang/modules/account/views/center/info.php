<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use app\assets\Jcrop;
use common\models\user\User;
use yii\helpers\Html;

$this->title = '基本资料';
$this->params['breadcrumbs'][] = $this->title;

Jcrop::register($this);//图片剪切
$js = <<<EOF
$('#profile-avatar').on('mouseover', function() {
    $('.image-upload-mask').removeClass('hide');
});
$('.image-upload-mask').on('mouseleave', function() {
    $(this).addClass('hide');
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
                <?= $form = Html::beginForm() ?>
                    <div class="form-group image-upload">
                        <img class="avatar br4" id="profile-avatar"src="https://xue.koubei.com/files/default/2019/04-19/162933d392fa460322.jpg" />
                        <div class="image-upload-mask br4 hide">
                            <div class="image-upload-text">
                                <i class="icon icon-camera"></i>修改头像
                            </div>
                        </div>
                        <?= Html::activeFileInput($model, 'avatar',  ['class' => 'form-control text hide']) ?>
                        <p class="image-upload-tip">请上传jpg, gif, png格式的图片, 建议图片大小不超过2MB</p>
                    </div>
                    <div class="form-group">
                        <label for=""><?= Html::activeLabel($model, 'username') ?></label>
                        <?= Html::activeTextInput($model, 'username',  ['class' => 'form-control text']) ?>
                    </div>
                    <div class="form-group">
                        <label><?= Html::activeLabel($model, 'sex') ?></label>
                        <?= Html::activeRadioList($model, 'sex', [0 => '女性', 1 => '男性'], ['class' => 'form-control radio', 'separator' => '&nbsp;&nbsp;']) ?>
                    </div>
                    <div class="form-group">
                        <label><?= Html::activeLabel($model, 'intro') ?></label>
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