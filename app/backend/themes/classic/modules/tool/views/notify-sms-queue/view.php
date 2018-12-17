<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model app\models\tool\NotifySmsQueue */

$this->title = $model->nq_sms_id;
$this->params['breadcrumbs'][] = ['label' => '队列详情', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notify-sms-queue-view wrapper wrapper-content">
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
                    <?= Html::a('Update', ['update', 'id' => $model->nq_sms_id], ['class' => 'btn btn-primary btn-sm']) ?>
                    <?= Html::a('Delete', ['delete', 'id' => $model->nq_sms_id], [
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
                                            'nq_sms_id',
                            'nq_nu_id',
                            'nq_ng_id',
                            'nq_is_email:email',
                            'nq_is_notify',
                            'nq_is_sms',
                            'nq_email_send_time:email',
                            'nq_email_arrive_time:email',
                            'nq_notify_send_time',
                            'nq_notify_arrive_time',
                            'nq_sms_send_time',
                            'nq_sms_arrive_time',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>