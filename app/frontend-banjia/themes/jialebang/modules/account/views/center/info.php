<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use app\assets\Jcrop;use yii\helpers\Html;

$this->title = '基本资料';
$this->params['breadcrumbs'][] = $this->title;

Jcrop::register($this);//图片剪切
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
                    <div class="image-upload">
                        <img class="avatar" id="profile-avatar"src="">
                        <div class="image-upload-mask">
                            <div class="image-upload-content">
                                <i class="icon icon-camera"></i>修改头像
                            </div>
                        </div>
                        <label class="image-upload-label">
                            <input type="file" name="file" />
                        </label>
                        <p class="image-upload-tip">请上传jpg, gif, png格式的图片, 建议图片大小不超过2MB</p>
                    </div>
                    <div class="form-group">
                        <label for="">用户名</label>
                        <input type="text" id="" name="nickname" class="form-control" value="Jorry有桥笨小孩">
                    </div>
                    <div class="form-group">
                        <label for="">真实姓名</label>
                        <input type="text" id="" name="" class="form-control" value="">
                    </div>
                    <div class="form-group">
                        <label>性别</label>
                        <div class="radio-group">
                            <label class="radio " for="">
                                <input type="radio" id="" name="" value="male" data-toggle="radio">男
                            </label>
                            <label class="radio " for="">
                                <input type="radio" id="" name="" value="female" data-toggle="radio">女
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">自我介绍</label>
                        <textarea id="" name="" rows="10" class="form-control"></textarea>
                    </div>
                    <button id="user-center-save-btn" data-loading-text="正在保存..." type="submit" class="btn-primary">保存</button>
                <?= Html::endForm() ?>
            </div>
        </div>
    </div>
</div>