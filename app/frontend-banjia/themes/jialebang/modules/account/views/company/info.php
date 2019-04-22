<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

$this->title = '企业资质';
$this->params['breadcrumbs'][] = $this->title;

use yii\helpers\Html; ?>

<div class="user-center">
    <div class="container clearfix">
        <?= $this->render('../_account_sidebox', ['route' => 'center']) ?>
        <div class="user-content card info">
            <div class="user-content-head">
                <div class="title"><?= $this->title ?></div>
            </div>
            <div class="user-content-body">
                <?= $form = Html::beginForm() ?>
                <div class="alert alert-warning">
                    为保护您的帐号安全、获得更好的服务和优惠，请完成公司认证。
                </div>
                <div class="form-group">
                    <label for=""><?= Html::activeLabel($model, 'company_name') ?></label>
                    <?= Html::activeTextInput($model, 'company_name',  ['class' => 'form-control text']) ?>
                </div>
                <div class="form-group">
                    <label><?= Html::activeLabel($model, 'company') ?></label>
                    <?= Html::activeFileInput($model, 'company',  ['class' => 'form-control text hide']) ?>
                    <div class="company-card br4">
                        <div class="card-icon">
                            <i class="cd-icon cd-icon-id-front"></i>
                        </div>
                        <div class="card-title">上传公司营业执照</div>
                    </div>
                    <p class="image-upload-tip">请上传jpg, gif, png格式的图片, 建议图片大小不超过2MB</p>
                </div>
                <div class="form-group">
                    <div class="dark-title">认证须知</div>
                    <div class="dark-list">
                        <p>
                            1、请确保身份证照片清晰可认，严禁PS，否则将由您本人承担相应的法律后果。<br>
                            2、实名认证成功后，将无法修改和删除实名信息，请谨慎填写。<br>
                            3、我们将尽快审核您提交的信息，处理完成后您将会收到系统通知。
                        </p>
                    </div>
                </div>
                <div class="form-group">
                    <button id="user-center-save-btn" data-loading-text="正在保存..." type="submit" class="primary-btn br5">保存</button>
                </div>
                <?= Html::endForm() ?>
            </div>
        </div>
    </div>
</div>