<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

$this->title = '第三方登录';
$this->params['breadcrumbs'][] = $this->title;

use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="user-center">
    <div class="container clearfix">
        <?= $this->render('../_account_sidebox', ['route' => 'center']) ?>
        <div class="user-content card info">
            <div class="user-content-head">
                <div class="title"><?= $this->title ?></div>
            </div>
            <div class="user-content-body">
                <div class="setting">
                    <span class="icon"><i class="cd-icon cd-icon-weixin"></i></span>
                    <span class="title">微信登录</span>
                    <span class="action">
                        <span class="status status-done">已绑定</span>
                        <a class="default-btn" href="">取消绑定</a>
                    </span>
                </div>
                <div class="setting">
                    <span class="icon"><i class="cd-icon cd-icon-alipay"></i></span>
                    <span class="title">QQ登录</span>
                    <span class="action">
                        <span class="status">未绑定</span>
                        <a class="default-btn" href="">绑定帐号</a>
                    </span>
                </div>
                <div class="setting">
                    <span class="icon"><i class="cd-icon cd-icon-weixin"></i></span>
                    <span class="title">微博登录</span>
                    <span class="action">
                        <span class="status status-done">已绑定</span>
                        <a class="default-btn" href="">取消绑定</a>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>