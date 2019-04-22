<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

$this->title = '账户安全';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-center">
    <div class="container clearfix">
        <?= $this->render('../_account_sidebox', ['route' => 'center']) ?>
        <div class="user-content card info">
            <div class="user-content-head">
                <div class="title"><?= $this->title ?></div>
            </div>
            <div class="user-content-body">
                <div class="safe-info">
                    <div class="security">
                        <span class="icon"><i class="cd-icon cd-icon-warning"></i></span>
                        <span class="title">安全等级</span>
                        <span class="progress done"></span>
                        <span class="progress done"></span>
                        <span class="progress"></span>
                        <span class="level">中</span>
                    </div>
                    <div class="safe-setting">
                        <span class="icon"><i class="cd-icon cd-icon-lock"></i></span>
                        <span class="title">登录密码</span>
                        <span class="content">经常更改密码有助于保护您的帐号安全</span>
                        <span class="action">
                            <span class="status status-done">已设置</span>
                            <a href="javascript:;" class="default-btn br5">修改</a>
                      </span>
                    </div>
                    <div class="safe-setting">
                        <span class="icon"><i class="cd-icon cd-icon-payment"></i></span>
                        <span class="title">支付密码</span>
                        <span class="content">用于支付时的二次密码校验，加强账户安全性</span>
                        <span class="action">
                        <span class="status">未设置</span>
                            <a href="javascript:;" class="default-btn br5">设置</a>
                        </span>
                    </div>
                    <div class="safe-setting">
                        <span class="icon"><i class="cd-icon cd-icon-safe"></i></span>
                        <span class="title">安全问题</span>
                        <span class="content">设置安全问题，保护帐号密码安全，也可用于找回支付密码</span>
                        <span class="action">
                            <span class="status">未设置</span>
                            <a href="javascript:;" class="default-btn br5">设置</a>
                        </span>
                    </div>
                    <div class="safe-setting">
                        <span class="icon"><i class="cd-icon cd-icon-iphone"></i></span>
                        <span class="title">手机绑定</span>
                        <span class="content">已绑定手机：137****4524</span>
                        <span class="action">
                            <span class="status status-done">已绑定</span>
                            <a href="javascript:;" class="default-btn br5">修改</a>
                        </span>
                    </div>
                    <div class="safe-setting">
                        <span class="icon"><i class="cd-icon cd-icon-email"></i></span>
                        <span class="title">邮箱设置</span>
                        <span class="content">可用于找回登录密码</span>
                        <span class="action">
                            <span class="status">未设置</span>
                            <a href="javascript:;" class="default-btn br5">绑定</a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>