<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

$this->title = '消息中心';
$this->params['breadcrumbs'][] = $this->title;

$js = <<<EOF
$('.select-all').on('click', function() {
    var status = $(this).prop('checked');
    $(this).parents('.table').find("input[type='checkbox']").prop("checked", status);
    if(status && $(this).parents('.table').find("input[type='checkbox']:checked:not('.select-all')").length > 0) {
        $('.pagination-batch .outline-btn').removeClass('no-effect');
    } else {
        $('.pagination-batch .outline-btn').addClass('no-effect');
    }
}).parents('.table').find("input[type='checkbox']").on('click', function() {
    if($(this).parents('.table').find("input[type='checkbox']:checked:not('.select-all')").length > 0) {
        $('.pagination-batch .outline-btn').removeClass('no-effect');
    } else {
        $('.pagination-batch .outline-btn').addClass('no-effect');
    }
});
EOF;
$this->registerJs($js);
?>

<div class="user-center">
    <div class="container clearfix">
        <?= $this->render('../_account_sidebox') ?>
        <div class="user-content card info">
            <div class="user-content-head">
                <div class="title"><?= $this->title ?></div>
            </div>
            <div class="user-content-body">
                <ul class="tabs">
                    <li class="active">
                        <a href="">全部消息</a>
                    </li>
                    <li>
                        <a href="">服务消息</a>
                    </li>
                    <li>
                        <a href="">活动消息</a>
                    </li>
                </ul>
                <div class="table-responsive">
                    <table class="table" id="tickets-table">
                        <thead>
                            <tr>
                                <th style="width:30px;padding-left: 6px;"><input class="select-all" type="checkbox" name="checkid[]" id="checkid[]" value=""></th>
                                <th width="25%">消息名称</th>
                                <th>消息内容</th>
                                <th>发布时间</th>
                                <th>消息类型</th>
                                <th style="width:86px">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="checkbox" name="checkid[]" id="checkid[]" value=""></td>
                                <td>
                                    <a class="link" href="" target="_blank">菜单优化，新餐饮下的一本万利</a>
                                </td>
                                <td>消息内容xxxx xxxxx xxxxx xxxxxx xxxxxx xxxxxxx xxxxx</td>
                                <td>2019-4-19</td>
                                <td>
                                    服务通知
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
                                <td><input type="checkbox" name="checkid[]" id="checkid[]" value=""></td>
                                <td>
                                    <a class="link" href="" target="_blank">菜单优化，新餐饮下的一本万利</a>
                                </td>
                                <td>消息内容xxxx xxxxx xxxxx xxxxxx xxxxxx xxxxxxx xxxxx</td>
                                <td>2019-4-19</td>
                                <td>
                                    服务通知
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
                                <td><input type="checkbox" name="checkid[]" id="checkid[]" value=""></td>
                                <td>
                                    <a class="link" href="" target="_blank">菜单优化，新餐饮下的一本万利</a>
                                </td>
                                <td>消息内容xxxx xxxxx xxxxx xxxxxx xxxxxx xxxxxxx xxxxx</td>
                                <td>2019-4-19</td>
                                <td>
                                    服务通知
                                </td>
                                <td>
                                    <div class="table-action">
                                        <div class="action-item">
                                            <a href="javascript:;" class="link-primary">订单详情</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="pagination-batch">
                                <td><input class="select-all" type="checkbox" name="checkid[]" id="checkid[]" value=""></td>
                                <td>
                                    <a class="outline-btn br4 no-effect" href="javascript:;">删除选中</a>
                                    <a class="outline-btn br4 no-effect" href="javascript:;">设为已读</a>
                                </td>
                                <td colspan="4">
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
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>