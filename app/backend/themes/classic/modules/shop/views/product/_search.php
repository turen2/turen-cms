<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\components\ActiveRecord;
use app\actions\RecycleAction;
use yii\helpers\Url;
use app\models\cms\Column;

/* @var $this yii\web\View */
/* @var $model app\models\shop\ProductSearch */
/* @var $form yii\widgets\ActiveForm */

$isAll = true;
foreach ($model->attributes as $key => $value) {
    if(!is_null($value)) {
        $isAll = false;
    }
}
?>

<div class="product-search toolbar-tab">
	<ul>
        <li class="<?= $isAll?'on':''?>"><?= Html::a('全部', ['index']) ?></li>
        <li class="line">-</li>
        <li class="<?= (!is_null($model->status) && $model->status == ActiveRecord::STATUS_ON)?'on':''?>"><?= Html::a('显示', ['index', Html::getInputName($model, 'status') => ActiveRecord::STATUS_ON]) ?></li>
        <li class="line">-</li>
        <li class="<?= (!is_null($model->status) && $model->status == ActiveRecord::STATUS_OFF)?'on':''?>"><?= Html::a('隐藏', ['index', Html::getInputName($model, 'status') => ActiveRecord::STATUS_OFF]) ?></li>
        <li class="line">-</li>
        <?php foreach ($model->getAllFlag(Column::COLUMN_TYPE_PRODUCT, true, true) as $key => $name) { ?>
        <li class="<?= (!is_null($model->flag) && $model->flag == $key)?'on':''?>"><?= Html::a($name, ['index', Html::getInputName($model, 'flag') => $key]) ?></li>
        <li class="line">-</li>
        <?php } ?>
        
        <?php 
        $username = Yii::$app->getUser()->getIdentity()->username;
        ?>
        <li class="<?= (!is_null($model->author) && $model->author == $username)?'on':''?>"><?= Html::a('我发布的产品', ['index', Html::getInputName($model, 'author') => $username]) ?></li>
        <li class="line">-</li>
        <li><a id="recycle-bin" href="javascript:;" onclick="RecycleShow('<?=Url::to(['recycle', 'type' => RecycleAction::RECYCLE_TYPE_LIST])?>');">内容回收站</a></li>
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

<?= $this->render('_recycle'); ?>