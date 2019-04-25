<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

$this->title = '服务订单';
$this->params['breadcrumbs'][] = $this->title;

use yii\helpers\Url;
use app\assets\LayerAsset;
use yii\widgets\LinkPager;
use app\assets\NotifyAsset;
use common\models\user\Inquiry;
use common\helpers\ImageHelper;

LayerAsset::register($this);
NotifyAsset::register($this);

$js = <<<EOF
$.notify.defaults({
    autoHideDelay: 2000,
    showDuration: 400,
    hideDuration: 200,
    globalPosition: 'top center'
});

$('.link-pop').on('click', function() {
    var html = '';
    //同步ajax
    $.ajax({
        url: $(this).data('url'),
        type: 'GET',
        async: false,//使用同步请求，锁住浏览器
        dataType: 'html',
        context: $(this),
        cache: false,
        data: {},
        success: function(res) {
            html = res;
        }
    });
    
    layer.open({
        type: 1,
        title: '服务详情',
        closeBtn: 1,
        shadeClose: true,
        shade: 0.5,
        move: false, //来禁止拖拽
        area: '480px', //宽高//此处只取宽
        skin: 'jia-modal',
        content: html,
        btn: ['关闭'],
        btn1: function(index, layero) { //按钮【按钮一】的回调
            layer.close(index);
        }
    });
});

EOF;
$this->registerJs($js);
?>

<?php //$this->render('_search', ['model' => $searchModel]); ?>
<div class="user-center">
    <div class="container clearfix">
        <?= $this->render('../_account_sidebox') ?>
        <div class="user-content card info">
            <div class="user-content-head">
                <div class="title"><?= $this->title ?></div>
            </div>
            <div class="user-content-body">
                <ul class="tabs">
                    <li class="<?= empty($searchModel->ui_state)?'active':'' ?>">
                        <a href="<?= Url::current(['state' => null]) ?>">服务单列表</a>
                    </li>
                    <li class="<?= ($searchModel->ui_state == Inquiry::INQUIRY_STATE_OK)?'active':'' ?>">
                        <a href="<?= Url::current(['state' => Inquiry::INQUIRY_STATE_OK]) ?>">已处理</a>
                    </li>
                    <li class="<?= ($searchModel->ui_state == Inquiry::INQUIRY_STATE_WAITING)?'active':'' ?>">
                        <a href="<?= Url::current(['state' => Inquiry::INQUIRY_STATE_WAITING]) ?>">待处理</a>
                    </li>
                    <li class="<?= ($searchModel->ui_state == Inquiry::INQUIRY_STATE_NOTHING)?'active':'' ?>">
                        <a href="<?= Url::current(['state' => Inquiry::INQUIRY_STATE_NOTHING]) ?>">未处理</a>
                    </li>
                </ul>
                <div class="table-responsive">
                    <table class="table" id="orders-table">
                        <thead>
                            <tr>
                                <th style="width: 100px;">服务图片</th>
                                <th width="20%">服务项目</th>
                                <th><?= $dataProvider->sort->link('ui_service_num', ['label' => '服务单号']) ?></th>
                                <th><?= $dataProvider->sort->link('ui_submit_time', ['label' => '创建时间']) ?></th>
                                <th><?= $dataProvider->sort->link('ui_state', ['label' => '状态']) ?></th>
                                <th style="width:86px">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dataProvider->getModels() as $key => $model) { ?>
                            <tr>
                                <td><img src="<?= empty($model->ui_picurl)?ImageHelper::getNopic():Yii::$app->aliyunoss->getObjectUrl($model->ui_picurl, true) ?>" style="height: 60px;" /> </td>

                                <td><?= $model->ui_title ?></td>
                                <td><?= $model->ui_service_num ?></td>
                                <td><?= Yii::$app->getFormatter()->asDate($model->ui_submit_time, 'Y-m-d') ?></td>
                                <td>
                                    <span class="status status-disabled"><?= $model->getStateName() ?></span>
                                </td>
                                <td>
                                    <div class="table-action">
                                        <div class="action-item">
                                            <a href="javascript:;" data-url="<?= Url::to(['/account/order/detail', 'id' => $model->ui_id]) ?>" class="link-pop">订单详情</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php } ?>

                            <?php if(empty($dataProvider->count)) { ?>
                                <tr>
                                    <td colspan="6" class="empty">暂时没有相关的记录</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="pagination-nav clearfix">
                    <?= LinkPager::widget([
                        'pagination' => $dataProvider->getPagination(),
                        'options' => ['class' => 'pagination fr', 'tag' => 'ul'],
                        'activePageCssClass' => 'on',
                        'firstPageLabel' => '首页',
                        'lastPageLabel' => '尾页',
                        'nextPageLabel' => '下页',
                        'prevPageLabel' => '上页',
                        'linkContainerOptions' => ['tag' => 'li'],
                        'linkOptions' => ['class' => 'br4'],
                        'disabledListItemSubTagOptions' => ['class' => 'br4'],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>