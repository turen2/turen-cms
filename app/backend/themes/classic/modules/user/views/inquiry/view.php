<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model app\models\user\Inquiry */

$this->title = $model->ui_title;
$this->params['breadcrumbs'][] = ['label' => '预约列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="inquiry-view wrapper-content">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5><?= Html::encode($this->title) ?> <small>
                    <?php if (isset($this->params['breadcrumbs'])) {
                        $params = [
                            'tag' => 'ol',
                            'encodeLabels' => true, // 转义
                            'homeLink' => [
                                'label' => 'Home',
                                'url' => ['index']
                            ],
                            'links' => $this->params['breadcrumbs'],
                        ];
                        
                        echo Breadcrumbs::widget($params);
                    }
                    ?>
                    </small></h5>
                    
                    <div class="ibox-tools">
                        <?= Html::a('<i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> 返回', ['index'], ['class' => 'btn']) ?>
                        <a href="javascript: location.reload();" class="btn btn-outline btn-success btn-xs">刷新</a>
                    </div>
                </div>
                <div class="ibox-content">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            /*
                            [
                                //'attribute' => 'country.name',//可以直接联表
                                //'label' => 'Belong Country',//修改label标签
                                //ArrayHelper::getValue($this->model, $attributeName);//获取指定属性值的方法
                                //'value' => function($model, $_this) {return $value;},//匿名函数获取值
                                //'format' => 'text',//指定格式化
                                //'status' => true,//是否显示
                            ],
                            */
                            'ui_title',
                            'ui_content',
                            'user_id',
                            'ui_ipaddress',
                            'ui_browser:ntext',
                            'ui_answer:ntext',
                            'ui_remark:ntext',
                            'ui_type',
                            'ui_state',
                            'ui_submit_time:date',
                            'ui_answer_time:date',
                            'ui_remark_time:date',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>