<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\components\ActiveRecord;
use app\models\cms\Column;
use app\models\cms\MasterModel;

/* @var $this yii\web\View */
/* @var $model app\models\cms\MasterModelSearch */
/* @var $form yii\widgets\ActiveForm */

$isAll = true;
foreach ($model->attributes as $key => $value) {
    if(!is_null($value)) {
        $isAll = false;
    }
}
?>

<div class="master-model-search toolbar-tab">
	<ul>
        <li class="<?= $isAll?'on':''?>"><?= Html::a('全部', ['index', 'mid' => $diyModel->dm_id]) ?></li>
        <li class="line">-</li>
        <li class="<?= (!is_null($model->status) && $model->status == ActiveRecord::STATUS_ON)?'on':''?>"><?= Html::a('显示', ['index', 'mid' => $diyModel->dm_id, Html::getInputName($model, 'status') => ActiveRecord::STATUS_ON]) ?></li>
        <li class="line">-</li>
        <li class="<?= (!is_null($model->status) && $model->status == ActiveRecord::STATUS_OFF)?'on':''?>"><?= Html::a('隐藏', ['index', 'mid' => $diyModel->dm_id, Html::getInputName($model, 'status') => ActiveRecord::STATUS_OFF]) ?></li>
        <li class="line">-</li>
        
        <?php foreach ($model->getAllFlag($modelid, true, true) as $key => $name) { ?>
        <li class="<?= (!is_null($model->flag) && $model->flag == $key)?'on':''?>"><?= Html::a($name, ['index', Html::getInputName($model, 'flag') => $key, 'mid' => $modelid]) ?></li>
        <li class="line">-</li>
        <?php } ?>
        <li><?= Html::a('我发布的内容', 'javascript:;') ?></li>
        
	</ul>
	<div id="search" class="search">
        <?php $form = ActiveForm::begin([
            'action' => ['index', 'mid' => $diyModel->dm_id],
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