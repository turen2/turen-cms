<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model app\models\user\Feedback */

$this->title = $model->fk_id;
$this->params['breadcrumbs'][] = ['label' => 'Feedbacks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="feedback-view wrapper wrapper-content">
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
                    	<a href=/index.php?r=gii%2Fdefault%2Findex class="btn btn-outline btn-white btn-xs" data-toggle="tooltip" data-placement="top" title="" data-original-title="返回到上一级"><i class="fa fa-reply" aria-hidden="true"></i> 返回</a>
                        <a href="javascript: location.reload();" class="btn btn-outline btn-success btn-xs">刷新</a>
                    </div>
                </div>
                <div class="ibox-content">
                <p>
                    <?= Html::a('<i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> 返回', ['index'], ['class' => 'btn btn-default btn-rounded return btn-sm']) ?>
                    <?= Html::a('Update', ['update', 'id' => $model->fk_id], ['class' => 'btn btn-primary btn-sm']) ?>
                    <?= Html::a('Delete', ['delete', 'id' => $model->fk_id], [
                        'class' => 'btn btn-danger btn-sm',
                        'data' => [
                            'confirm' => '您确认要删除吗？',
                            'method' => 'post',
                        ],
                    ]) ?>
                    <?= Html::a('Create', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
                </p>
            
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
                                            'fk_id',
                            'fk_user_id',
                            'fk_nickname',
                            'fk_contact',
                            'fk_content:ntext',
                            'fk_show',
                            'fk_type_id',
                            'fk_ip',
                            'fk_review:ntext',
                            'fk_retime',
                            'fk_sms',
                            'fk_email:email',
                            'lang',
                            'orderid',
                            'created_at',
                            'updated_at',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>