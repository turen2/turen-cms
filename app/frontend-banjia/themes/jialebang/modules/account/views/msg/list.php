<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use app\assets\NotifyAsset;
use common\models\account\Msg;

$this->title = '消息中心';
$this->params['breadcrumbs'][] = $this->title;

NotifyAsset::register($this);
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

//删除
$('.pagination-batch').on('click', '.outline-btn:not(.no-effect):eq(0)', function() {
    var form = $('#centerMsgForm');
    var checked = form.find('td input[type="checkbox"]:checked');
    $.ajax({
        url: form.data('deleteurl'),
        type: form.attr('method'),
        dataType: 'json',
        context: form,
        cache: false,
        data: checked.serializeArray(),
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            $.notify(XMLHttpRequest.responseText, 'error');
        },
        success: function(res) {
            //刷新
            location.reload();
        }
    });
});

//已读
$('.pagination-batch').on('click', '.outline-btn:not(.no-effect):eq(1)', function() {
    var form = $('#centerMsgForm');
    var checked = form.find('td input[type="checkbox"]:checked');
    $.ajax({
        url: form.data('readurl'),
        type: form.attr('method'),
        dataType: 'json',
        context: form,
        cache: false,
        data: checked.serializeArray(),
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            $.notify(XMLHttpRequest.responseText, 'error');
        },
        success: function(res) {
            //将选中的消息置为已读
            $.notify(res.msg, 'success');
            checked.each(function(i) {
                $(this).parent().parent().find('td.read').text('已读');
            });
        }
    });
});

//弹窗查看详情
$('.table-action a.link-primary').on('click', function() {
    var form = $('#centerMsgForm');
    //载入数据
    var type = $(this).data('type');
    var data = $.parseJSON(window.decodeURIComponent($(this).data('msg')));
    var template = $('#msg-detail-tpl');
    
    template.find('.tpl-typename').html($(this).data('typename'));
    template.find('.tpl-date').html($(this).data('date'));
    
    if(type == 1) {//反馈通知类型
        template.find('.tpl-question').show().html(data.question);
        template.find('.tpl-answer').show().html(data.answer);
        template.find('.tpl-content').parent().hide();
    } else {//消息类型
        template.find('.tpl-content').show().html(data.content);
        template.find('.tpl-question').parent().hide();
        template.find('.tpl-answer').parent().hide();
    }
    
    //获取当前对象
    var checked = $(this).parents('tr').find('td input[type="checkbox"]');
    layer.open({
        type: 1,
        title: '消息详情',
        closeBtn: 1,
        shadeClose: true,
        shade: 0.5,
        move: false, //来禁止拖拽
        area: '480px', //宽高//此处只取宽
        skin: 'jia-modal',
        content: $('#msg-detail-tpl'),
        btn: ['关闭'],
        btn1: function(index, layero) { //按钮【按钮一】的回调
            layer.close(index);
        },
        success: function() {
            $.ajax({
                url: form.data('readurl'),
                type: form.attr('method'),
                dataType: 'json',
                context: form,
                cache: false,
                data: {checkid: checked.attr('value')},
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    $.notify(XMLHttpRequest.responseText, 'error');
                },
                success: function(res) {
                    //将选中的消息置为已读
                    checked.each(function(i){
                        $(this).parent().parent().find('td.read').text('已读');
                    });
                }
            });
        }
    });
});
EOF;
$this->registerJs($js);
?>

<div id="msg-detail-tpl" style="display: none;">
    <table class="table table-striped">
        <tbody>
        <tr>
            <td width="25%">消息类型</td>
            <td class="tpl-typename" width="75%"></td>
        </tr>
        <tr>
            <td width="25%">反馈问题</td>
            <td class="tpl-question" width="75%"></td>
        </tr>
        <tr>
            <td width="25%">官方回复</td>
            <td class="tpl-answer" width="75%"></td>
        </tr>
        <tr>
            <td width="25%">消息详情</td>
            <td class="tpl-content" width="75%"></td>
        </tr>
        <tr>
            <td width="25%">发布时间</td>
            <td class="tpl-date" width="75%"></td>
        </tr>
        </tbody>
    </table>
</div>

<div class="user-center">
    <div class="container clearfix">
        <?= $this->render('../_account_sidebox') ?>
        <div class="user-content card info">
            <div class="user-content-head">
                <div class="title"><?= $this->title ?></div>
            </div>
            <div class="user-content-body">
                <?= $this->render('_search', ['model' => $searchModel]); ?>
                <?= $form = Html::beginForm('', 'POST', ['id' => 'centerMsgForm', 'data-deleteurl' => Url::to(['/account/msg/delete']), 'data-readurl' => Url::to(['/account/msg/read'])]) ?>
                <div class="table-responsive">
                    <table class="table" id="tickets-table">
                        <thead>
                            <tr>
                                <th style="width:30px;padding-left: 6px;"><input class="select-all" type="checkbox" name="checkid[]" value=""></th>
                                <th width="10%"><?= $searchModel->getAttributeLabel('msg_type') ?></th>
                                <th><?= $searchModel->getAttributeLabel('msg_content') ?></th>
                                <th><?= $dataProvider->sort->link('created_at', ['label' => $searchModel->getAttributeLabel('created_at')]) ?></th>
                                <th><?= $dataProvider->sort->link('msg_readtime', ['label' => $searchModel->getAttributeLabel('msg_readtime')]) ?></th>
                                <th style="width:86px">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dataProvider->getModels() as $key => $model) { ?>
                            <tr>
                                <td><input type="checkbox" name="checkid[]" value="<?= $model->msg_id ?>"></td>
                                <td><?= Msg::TypeName($model->msg_type) ?></td>
                                <td><?= StringHelper::truncate(Msg::MsgTitle($model->msg_content), 21) ?></td>
                                <td><?= Yii::$app->getFormatter()->asDate($model->created_at) ?></td>
                                <td class="read"><?= $model->msg_readtime?'已读':'未读' ?></td>
                                <td>
                                    <div class="table-action">
                                        <div class="action-item">
                                            <a href="javascript:;" data-type="<?= $model->msg_type ?>" data-typename="<?= Msg::TypeName($model->msg_type) ?>" data-msg="<?= urlencode($model->msg_content) ?>" data-date="<?= Yii::$app->getFormatter()->asDate($model->created_at) ?>" class="link-primary">订单详情</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php } ?>

                            <?php
                            if(empty($dataProvider->count)) {
                                echo '<tr><td colspan="20"><div class="empty" style="padding: 30px 0;text-align: center;">暂无消息记录</div></td></tr>';
                            }
                            ?>

                            <tr class="pagination-batch">
                                <td><input class="select-all" type="checkbox" name="checkid[]" id="checkid[]" value=""></td>
                                <td colspan="5">
                                    <a class="outline-btn br4 no-effect" href="javascript:;">删除选中</a>
                                    <a class="outline-btn br4 no-effect" href="javascript:;">设为已读</a>
                                    <div class="pagination-nav fr clearfix">
                                        <?= LinkPager::widget([
                                            'pagination' => $dataProvider->getPagination(),
                                            'options' => ['class' => 'pagination fr'],
                                            'linkOptions' => ['class' => 'br4'],
                                            'disabledListItemSubTagOptions' => ['class' => 'br4'],
                                            'activePageCssClass' => 'on',
                                            'firstPageLabel' => '首页',
                                            'lastPageLabel' => '尾页',
                                            'nextPageLabel' => '下页',
                                            'prevPageLabel' => '上页',
                                        ]); ?>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <?= Html::endForm() ?>
            </div>
        </div>
    </div>
</div>