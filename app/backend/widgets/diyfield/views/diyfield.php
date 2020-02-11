<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\helpers\Url;
use backend\models\cms\DiyField;
use backend\widgets\laydate\LaydateWidget;
use backend\widgets\fileupload\JQueryFileUploadWidget;
use backend\widgets\ueditor\UEditorWidget;
?>

<tr class="nb no-prev-line" style="display: <?= (count($fieldModels)>0 && count($columnFieldModels)>0)?'':'none' ?>;">
	<td colspan="2" class="td-line"><div class="line"></div></td>
</tr>

<?php 
$columnClass = get_class($model);
foreach ($fieldModels as $fieldModel) {
    // 编辑时，当前是显示？
    $isDisplay = in_array($fieldModel, $columnFieldModels);
?>

<tr class="diy-field-row" data-columnids="<?= $fieldModel->columnid_list ?>" style="display: <?= $isDisplay?'':'none' ?>;">
	<td class="first-column"><?= $fieldModel->fd_title ?><?= !empty($fieldModel->fd_check)?'<span class="maroon">*</span>':'' ?></td>
	<td class="second-column">
		<?php 
		$attribute = DiyField::FIELD_PRE.$fieldModel->fd_name;
		if($model->hasAttribute($attribute)) {
		    //备选值和默认值
		    $items = [];
		    $default = '';
		    if(!empty($fieldModel->fd_value) && strpos($fieldModel->fd_value, '|') !== false) {
		        foreach (explode('|', $fieldModel->fd_value) as $ii) {
		            if(strpos($ii, '-') !== false) {
		                $vv = explode('-', $ii);
		                $items[$vv[0]] = $vv[1];
    		        } else {
    		            $items[$ii] = $ii;//键和值相等的情况
    		        }
		        }
		        if(empty($items)) {
		            $default = '';
		        } else {
		            $keys = array_keys($items);
		            $default = isset($keys[0])?$keys[0]:'';//取第一个值
		        }
		    } else {
		        $items = [$fieldModel->fd_value];
		        $default = $fieldModel->fd_value;
		    }
		    
		    if(is_null($model->{$attribute})) {
		        $model->{$attribute} = $default;
		    }
		    
		    switch ($fieldModel->fd_type) {
		        case 'varchar':
		            echo Html::activeTextInput($model, $attribute, ['class' => 'input']);
		            break;
		        case 'int':
		        case 'decimal':
		            echo Html::activeTextInput($model, $attribute, ['class' => 'inputs']);
		            break;
		        case 'text'://多文本
		            echo Html::activeTextarea($model, $attribute, ['class' => 'textdesc']);
		            break;
		        case 'mediumtext'://编辑器
		            echo UEditorWidget::widget([
    		            'model' => $model,
    		            'attribute' => $attribute,
    		            'clientOptions' => [
        		            'serverUrl' => Url::to(['diyfield-ueditor', 'mid' => $mid]),
        		            'initialContent' => '',
        		            'initialFrameWidth' => '738',
        		            'initialFrameHeight' => '280',
    		            ],
    		            //'readyEvent' => 'alert(\'abc\');console.log(ue);',
		            ]);
		            break;
		        case 'radio'://单选
		            echo Html::activeRadioList($model, $attribute, $items, ['tag' => 'span', 'separator' => '&nbsp;&nbsp;&nbsp;']);
		            break;
		        case 'checkbox'://多选
		            $model->{$attribute} = $model->diyFieldCheckboxValue($attribute);
		            echo Html::activeCheckboxList($model, $attribute, $items, ['tag' => 'span', 'separator' => '&nbsp;&nbsp;&nbsp;']);
		            break;
		        case 'select'://下拉
		            echo Html::activeDropDownList($model, $attribute, $items);
		            break;
		        case 'datetime'://日期
		            echo LaydateWidget::widget([
    		            'model' => $model,
    		            'attribute' => $attribute,
		                'value' => $model->diyFieldDateTimeValue($attribute),
    		            'options' => ['class' => 'inputms'],
        			]);
		            break;
		        case 'file'://单文件
		            echo JQueryFileUploadWidget::widget([
    		            'model' => $model,
    		            'attribute' => $attribute,
    		            'options' => ['class' => 'input', 'readonly' => true],
    		            'url' => ['diyfield-fileupload', 'mid' => $mid],
    		            'uploadName' => DiyField::FIELD_UPLOAD_NAME,
    		            'fileOptions' => [
        		            'accept' => '*',//选择文件时的windows过滤器
        		            'multiple' => false,//单图
        		            'isImage' => true,//图片文件
                        ],//单图
		                'clientOptions' => [
		                    'acceptFileTypes' => new JsExpression('/(\.|\/)(gif|jpe?g|png|ai|txt|xls|xlsx|docx|doc|pdf|zip|rar|tar)$/i'),//限制上传的后缀名
		                ],
		            ]);
		            break;
		        case 'filearr'://多文件
		            echo JQueryFileUploadWidget::widget([
    		            'model' => $model,
    		            'attribute' => $attribute,
    		            'pics' => $model->diyFieldMultiFile($attribute),
    		            'options' => ['class' => 'input', 'readonly' => true],
    		            'url' => ['diyfield-multiple-fileupload', 'mid' => $mid],
    		            'uploadName' => DiyField::FIELD_MULTI_UPLOAD_NAME,
    		            'fileOptions' => [
        		            'accept' => '*',//选择文件时的windows过滤器
        		            'multiple' => true,//多图
        		            'isImage' => true,//图片文件
                        ],//多图
    		            'clientOptions' => [
                            'acceptFileTypes' => new JsExpression('/(\.|\/)(gif|jpe?g|png|ai|txt|xls|xlsx|docx|doc|pdf|zip|rar|tar)$/i'),//限制上传的后缀名
    		            ],
		            ]);
		            break;
		        default:
		            break;
		    }
		} else {
		    echo '该模型（'.get_class($model).'）中没有'.$attribute.'属性，请转到“自定义字段”编辑操作。';
		}
		?>
		<span class="cnote"><?= $fieldModel->fd_desc ?></span>
	</td>
</tr>
<?php } ?>

<tr class="nb no-prev-line" style="display: <?= (count($fieldModels)>0 && count($columnFieldModels)>0)?'':'none' ?>;">
	<td colspan="2" class="td-line"><div class="line"></div></td>
</tr>