<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

$this->title = '工单管理';
$this->params['breadcrumbs'][] = $this->title;

use common\models\account\Ticket;
use yii\helpers\Url;
use yii\widgets\LinkPager;
?>

<div class="user-center">
    <div class="container clearfix">
        <?= $this->render('../_account_sidebox') ?>
        <div class="user-content card info">
            <div class="user-content-head">
                <div class="title"><?= $this->title ?><a href="<?= Url::to(['/account/ticket/create']) ?>" class="primary-btn br5 fr">新工单</a></div>
            </div>
            <div class="user-content-body">
                <div class="table-responsive">
                    <table class="table" id="tickets-table">
                        <thead>
                            <tr>
                                <th width="16%"><?= $dataProvider->sort->link('t_ticket_num', ['label' => $searchModel->getAttributeLabel('t_ticket_num')]) ?></th>
                                <th width="40%"><?= $searchModel->getAttributeLabel('t_title') ?></th>
                                <th><?= $dataProvider->sort->link('created_at', ['label' => $searchModel->getAttributeLabel('created_at')]) ?></th>
                                <th><?= $searchModel->getAttributeLabel('t_status') ?></th>
                                <th style="width:86px">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dataProvider->getModels() as $key => $model) { ?>
                            <tr>
                                <td><?= $model->t_ticket_num ?></td>
                                <td><?= $model->t_title ?></td>
                                <td><?= Yii::$app->getFormatter()->asDate($model->created_at) ?></td>
                                <td>
                                    <span class="status status-disabled"><?= Ticket::StatusName($model->t_status) ?></span>
                                </td>
                                <td>
                                    <div class="table-action">
                                        <div class="action-item">
                                            <a href="<?= Url::to(['/account/ticket/detail', 'id' => $model->t_id]) ?>" class="link-primary">工单详情</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="pagination-nav clearfix">
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
            </div>
        </div>
    </div>
</div>