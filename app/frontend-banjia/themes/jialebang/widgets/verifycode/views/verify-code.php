<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 * Date: 2019/1/15
 * Time: 12:35
 */
use yii\captcha\Captcha;
?>

<div id="<?= $templateId ?>" style="display: none;">
    <div class="verify-code-form" data-url="<?= $url; ?>">
        <h3>验证码</h3>
        <div class="verify-item clearfix">
            <?= Captcha::widget([
                'name' => 'captcha',
                'captchaAction' => '/account/user/captcha',
                'imageOptions' => ['title' => '点击刷新', 'alt' => '验证码', 'style' => 'cursor: pointer;'],
                'template' => '<div class="input">{input}</div><div class="image">{image}</div><span class="tips">点击图片刷新</span>',
            ]); ?>
            <span class="help"></span>
        </div>
        <a href="javascript:;" class="submit-now">确认</a>
    </div>
</div>