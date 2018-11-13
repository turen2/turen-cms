<?php
use yii\helpers\Html;
use app\models\cms\DiyField;
?>
<tr class="nb no-prev-line">
	<td colspan="2" class="td-line"><div class="line"></div></td>
</tr>

<?php 
$columnClass = get_class($model);
foreach ($fieldModels as $fieldModel) { ?>
<tr>
	<td class="first-column"><?= $fieldModel->fd_title ?><?= ($fieldModel->fd_check == 'required')?'<span class="maroon">*</span>':'' ?></td>
	<td class="second-column">
		<?php 
		$attribute = DiyField::FIELD_PRE.$fieldModel->fd_name;
		if($model->hasAttribute($attribute)) {
		    switch ($fieldModel->fd_type) {
		        case 'varchar':
		            echo Html::activeTextInput($model, $attribute, ['class' => 'input']);
		            break;
		        case 'int':
		        case 'decimal':
		            echo Html::activeTextInput($model, $attribute, ['class' => 'inputs']);
		            break;
		        case 'text'://多文本
		            ;
		            break;
		        case 'mediumtext'://编辑器
		            ;
		            break;
		        case 'radio'://单选
		            ;
		            break;
		        case 'checkbox'://多选
		            ;
		            break;
		        case 'select'://下拉
		            ;
		            break;
		        case 'datetime'://日期
		            ;
		            break;
		        case 'file'://单文件
		            ;
		            break;
		        case 'filearr'://多文件
		            ;
		            break;
		        default:
		            ;
		            break;
		    }
		} else {
		    echo '该模型（'.get_class($model).'）中没有'.$attribute.'属性。';
		}
		?>
		<span class="cnote"><?= $fieldModel->fd_desc ?></span>
	</td>
</tr>
<?php } ?>

<tr class="nb no-prev-line">
	<td colspan="2" class="td-line"><div class="line"></div></td>
</tr>