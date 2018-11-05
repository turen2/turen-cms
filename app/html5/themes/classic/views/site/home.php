<?php 
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '首页 - '.Yii::$app->params['config_site_name'];

$webUrl = Yii::getAlias('@web');
?>

<div class="headinfo">
    <div class="userinfo">
        <div class="tui-list external" href="">
            <div class="tui-list-media"><img src="<?=$webUrl?>/images/logo.jpg"></div>
            <div class="tui-list-info">
                <div class="title">豹品云淘官方商城</div>
                <div class="text">豹品云淘，一个专注于全球优品分销的大众创业平台。</div>
            </div>
        </div>
        <a class="setbtn" href=""><i class="icon icon-settings"></i></a>
    </div>
</div>
<div class="tui-menu-group">
    <a class="tui-menu-item noactive">
        <p id="today_count">1</p>
        <small>今日订单</small>
    </a>
    <a class="tui-menu-item noactive">
        <p id="today_price">78</p>
        <small>今日成交</small>
    </a>
    <a class="tui-menu-item noactive">
        <p id="today_member">2</p>
        <small>新增会员</small>
    </a>
</div>
<div class="tui-cell-group">
    <a class="tui-cell external" href="">
        <div class="tui-cell-icon">
            <i class="icon icon-rejectedorder"></i>
        </div>
        <div class="tui-cell-text">订单管理</div>
        <div class="tui-cell-remark">全部</div></a>
</div>
<div class="tui-block-group col-3">
    <a class="tui-block-child" href="">
        <div class="icon text-blue">
            <i class="icon icon-deliver"></i>
        </div>
        <div class="title">待发货</div>
        <div class="text"><span id="status_1">40</span>单</div>
    </a>
    <a class="tui-block-child" href="">
        <div class="icon text-yellow">
            <i class="icon icon-dollar"></i>
        </div>
        <div class="title">待付款</div>
        <div class="text"><span id="status_0">189</span>笔</div>
    </a>
    <a class="tui-block-child" href="">
        <div class="icon text-orange">
            <i class="icon icon-rejectedorder"></i>
        </div>
        <div class="title">维权订单</div>
        <div class="text"><span id="status_4">20</span>笔</div>
    </a>
</div>
<div class="tui-cell-group">
    <div class="tui-cell">
        <div class="tui-cell-icon">
            <i class="icon icon-shop"></i>
        </div>
        <div class="tui-cell-text">商城管理</div></div>
</div>
<div class="tui-block-group col-3">
    <a class="tui-block-child" href="">
        <div class="icon text-yellow">
            <i class="icon icon-goods"></i>
        </div>
        <div class="title">商品管理</div>
        <div class="text">
            <span id="goods_count">955</span>个
        </div>
    </a>
    <a class="tui-block-child" href="">
        <div class="icon text-orange">
            <i class="icon icon-group"></i>
        </div>
        <div class="title">会员管理</div>
        <div class="text">
            <span id="member_count">44747</span>个
        </div>
    </a>
    <a class="tui-block-child" href="">
        <div class="icon text-blue">
            <i class="icon icon-recharge"></i>
        </div>
        <div class="title">财务管理</div>
        <div class="text"></div>
    </a>
    <a class="tui-block-child" href="">
        <div class="icon text-orange">
            <i class="icon icon-goods1"></i>
        </div>
        <div class="title">营销设置</div>
        <div class="text"></div>
    </a>
    <a class="tui-block-child" href="">
        <div class="icon text-blue">
            <i class="icon icon-rank"></i>
        </div>
        <div class="title">数据统计</div>
        <div class="text"></div>
    </a>
    <a class="tui-block-child" href="">
        <div class="icon text-orange">
            <i class="icon icon-shop"></i>
        </div>
        <div class="title">店铺设置</div>
        <div class="text"></div>
    </a>
</div>