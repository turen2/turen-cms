<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\widgets\Tips;
use yii\base\Widget;
use yii\helpers\Url;
use app\models\sys\Admin;
use app\assets\ValidationAsset;
use yii\helpers\ArrayHelper;
use app\models\sys\Role;

/* @var $this yii\web\View */
/* @var $model app\models\sys\Admin */
/* @var $form yii\widgets\ActiveForm */

ValidationAsset::register($this);

if($model->isNewRecord) {
    $this->registerJs('
    var validator = $("#submitform").validate({
    	rules: {
    		"'.Html::getInputName($model, 'username').'": {
    			required: true,
                minlength: 2,
                maxlength: 16,
    		},
            "'.Html::getInputName($model, 'phone').'": {
    			required: true,
                isPhone: true,
    		},
    		"'.Html::getInputName($model, 'password').'": {
    			required: true,
                minlength: 5,
                maxlength: 16,
    		},
            "'.Html::getInputName($model, 'repassword').'": {
    			required: true,
                equalTo:"#admin-password",
    		}
    	},
        errorElement: "p",
    	errorPlacement: function(error, element) {
    		error.appendTo(element.parent());
    	}
    });
    ');
} else {
    $this->registerJs('
    var validator = $("#submitform").validate({
    	rules: {
            "'.Html::getInputName($model, 'username').'": {
    			required: true,
                minlength: 2,
                maxlength: 16,
    		},
            "'.Html::getInputName($model, 'phone').'": {
    			required: true,
                isPhone: true,
    		},
            "'.Html::getInputName($model, 'repassword').'": {
                equalTo:"#admin-password",
    		}
    	},
        errorElement: "p",
    	errorPlacement: function(error, element) {
    		error.appendTo(element.parent());
    	}
    });
    ');
}
?>

<?= Tips::widget([
    'type' => 'error',
    'model' => $model,
    'closeBtn' => false,
]) ?>

<?php $form = ActiveForm::begin([
    'options' => ['id' => 'submitform'],
]); ?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form-table">
		<tr>
			<td class="first-column"><?= $model->getAttributeLabel('username')?><?php if($model->isAttributeRequired('username')) { ?><span class="maroon">*</span><?php } ?></td>
			<td class="second-column">
				<?= Html::activeInput('text', $model, 'username', ['class' => 'input']) ?>
				<span class="cnote">带<span class="maroon">*</span>号表示为必填项</span>
			</td>
		</tr>
		<tr>
			<td class="first-column"><?= $model->getAttributeLabel('phone')?><?php if($model->isAttributeRequired('phone')) { ?><span class="maroon">*</span><?php } ?></td>
			<td class="second-column">
				<?= Html::activeInput('text', $model, 'phone', ['class' => 'input']) ?>
				<span class="cnote"></span>
			</td>
		</tr>
		<tr>
			<td class="first-column"><?= $model->getAttributeLabel('nickname')?><?php if($model->isAttributeRequired('nickname')) { ?><span class="maroon">*</span><?php } ?></td>
			<td class="second-column">
				<?= Html::activeInput('text', $model, 'nickname', ['class' => 'input']) ?>
				<span class="maroon">&nbsp;</span><span class="cnote">对外展示的名称</span>
			</td>
		</tr>
		<tr>
			<td class="first-column"><?= $model->getAttributeLabel('password')?><?php if($model->isAttributeRequired('password')) { ?><span class="maroon">*</span><?php } ?></td>
			<td class="second-column">
				<?= Html::activeInput('password', $model, 'password', ['class' => 'input']) ?>
				<span class="cnote">6-16个字符组成，区分大小写</span>
			</td>
		</tr>
		<tr>
			<td class="first-column"><?= $model->getAttributeLabel('repassword')?><?php if($model->isAttributeRequired('repassword')) { ?><span class="maroon">*</span><?php } ?></td>
			<td class="second-column">
				<?= Html::activeInput('password', $model, 'repassword', ['class' => 'input']) ?>
				<span class="cnote"></span>
			</td>
		</tr>
		<tr>
			<td class="first-column"><?= $model->getAttributeLabel('question')?><?php if($model->isAttributeRequired('question')) { ?><span class="maroon">*</span><?php } ?></td>
			<td class="second-column">
				<?= Html::activeDropDownList($model, 'question', Yii::$app->params['config.safeQuestion']) ?>
				<span class="cnote"></span>
			</td>
		</tr>
		<tr>
			<td class="first-column"><?= $model->getAttributeLabel('answer')?><?php if($model->isAttributeRequired('answer')) { ?><span class="maroon">*</span><?php } ?></td>
			<td class="second-column">
				<?= Html::activeInput('text', $model, 'answer', ['class' => 'input']) ?>
				<span class="cnote"></span>
			</td>
		</tr>
		<tr>
			<td class="first-column"><?= $model->getAttributeLabel('role_id')?><?php if($model->isAttributeRequired('role_id')) { ?><span class="maroon">*</span><?php } ?></td>
			<td class="second-column">
				<?php 
				if($model->isFounder()) {
				    echo '创始人不需要角色';
				} else {
				    echo Html::activeDropDownList($model, 'role_id', ArrayHelper::map(Role::find()->all(), 'role_id', 'role_name'));
				}
				?>
			</td>
		</tr>
		<tr>
			<td class="first-column"><?= $model->getAttributeLabel('status')?><?php if($model->isAttributeRequired('status')) { ?><span class="maroon">*</span><?php } ?></td>
			<td class="second-column">
				<?php 
				if($model->isFounder()) {
				    echo '创始人不需要审核';
				} else {
				    echo Html::activeRadioList($model, 'status', [
				        Admin::STATUS_ON => '已审核',
				        Admin::STATUS_OFF => '未审核',
				    ], [
				        'separator' => '&nbsp;&nbsp;&nbsp;'
				    ]);
				}
				?>
			</td>
		</tr>
		<tr class="nb">
			<td></td>
			<td>
				<div class="form-sub-btn">
            		<input type="submit" class="submit" id="submit-btn" value="提交" />
            		<input type="button" class="back" value="返回" onclick="location.href='<?= Url::to(['/sys/admin/index']) ?>'" />
            	</div>
			</td>
		</tr>
	</table>
<?php ActiveForm::end(); ?>