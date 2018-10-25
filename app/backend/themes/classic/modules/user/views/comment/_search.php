<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\components\ActiveRecord;

/* @var $this yii\web\View */
/* @var $model app\models\user\CommentSearch */
/* @var $form yii\widgets\ActiveForm */

$isAll = is_null($model->status);
?>

<div class="comment-search toolbar-tab">
	<ul>
        <li class="<?= $isAll?'on':''?>"><?= Html::a('全部', ['index']) ?></li>
        <li class="line">-</li>
        <li class="<?= (!is_null($model->status) && $model->status == ActiveRecord::STATUS_ON)?'on':''?>"><?= Html::a('显示', ['index', Html::getInputName($model, 'status') => ActiveRecord::STATUS_ON]) ?></li>
        <li class="line">-</li>
        <li class="<?= (!is_null($model->status) && $model->status == ActiveRecord::STATUS_OFF)?'on':''?>"><?= Html::a('隐藏', ['index', Html::getInputName($model, 'status') => ActiveRecord::STATUS_OFF]) ?></li>
	</ul>
	<div id="search" class="search">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'id' => 'searchform',
    ]); ?>

		<span class="s">
			<?= Html::activeInput('text', $model, 'keyword', ['class' => 'input']) ?>
		</span>
		<span class="b">
			<a href="javascript:;" onclick="searchform.submit();"></a>
		</span>

    <?php ActiveForm::end(); ?>
    </div>
	<div class="cl"></div>
</div>