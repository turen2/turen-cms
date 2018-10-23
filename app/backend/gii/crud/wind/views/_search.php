<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\components\ActiveRecord;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->searchModelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */

$isAll = true;
foreach ($model->attributes as $key => $value) {
    if(!is_null($value)) {
        $isAll = false;
    }
}
?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-search toolbar-tab">
	<ul>
        <li class="<?= "<?= " ?>$isAll?'on':''?>"><?= "<?= " ?>Html::a('全部', ['index']) ?></li>
        <li class="line">-</li>
        <li class="<?= "<?= " ?>(!is_null($model->status) && $model->status == ActiveRecord::STATUS_ON)?'on':''?>"><?= "<?= " ?>Html::a('显示', ['index', Html::getInputName($model, 'status') => ActiveRecord::STATUS_ON]) ?></li>
        <li class="line">-</li>
        <li class="<?= "<?= " ?>(!is_null($model->status) && $model->status == ActiveRecord::STATUS_OFF)?'on':''?>"><?= "<?= " ?>Html::a('隐藏', ['index', Html::getInputName($model, 'status') => ActiveRecord::STATUS_OFF]) ?></li>
        <li class="line">-</li>
        <li><a id="recycle-bin" href="javascript:;">内容回收站</a></li>
	</ul>
	<div id="search" class="search">
    <?= "<?php " ?>$form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'id' => 'searchform',
    ]); ?>

		<span class="s">
			<?= "<?= " ?>Html::activeInput('text', $model, 'keyword', ['class' => 'input']) ?>
		</span>
		<span class="b">
			<a href="javascript:;" onclick="searchform.submit();"></a>
		</span>

    <?= "<?php " ?>ActiveForm::end(); ?>
    </div>
	<div class="cl"></div>
</div>