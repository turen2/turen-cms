<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 * Date: 2019/1/15
 * Time: 12:35
 */
?>
<div id="<?= $templateId ?>" style="display: none;">
    <div class="verifycode-form">
        <h3>请校验手机验证码</h3>
        <div class="form-items">
            <div class="items clearfix">
                <label for="verifycode-name" class="fl">您的称呼 : <span>*</span></label>
                <div class="fl">
                    <input type="text" id="verifycode-name" name="name" placeholder="请输入您的称呼" />
                </div>
            </div>
            <span class="cue"></span>
        </div>
        <div class="form-items">
            <div class="items clearfix">
                <label for="verifycode-phone" class="fl">手机号码 : <span>*</span></label>
                <div class="fl">
                    <input type="text" id="verifycode-phone" name="phone" placeholder="填写手机号码" />
                </div>
            </div>
            <span class="cue"></span>
        </div>
        <div class="form-items">
            <div class="items clearfix">
                <label for="verifycode-code" class="fl">手机验证码 : <span>*</span></label>
                <div class="fl">
                    <input type="text" id="verifycode-code" name="code" placeholder="手机验证码" />
                </div>
                <span id="get-verifycode" class="verifycode-btn">获取验证码</span>
            </div>
            <span class="cue"></span>
        </div>
        <div class="refer clearfix">
            <a href="javascript:;" class="submit-now">马上提交</a>
        </div>
    </div>
</div>