<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use backend\models\user\User;
use backend\widgets\Tips;
use backend\components\ActiveRecord;
use backend\assets\ValidationAsset;
use backend\models\user\Feedback;
use backend\models\user\FeedbackType;
use backend\widgets\laydate\LaydateWidget;
use backend\widgets\select2\Select2Widget;
use backend\widgets\ueditor\UEditorWidget;

/* @var $this yii\web\View */
/* @var $model backend\models\user\Feedback */
/* @var $form yii\widgets\ActiveForm */

ValidationAsset::register($this);

$rules = $messages = [];
$rules[Html::getInputName($model, 'fk_nickname')] = ['required' => true];
$rules[Html::getInputName($model, 'fk_type_id')] = ['required' => true];
$rules[Html::getInputName($model, 'fk_content')] = ['required' => true];
$rules[Html::getInputName($model, 'fk_review')] = ['required' => true];

$rules = Json::encode($rules);
$messages = Json::encode($messages);
$js = <<<EOF
var validator = $("#submitform").validate({
	rules: {$rules},
	messages: {$messages},
    errorElement: "p",
	errorPlacement: function(error, element) {
		error.appendTo(element.parent());
	}
});
EOF;
$this->registerJs($js);
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
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="feedback-form form-table">
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('fk_nickname')?><?php if($model->isAttributeRequired('fk_nickname')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeInput('text', $model, 'fk_nickname', ['class' => 'input']) ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
        <tr>
            <td class="first-column"><?= $model->getAttributeLabel('fk_user_id')?><?php if($model->isAttributeRequired('fk_user_id')) { ?><span class="maroon">*</span><?php } ?></td>
            <td class="second-column">
                <?= Select2Widget::widget([
                    'model' => $model,
                    'attribute' => 'fk_user_id',
                    'route' => 'feedback/get-user-list',//路由
                    //初始化关联表对象
                    'modelClass' => User::class,//关联表类
                    'primaryKey' => 'user_id',//默认关联表主键
                    'showField' => 'username',//要显示的关联表字段
                    'clientOptions' => ['width' => '285px'],
                ]) ?>
                <span class="cnote"></span>
            </td>
        </tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('fk_contact')?><?php if($model->isAttributeRequired('fk_contact')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeInput('text', $model, 'fk_contact', ['class' => 'input']) ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('fk_content')?><?php if($model->isAttributeRequired('fk_content')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
                <?= UEditorWidget::widget([
                    'model' => $model,
                    'attribute' => 'fk_content',
                    'clientOptions' => [
                        'serverUrl' => Url::to(['ueditor']),
                        'initialContent' => '',
                        'initialFrameWidth' => '738',
                        'initialFrameHeight' => '280',
                        'toolbars' => [
                            [
                                'fullscreen', 'source', '|',
                                'undo', 'redo', '|',
                                'bold', 'italic', 'underline', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', '|',
                                'indent', 'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|',
                                'fontfamily', 'fontsize', '|','removeformat'
                            ],
                        ]
                    ],
                    //'readyEvent' => 'alert(\'abc\');console.log(ue);',
                ]); ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('fk_review')?><?php if($model->isAttributeRequired('fk_review')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
                <?= UEditorWidget::widget([
                    'model' => $model,
                    'attribute' => 'fk_review',
                    'clientOptions' => [
                        'serverUrl' => Url::to(['ueditor']),
                        'initialContent' => '',
                        'initialFrameWidth' => '738',
                        'initialFrameHeight' => '280',
                        'toolbars' => [
                            [
                                'fullscreen', 'source', '|',
                                'undo', 'redo', '|',
                                'bold', 'italic', 'underline', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', '|',
                                'indent', 'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|',
                                'fontfamily', 'fontsize', '|','removeformat'
                            ],
                        ]
                    ],
                    //'readyEvent' => 'alert(\'abc\');console.log(ue);',
                ]); ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
        <tr>
            <td class="first-column"><?= $model->getAttributeLabel('fk_retime')?><?php if($model->isAttributeRequired('fk_retime')) { ?><span class="maroon">*</span><?php } ?></td>
            <td class="second-column">
                <?= LaydateWidget::widget([
                    'model' => $model,
                    'attribute' => 'fk_retime',
                    'value' => $model->dateTimeValue(),
                    'options' => ['class' => 'inputms'],
                ]) ?>
                <span class="cnote"></span>
            </td>
        </tr>
        <tr>
            <td class="first-column"><?= $model->getAttributeLabel('fk_ip')?><?php if($model->isAttributeRequired('fk_ip')) { ?><span class="maroon">*</span><?php } ?></td>
            <td class="second-column">
                <?= Html::activeInput('text', $model, 'fk_ip', ['class' => 'input']) ?>
                <span class="cnote"></span>
            </td>
        </tr>
        <tr>
            <td class="first-column"><?= $model->getAttributeLabel('fk_show')?><?php if($model->isAttributeRequired('fk_show')) { ?><span class="maroon">*</span><?php } ?></td>
            <td class="second-column">
                <?= Html::activeRadioList($model, 'fk_show', [
                    Feedback::SEND_YES => '展示',
                    Feedback::SEND_NO => '隐藏',
                ], ['tag' => 'span', 'separator' => '&nbsp;&nbsp;&nbsp;']);
                ?>
                <span class="cnote"></span>
            </td>
        </tr>
        <tr>
            <td class="first-column"><?= $model->getAttributeLabel('fk_sms')?><?php if($model->isAttributeRequired('fk_sms')) { ?><span class="maroon">*</span><?php } ?></td>
            <td class="second-column">
                <?= Html::activeRadioList($model, 'fk_sms', [
                    Feedback::SEND_YES => '发送',
                    Feedback::SEND_NO => '不发送',
                ], ['tag' => 'span', 'separator' => '&nbsp;&nbsp;&nbsp;']);
                ?>
                <span class="cnote"></span>
            </td>
        </tr>
        <tr>
            <td class="first-column"><?= $model->getAttributeLabel('fk_email')?><?php if($model->isAttributeRequired('fk_email')) { ?><span class="maroon">*</span><?php } ?></td>
            <td class="second-column">
                <?= Html::activeRadioList($model, 'fk_email', [
                    Feedback::SEND_YES => '发送',
                    Feedback::SEND_NO => '不发送',
                ], ['tag' => 'span', 'separator' => '&nbsp;&nbsp;&nbsp;']);
                ?>
                <span class="cnote"></span>
            </td>
        </tr>
        <tr>
            <td class="first-column"><?= $model->getAttributeLabel('fk_type_id')?><?php if($model->isAttributeRequired('fk_type_id')) { ?><span class="maroon">*</span><?php } ?></td>
            <td class="second-column">
                <?php
                $list = [null => '请选择类型'];
                foreach (FeedbackType::find()->active()->all() as $mm) {
                    $list[$mm->fkt_id] = $mm->fkt_form_name.'/'.$mm->fkt_list_name;
                }
                ?>
                <?= Html::activeDropDownList($model, 'fk_type_id', $list, ['class' => '']) ?>
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