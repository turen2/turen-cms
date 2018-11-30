<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\cms\Article;
use app\assets\RecycleAsset;
use yii\helpers\Url;
use app\actions\RecycleAction;
use app\models\cms\Column;
use app\models\cms\Flag;

/* @var $this yii\web\View */
/* @var $model app\models\cms\ArticleSearch */
/* @var $form yii\widgets\ActiveForm */

$isAll = true;
foreach ($model->attributes as $key => $value) {
    if(!is_null($value)) {
        $isAll = false;
    }
}
?>

<div class="article-search toolbar-tab">
	<ul class="fl">
        <li class="<?= $isAll?'on':''?>"><?=Html::a('全部', ['index'])?></li>
        <li class="line">-</li>
        <li class="<?= (!is_null($model->status) && $model->status == Article::STATUS_ON)?'on':''?>"><?= Html::a('显示', ['index', Html::getInputName($model, 'status') => Article::STATUS_ON]) ?></li>
        <li class="line">-</li>
        <li class="<?= (!is_null($model->status) && $model->status == Article::STATUS_OFF)?'on':''?>"><?= Html::a('隐藏', ['index', Html::getInputName($model, 'status') => Article::STATUS_OFF]) ?></li>
        <li class="line">-</li>
        
        <?php foreach (Flag::FlagList(Column::COLUMN_TYPE_PHOTO, true) as $key => $name) { ?>
        <li class="<?= (!is_null($model->flag) && $model->flag == $key)?'on':''?>"><?= Html::a($name, ['index', Html::getInputName($model, 'flag') => $key]) ?></li>
        <li class="line">-</li>
        <?php } ?>
        
        <?php 
        $username = Yii::$app->getUser()->getIdentity()->username;
        ?>
        <li class="<?= (!is_null($model->author) && $model->author == $username)?'on':''?>"><?= Html::a('我发布的内容', ['index', Html::getInputName($model, 'author') => $username]) ?></li>
        <li class="line">-</li>
        <li><a id="recycle-bin" href="javascript:;" onclick="RecycleShow('<?=Url::to(['recycle', 'type' => RecycleAction::RECYCLE_TYPE_LIST])?>');">内容回收站</a></li>
	</ul>
	
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
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

<?= $this->render('_recycle'); ?>