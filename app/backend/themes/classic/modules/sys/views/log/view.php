<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->name;
?>

<div class="log-view view-list">
    <div class="tool-list">
        <?= Html::a('<i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> 返回列表', ['index'], ['class' => 'btn']) ?>
    </div>
    <?= DetailView::widget([
        'model' => $model,
        'options' => ['width' => '100%', 'cellpadding' => '0', 'cellspacing' => '0'],
        'template' => '<tr><th class="view-label" {captionOptions}>{label}</th><td class="view-text" {contentOptions}>{value}</td></tr>',
        'attributes' => [
            'log_id',
            'admin_id',
            'admin.username',
            'route',
            'name',
            'method',
            'get_data',
            'post_data',
            'ip',
            'agent',
            'md5',
            'lang',
            'created_at:datetime',
        ],
    ]) ?>
</div>