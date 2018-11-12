<tr class="nb">
	<td colspan="2" class="td-line"><div class="line"> </div></td>
</tr>

<?php foreach ($models as $model) { ?>
<tr>
	<td class="first-column"><?= $model->fd_title ?><?= ($model->fd_check == 'required')?'<span class="maroon">*</span>':'' ?></td>
	<td class="second-column">
		<?php 
		switch ($model->fd_type) {
		    case 'varchar':
		    case 'int':
		    case 'decimal':
                ;
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
		?>
		<span class="cnote"><?= $model->fd_desc ?></span>
	</td>
</tr>
<?php } ?>

<tr class="nb">
	<td colspan="2" class="td-line"><div class="line"> </div></td>
</tr>