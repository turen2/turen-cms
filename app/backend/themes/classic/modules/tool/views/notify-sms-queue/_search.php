<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\components\ActiveRecord;
use yii\helpers\ArrayHelper;
use app\models\tool\NotifyGroup;

/* @var $this yii\web\View */
/* @var $model app\models\tool\NotifySmsQueueSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="notify-sms-queue-search toolbar-tab">
	<ul class="fl">
        <li class="<?= (empty($model->keyword) && empty($model->nq_nu_id) && empty($model->nq_ng_id))?'on':''?>"><?= Html::a('全部', ['index']) ?></li>
	</ul>
	
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'id' => 'searchform',
	    'options' => ['class' => 'fr'],
    ]); ?>
    	<span><?= Html::activeDropDownList($model, 'nq_ng_id', ArrayHelper::merge([null => '请选择队列'], ArrayHelper::map(NotifyGroup::find()->orderBy(['ng_id' => SORT_DESC])->all(), 'ng_id', 'ng_title'))) ?></span>
    	<span class="keyword">
    		<?= Html::activeInput('text', $model, 'keyword', ['class' => 'input', 'placeholder' => '关键词']) ?>
    	</span>
    	<a class="op-btn" href="javascript:;" onclick="searchform.submit();">查询</a>
	<?php ActiveForm::end(); ?>
</div>