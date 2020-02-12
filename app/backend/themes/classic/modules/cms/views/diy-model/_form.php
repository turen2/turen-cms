<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use backend\widgets\Tips;
use backend\assets\ValidationAsset;
use backend\models\cms\DiyModel;

/* @var $this yii\web\View */
/* @var $model backend\models\cms\DiyModel */
/* @var $form yii\widgets\ActiveForm */

ValidationAsset::register($this);

$this->registerJs('
var validator = $("#submitform").validate({
	rules: {
        "'.Html::getInputName($model, 'dm_title').'": {
			required: true,
            remote: {
                url: "'.Url::to(['validate-title']).'",
                data: {
                    id: function() {
                        return '.$model->dm_id.';//排除自身检测
                    }
                }
            }
		},
        "'.Html::getInputName($model, 'dm_name').'": {
			required: true,
            remote: {
                url: "'.Url::to(['validate-name']).'",
                data: {
                    id: function() {
                        return '.$model->dm_id.';//排除自身检测
                    }
                }
            }
		},
        "'.Html::getInputName($model, 'dm_tbname').'": {
			required: true,
            remote: {
                url: "'.Url::to(['validate-tbname']).'",
                data: {
                    id: function() {
                        return '.$model->dm_id.';//排除自身检测
                    }
                }
            }
		}
	},
    messages: {
        "'.Html::getInputName($model, 'dm_title').'": {
            remote: "已占用请重新输入"
        },
        "'.Html::getInputName($model, 'dm_name').'": {
            remote: "已占用请重新输入"
        },
        "'.Html::getInputName($model, 'dm_tbname').'": {
            remote: "已占用请重新输入"
        }
    },
    errorElement: "p",
	errorPlacement: function(error, element) {
		error.appendTo(element.parent());
	}
});
');

$this->topAlert = '<div class="alert alert-warning">注意：自定义模型将自动创建，标题、访问链接、标记、缩略图、作者、虚拟点击量、点击次数、排序、状态、发布时间、更新时间、创建时间。</div>';
?>

<?= Tips::widget([
    'type' => 'error',
    'model' => $model,
    'closeBtn' => false,
]) ?>

<?php $form = ActiveForm::begin([
    'enableClientScript' => false,
    'options' => ['id' => 'submitform'],
]); ?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="diy-model-form form-table">
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('dm_name')?><?php if($model->isAttributeRequired('dm_name')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?php if($model->isNewRecord) { ?>
    			<?= Html::activeInput('text', $model, 'dm_name', ['class' => 'input']) ?>
    			<?php } else { ?>
    			<?= Html::activeInput('text', $model, 'dm_name', ['class' => 'input', 'disabled' => 'disabled']) ?>
    			<?php } ?>
    			<span class="cnote">模型类名，请按照驼峰命名法</span>
    		</td>
    	</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('dm_tbname')?><?php if($model->isAttributeRequired('dm_tbname')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?php if($model->isNewRecord) { ?>
    			<?= Html::activeInput('text', $model, 'dm_tbname', ['class' => 'input']) ?>
    			<?php } else { ?>
    			<?= Html::activeInput('text', $model, 'dm_tbname', ['class' => 'input', 'disabled' => 'disabled']) ?>
    			<?php } ?>
    			<span class="cnote">要生成的表名，生成格式为：系统表前缀_模型表前缀_<span class="maroon">模型表名</span></span>
    		</td>
    	</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('dm_title')?><?php if($model->isAttributeRequired('dm_title')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeInput('text', $model, 'dm_title', ['class' => 'input']) ?>
    			<span class="cnote">模型标题，中文名</span>
    		</td>
    	</tr>
    	<tr>
    		<td class="first-column">默认创建字段</td>
    		<td class="second-column">
    			<?= Html::checkboxList('show_list', array_keys(DiyModel::DefaultFieldList()), DiyModel::DefaultFieldList(), ['itemOptions' => ['disabled' => 'disabled'], 'tag' => 'span', 'separator' => '&nbsp;&nbsp;&nbsp;']) ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('orderid')?><?php if($model->isAttributeRequired('orderid')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeInput('text', $model, 'orderid', ['class' => 'inputs']) ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('status')?><?php if($model->isAttributeRequired('status')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeRadioList($model, 'status', [
			        DiyModel::STATUS_ON => '启用',
    			    DiyModel::STATUS_OFF => '禁用',
				], ['tag' => 'span', 'separator' => '&nbsp;&nbsp;&nbsp;']);
				?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	<tr class="nb">
    		<td></td>
    		<td>
    			<div class="form-sub-btn">
            		<?= Html::submitButton('提交', ['class' => 'submit', 'id' => 'submit-btn']) ?>
            		<?= Html::input('button', 'backName', '返回', ['class' => 'back', 'onclick' => 'location.href="'.Url::to(['index']).'"']) ?>
            	</div>
    		</td>
    	</tr>
	</table>
<?php ActiveForm::end(); ?>