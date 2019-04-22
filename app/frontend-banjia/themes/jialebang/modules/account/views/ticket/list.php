<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

$this->title = '工单管理';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-center">
    <div class="container clearfix">
        <?= $this->render('../_account_sidebox', ['route' => 'ticket']) ?>
        <div class="user-content card info">
            <div class="user-content-head">
                <div class="title"><?= $this->title ?><a href="" class="primary-btn br5 fr">新工单</a></div>
            </div>
            <div class="user-content-body">
                <div class="table-responsive">
                    <table class="table" id="tickets-table">
                        <thead>
                            <tr>
                                <th width="16%">工单编号</th>
                                <th>问题内容</th>
                                <th>价格</th>
                                <th>创建时间</th>
                                <th>订单状态</th>
                                <th style="width:86px">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>190419170425</td>
                                <td>
                                    <a class="link" href="" target="_blank">菜单优化，新餐饮下的一本万利</a>
                                </td>
                                <td class="tr">24.00  元</td>
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
                            <tr>
                                <td>190419170425</td>
                                <td>
                                    <a class="link" href="" target="_blank">菜单优化，新餐饮下的一本万利</a>
                                </td>
                                <td class="tr">24.00  元</td>
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
                            <tr>
                                <td>190419170425</td>
                                <td>
                                    <a class="link" href="" target="_blank">菜单优化，新餐饮下的一本万利</a>
                                </td>
                                <td class="tr">24.00  元</td>
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
                <div class="pagination-nav clearfix">
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