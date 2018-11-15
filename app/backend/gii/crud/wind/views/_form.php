<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\widgets\Tips;
use app\components\ActiveRecord;
use app\assets\ValidationAsset;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */

ValidationAsset::register($this);

$rules = $messages = [];
$rules[Html::getInputName($model, 'xxxxx')] = ['required' => true];

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

<?= "<?= " ?>Tips::widget([
    'type' => 'error',
    'model' => $model,
    'closeBtn' => false,
]) ?>

<?= "<?php " ?>$form = ActiveForm::begin([
    'enableClientScript' => false,
    'options' => ['id' => 'submitform'],
]); ?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form form-table">
<?php foreach ($generator->getColumnNames() as $attribute) { ?>
    	<tr>
    		<td class="first-column"><?= "<?= " ?>$model->getAttributeLabel('<?= $attribute?>')?><?= "<?php " ?>if($model->isAttributeRequired('<?= $attribute?>')) { ?><span class="maroon">*</span><?= "<?php " ?>} ?></td>
    		<td class="second-column">
    			<?= "<?= " ?>Html::activeInput('text', $model, '<?= $attribute?>', ['class' => 'input']) ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
<?php } ?>
    	<tr class="nb">
    		<td></td>
    		<td>
    			<div class="form-sub-btn">
            		<?= "<?= " ?>Html::submitButton('提交', ['class' => 'submit', 'id' => 'submit-btn']) ?>
            		<?= "<?= " ?>Html::input('button', 'backName', '返回', ['class' => 'back', 'onclick' => 'location.href="'.Url::to(['index']).'"']) ?>
            	</div>
    		</td>
    	</tr>
	</table>
<?= "<?php " ?>ActiveForm::end(); ?>