<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

$this->title = '服务订单';
$this->params['breadcrumbs'][] = $this->title;

use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="user-center">
    <div class="container clearfix">
        <?= $this->render('../_account_sidebox', ['route' => 'center']) ?>
        <div class="user-content info">
            <div class="user-content-head">
                <div class="title"><?= $this->title ?></div>
            </div>
            <div class="user-content-body">
                <ul class="cd-tabs">
                    <li class="active">
                        <a href="">订单列表</a>
                    </li>
                    <li>
                        <a href="">退款管理</a>
                    </li>
                </ul>
                <?= Html::beginForm(Url::to([]), 'get', ['class' => 'form-inline']) ?>
                <div class="form-group">
                    <input name="q" type="text" value="" class="form-control" placeholder="输入商品名称搜索" />
                    <button type="submit"><i class="cd-icon cd-icon-search"></i></button>
                </div>
                <?= Html::endForm() ?>
                <div class="table-responsive">
                    <table class="table" id="orders-table">
                        <thead>
                            <tr>
                                <th width="25%">商品名称</th>
                                <th>订单号</th>
                                <th class="text-right">订单价格</th>
                                <th>创建时间</th>
                                <th>订单状态</th>
                                <th style="width:100px">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <a class="link" href="" target="_blank">菜单优化，新餐饮下的一本万利</a>
                                </td>
                                <td>2019041917040584235</td>
                                <td class="text-right">24.00  元</td>
                                <td>2019-4-19</td>
                                <td>
                                    <span class="status status-disabled">交易关闭</span>
                                </td>
                                <td>
                                    <div class="table-action">
                                        <div class="action-item">
                                            <a href="javascript:;" class="link-primary">订单详情</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>