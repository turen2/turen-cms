<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\components\ActiveRecord;

/* @var $this yii\web\View */
/* @var $model app\models\user\UserFavoriteSearch */
/* @var $form yii\widgets\ActiveForm */

$isAll = true;
foreach ($model->attributes as $key => $value) {
    if(!is_null($value)) {
        $isAll = false;
    }
}
?>

<div class="user-favorite-search toolbar-tab">
	<ul>
        <li class="<?= $isAll?'on':''?>"><?= Html::a('全部', ['index']) ?></li>
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