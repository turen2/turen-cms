<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\components\ActiveRecord;

/* @var $this yii\web\View */
/* @var $model app\models\sys\LogSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="log-search toolbar-tab">
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