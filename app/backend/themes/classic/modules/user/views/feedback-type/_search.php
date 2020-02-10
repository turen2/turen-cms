<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\user\FeedbackType;
use backend\components\ActiveRecord;

/* @var $this yii\web\View */
/* @var $model backend\models\user\FeedbackTypeSearch */
/* @var $form yii\widgets\ActiveForm */

$isAll = true;
foreach ($model->attributes as $key => $value) {
    if(!is_null($value)) {
        $isAll = false;
    }
}
?>

<div class="feedback-type-search toolbar-tab">
	<ul class="fl">
        <li class="<?= $isAll?'on':''?>"><?= Html::a('全部', ['index']) ?></li>
        <li class="line">-</li>
        <li class="<?= (!is_null($model->status) && $model->status == ActiveRecord::STATUS_ON)?'on':''?>"><?= Html::a('显示', ['index', Html::getInputName($model, 'status') => ActiveRecord::STATUS_ON]) ?></li>
        <li class="line">-</li>
        <li class="<?= (!is_null($model->status) && $model->status == ActiveRecord::STATUS_OFF)?'on':''?>"><?= Html::a('隐藏', ['index', Html::getInputName($model, 'status') => ActiveRecord::STATUS_OFF]) ?></li>
        <li class="line">-</li>
        <li class="<?= (!is_null($model->fkt_form_show) && $model->fkt_form_show == FeedbackType::SHOW_YES)?'on':''?>"><?= Html::a('表单中显示', ['index', Html::getInputName($model, 'fkt_form_show') => FeedbackType::SHOW_YES]) ?></li>
        <li class="line">-</li>
        <li class="<?= (!is_null($model->fkt_list_show) && $model->fkt_list_show == FeedbackType::SHOW_YES)?'on':''?>"><?= Html::a('列表中显示', ['index', Html::getInputName($model, 'fkt_list_show') => FeedbackType::SHOW_YES]) ?></li>
	</ul>
	
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'id' => 'searchform',
        'options' => ['class' => 'fr'],
    ]); ?>
    	<span class="keyword">
    		<?= Html::activeInput('text', $model, 'keyword', ['class' => 'input']) ?>
    	</span>
    	<a class="s-btn" href="javascript:;" onclick="searchform.submit();">查询</a>
	<?php ActiveForm::end(); ?>
</div>