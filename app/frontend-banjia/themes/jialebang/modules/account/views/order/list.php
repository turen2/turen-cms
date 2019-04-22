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
        <div class="user-content card info">
            <div class="user-content-head">
                <div class="title"><?= $this->title ?></div>
            </div>
            <div class="user-content-body">
                <ul class="tabs">
                    <li class="active">
                        <a href="">服务单列表</a>
                    </li>
                    <li>
                        <a href="">已处理</a>
                    </li>
                    <li>
                        <a href="">待处理</a>
                    </li>
                    <li>
                        <a href="">未处理</a>
                    </li>
                </ul>
                <div class="table-responsive">
                    <table class="table" id="orders-table">
                        <thead>
                            <tr>
                                <th style="width: 70px;">服务图片</th>
                                <th width="25%">服务名称</th>
                                <th>服务单号</th>
                                <th class="tr">价格</th>
                                <th>创建时间</th>
                                <th>订单状态</th>
                                <th style="width:86px">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><img src="http://img01.lingdangpet.cn/cms-images/product/2019_03_24/6fb9e5db668cd9c2cd130dd6a34b1128==150x150.png" style="width: 70px;" /> </td>
                                <td>
                                    <a class="link" href="" target="_blank">菜单优化，新餐饮下的一本万利</a>
                                </td>
                                <td>2019041917040584235</td>
                                <td class="tr">24.00  元</td>
                                <td>2019-4-19</td>
                                <td>
                                    <span class="status status-disabled">待处理</span>
                                </td>
                                <td>
                                    <div class="table-action">
                                        <div class="action-item">
                                            <a href="javascript:;" class="link-primary">订单详情</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><img src="http://img01.lingdangpet.cn/cms-images/product/2019_03_24/6fb9e5db668cd9c2cd130dd6a34b1128==150x150.png" style="width: 70px;" /> </td>
                                <td>
                                    <a class="link" href="" target="_blank">菜单优化，新餐饮下的一本万利</a>
                                </td>
                                <td>2019041917040584235</td>
                                <td class="tr">24.00  元</td>
                                <td>2019-4-19</td>
                                <td>
                                    <span class="status status-disabled">已处理</span>
                                </td>
                                <td>
                                    <div class="table-action">
                                        <div class="action-item">
                                            <a href="javascript:;" class="link-primary">订单详情</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><img src="http://img01.lingdangpet.cn/cms-images/product/2019_03_24/6fb9e5db668cd9c2cd130dd6a34b1128==150x150.png" style="width: 70px;" /> </td>
                                <td>
                                    <a class="link" href="" target="_blank">菜单优化，新餐饮下的一本万利</a>
                                </td>
                                <td>2019041917040584235</td>
                                <td class="tr">24.00  元</td>
                                <td>2019-4-19</td>
                                <td>
                                    未处理
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
                <div class="pagination-nav clearfix">
                    <a href="javascript:;" class="default-btn br5">修改</a>
                    <ul class="pagination fr">
                        <li><a class="br4" href="">首页</a></li>
                        <li><a class="br4" href="">上一页</a></li>
                        <li><a class="br4" href="">1</a></li>
                        <li><a class="br4" href="">2</a></li>
                        <li><a class="br4" href="">下一页</a></li>
                        <li><a class="br4" href="">末页</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>