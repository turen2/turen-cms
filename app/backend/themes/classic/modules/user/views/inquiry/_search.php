<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use app\models\user\Inquiry;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>

<div class="inquiry-search toolbar-tab">
	<ul class="fl">
        <li class="<?= (is_null($model->ui_state) && is_null($model->ui_type))?'on':''?>"><?= Html::a('全部', ['index']) ?></li>
        <?php
        $lines = [];
        foreach (Inquiry::getStateNameList() as $key => $state) {
            $lines[] =  '<li class="'.(($model->ui_state == $key)?'on':'').'"><a href="'.Url::to(['inquiry/index', 'InquirySearch[ui_state]' => $key]).'">'.$state.'</a></li>';
        }
        echo implode('<li class="line">-</li>', $lines).'<li class="line"> </li>';

        $lines = [];
        foreach (Inquiry::getTypeNameList() as $key => $type) {
            $lines[] = '<li class="'.(($model->ui_type == $key)?'on':'').'"><a href="'.Url::to(['inquiry/index', 'InquirySearch[ui_type]' => $key]).'">'.$type.'</a></li>';
        }
        echo implode('<li class="line">-</li>', $lines);
        ?>
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