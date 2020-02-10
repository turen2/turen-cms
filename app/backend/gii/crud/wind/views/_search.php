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
use backend\components\ActiveRecord;

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
	<ul class="fl">
        <li class="<?= "<?= " ?>$isAll?'on':''?>"><?= "<?= " ?>Html::a('全部', ['index']) ?></li>
        <li class="line">-</li>
        <li class="<?= "<?= " ?>(!is_null($model->status) && $model->status == ActiveRecord::STATUS_ON)?'on':''?>"><?= "<?= " ?>Html::a('显示', ['index', Html::getInputName($model, 'status') => ActiveRecord::STATUS_ON]) ?></li>
        <li class="line">-</li>
        <li class="<?= "<?= " ?>(!is_null($model->status) && $model->status == ActiveRecord::STATUS_OFF)?'on':''?>"><?= "<?= " ?>Html::a('隐藏', ['index', Html::getInputName($model, 'status') => ActiveRecord::STATUS_OFF]) ?></li>
        <li class="line">-</li>
        <li><a id="recycle-bin" href="javascript:;">内容回收站</a></li>
	</ul>
	
    <?= "<?php " ?>$form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'id' => 'searchform',
        'options' => ['class' => 'fr'],
    ]); ?>
    	<span class="keyword">
    		<?= "<?= " ?>Html::activeInput('text', $model, 'keyword', ['class' => 'input']) ?>
    	</span>
    	<a class="s-btn" href="javascript:;" onclick="searchform.submit();">查询</a>
	<?= "<?php " ?>ActiveForm::end(); ?>
</div>