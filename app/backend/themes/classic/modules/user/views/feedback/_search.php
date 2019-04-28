<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use app\models\user\Feedback;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\components\ActiveRecord;

/* @var $this yii\web\View */
/* @var $model app\models\user\FeedbackSearch */
/* @var $form yii\widgets\ActiveForm */

$isAll = true;
foreach ($model->attributes as $key => $value) {
    if(!is_null($value)) {
        $isAll = false;
    }
}
?>

<?php //fk_type_id ?>

<div class="feedback-search toolbar-tab">
	<ul class="fl">
        <li class="<?= $isAll?'on':''?>"><?= Html::a('全部', ['index']) ?></li>
        <li class="line">-</li>
        <li class="<?= (!is_null($model->fk_show) && $model->fk_show == Feedback::HOT_TOP)?'on':''?>"><?= Html::a('前台顶置', ['index', Html::getInputName($model, 'fk_show') => Feedback::HOT_TOP]) ?></li>
        <li class="line">-</li>
        <li class="<?= (!is_null($model->fk_sms) && $model->fk_sms == Feedback::SEND_YES)?'on':''?>"><?= Html::a('已发短信', ['index', Html::getInputName($model, 'fk_sms') => Feedback::SEND_YES]) ?></li>
        <li class="line">-</li>
        <li class="<?= (!is_null($model->fk_sms) && $model->fk_sms == Feedback::SEND_NO)?'on':''?>"><?= Html::a('未发短信', ['index', Html::getInputName($model, 'fk_sms') => Feedback::SEND_NO]) ?></li>
        <li class="line">-</li>
        <li class="<?= (!is_null($model->fk_email) && $model->fk_email == Feedback::SEND_YES)?'on':''?>"><?= Html::a('已发邮件', ['index', Html::getInputName($model, 'fk_email') => Feedback::SEND_YES]) ?></li>
        <li class="line">-</li>
        <li class="<?= (!is_null($model->fk_email) && $model->fk_email == Feedback::SEND_NO)?'on':''?>"><?= Html::a('未发邮件', ['index', Html::getInputName($model, 'fk_email') => Feedback::SEND_NO]) ?></li>
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