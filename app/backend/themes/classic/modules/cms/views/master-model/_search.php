<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use backend\components\ActiveRecord;
use backend\models\cms\Column;
use backend\models\cms\MasterModel;
use backend\models\cms\Flag;

$isAll = true;
foreach ($model->attributes as $key => $value) {
    if(in_array($key, ['id', 'columnid', 'cateid', 'status', 'author', 'flag', 'keyword']) && !is_null($value) && (!empty($value) || $value === '0')) {
        $isAll = false;
    }
}

$addRoutes = [
    'mid' => $diyModel->dm_id,
    Html::getInputName($model, 'columnid') => $model->columnid,
    Html::getInputName($model, 'cateid') => $model->cateid,
    Html::getInputName($model, 'keyword') => $model->keyword
];
?>

<div class="master-model-search toolbar-tab">
	<ul class="fl">
        <li class="<?= $isAll?'on':''?>"><?= Html::a('全部', ['index', 'mid' => $diyModel->dm_id]) ?></li>
        <li class="line">-</li>
        <li class="<?= (!is_null($model->status) && $model->status == ActiveRecord::STATUS_ON)?'on':''?>"><?= Html::a('显示', ArrayHelper::merge(['index', Html::getInputName($model, 'status') => ActiveRecord::STATUS_ON], $addRoutes)) ?></li>
        <li class="line">-</li>
        <li class="<?= (!is_null($model->status) && $model->status == ActiveRecord::STATUS_OFF)?'on':''?>"><?= Html::a('隐藏', ArrayHelper::merge(['index', Html::getInputName($model, 'status') => ActiveRecord::STATUS_OFF], $addRoutes)) ?></li>
        <li class="line">-</li>
        
        <?php foreach (Flag::FlagList($modelid, true) as $key => $name) { ?>
        <li class="<?= (!is_null($model->flag) && $model->flag == $key)?'on':''?>"><?= Html::a($name, ArrayHelper::merge(['index', Html::getInputName($model, 'flag') => $key], $addRoutes)) ?></li>
        <li class="line">-</li>
        <?php } ?>

        <?php
        $username = Yii::$app->getUser()->getIdentity()->username;
        ?>
        <li class="<?= (!is_null($model->author) && $model->author == $username)?'on':''?>"><?= Html::a('我发布的内容', ArrayHelper::merge(['index', Html::getInputName($model, 'author') => $username], $addRoutes)) ?></li>
	</ul>
	
    <?php $form = ActiveForm::begin([
        'action' => ArrayHelper::merge(['index', Html::getInputName($model, 'status') => $model->status, Html::getInputName($model, 'flag') => $model->flag, Html::getInputName($model, 'author') => $model->author], $addRoutes),
        'method' => 'get',
        'id' => 'searchform',
        'options' => ['class' => 'fr'],
    ]); ?>
		<span class="keyword">
			<?= Html::activeInput('text', $model, 'keyword', ['class' => 'input', 'placeholder' => '关键词']) ?>
		</span>
		<a class="op-btn" href="javascript:;" onclick="searchform.submit();">查询</a>
	<?php ActiveForm::end(); ?>
</div>