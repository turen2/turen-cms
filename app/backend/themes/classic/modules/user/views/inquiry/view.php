<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\widgets\DetailView;
use backend\assets\NotifyAsset;
use backend\models\user\Inquiry;

$this->title = $model->ui_title;
NotifyAsset::register($this);

$url = Url::to(['inquiry/edit', 'id' => $model->ui_id]);
$js = <<<EOF
$('#inquiry-ui_answer').on('blur', function() {
    $.ajax({
        url: '{$url}',
		type: "POST",
		dataType: 'json',
		context: $(this),
		data: {field: $(this).data('field'), time_field: $(this).data('time_field'), value: $(this).val()},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
            $.notify(XMLHttpRequest.responseText, 'error');
        },
		success: function(res) {
		    $.notify(res['msg'], 'success');
		}
	});
});
$('#inquiry-ui_remark').on('blur', function() {
    $.ajax({
        url: '{$url}',
		type: "POST",
		dataType: 'json',
		context: $(this),
		data: {field: $(this).data('field'), time_field: $(this).data('time_field'), value: $(this).val()},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
            $.notify(XMLHttpRequest.responseText, 'error');
        },
		success: function(res) {
		    $.notify(res['msg'], 'success');
		}
	});
});
$('#inquiry-ui_state').on('change', function() {
    $.ajax({
        url: '{$url}',
		type: "POST",
		dataType: 'json',
		context: $(this),
		data: {field: $(this).data('field'), value: $(this).val()},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
            $.notify(XMLHttpRequest.responseText, 'error');
        },
		success: function(res) {
		    $.notify(res['msg'], 'success');
		}
	});
});
EOF;
$this->registerJs($js);
?>

<div class="inquiry-view view-list">
    <div class="tool-list">
        <?= Html::a('<i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> 返回列表', ['index'], ['class' => 'btn']) ?>
    </div>
    <?= DetailView::widget([
        'model' => $model,
        'options' => ['width' => '100%', 'cellpadding' => '0', 'cellspacing' => '0'],
        'template' => '<tr><th class="view-label" {captionOptions}>{label}</th><td class="view-text" {contentOptions}>{value}</td></tr>',
        'attributes' => [
            'ui_title',
            [
                'attribute' => 'ui_content',//可以直接联表
                //'label' => '',//修改label标签
                'value' => function($model, $_this) {
                    if(!empty($model->ui_content)) {
                        $content = '';
                        foreach (Json::decode($model->ui_content) as $label => $name) {
                            $content .= $label.' : '.$name.'<br />';
                        }
                        return $content;
                    }
                },//匿名函数获取值
                'format' => 'html',//指定格式化
                'contentOptions' => [],
                'captionOptions' => [],
                'status' => true,//是否显示
            ],
            'user.username',
            [
                'attribute' => 'ui_answer',//可以直接联表
                'value' => function($model, $_this) {
                    return Html::activeTextarea($model, 'ui_answer', ['data-field' => 'ui_answer', 'data-time_field' => 'ui_answer_time']);
                },
                'format' => 'raw',//指定格式化
            ],
            [
                'attribute' => 'ui_answer_time',//可以直接联表
                'value' => function($model, $_this) {
                    if(empty($model->ui_answer_time)) {
                        return '未回复';
                    } else {
                        return Yii::$app->getFormatter()->asDatetime($model->ui_answer_time);
                    }
                }
            ],
            [
                'attribute' => 'ui_remark',//可以直接联表
                'value' => function($model, $_this) {
                    return Html::activeTextarea($model, 'ui_remark', ['data-field' => 'ui_remark', 'data-time_field' => 'ui_remark_time']);
                },
                'format' => 'raw',//指定格式化
            ],
            [
                'attribute' => 'ui_remark_time',//可以直接联表
                'value' => function($model, $_this) {
                    if(empty($model->ui_remark_time)) {
                        return '未备注';
                    } else {
                        return Yii::$app->getFormatter()->asDatetime($model->ui_remark_time);
                    }
                }
            ],
            [
                'attribute' => 'ui_type',//可以直接联表
                'value' => function($model, $_this) {
                    return $model->getTypeName();
                },
            ],
            [
                'attribute' => 'ui_state',//可以直接联表
                'value' => function($model, $_this) {
                    return Html::activeDropDownList($model, 'ui_state', Inquiry::getStateNameList(), ['data-field' => 'ui_state']);
                },
                'format' => 'raw',//指定格式化
            ],
            'ui_submit_time:datetime',
            'ui_ipaddress',
            'ui_browser:ntext',
        ],
    ]) ?>
</div>