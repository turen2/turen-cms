<?php 
use yii\helpers\Html;

$context = $this->context;
$webIconUrl = Yii::getAlias('@web/images/icon/');

$name_ = ($context->hasModel()) ? Html::getInputName($context->model, $context->attribute) : $context->name;
?>
<div class="fileupload-buttonbar">
    <div class="input-group">
        <?= Html::textInput('jorry', '批量上传文件', $context->options)//只显示  ?>
        
        <span class="input-group-btn">
            <span class="btn btn-primary fileinput-button">
                <span>添加文件</span>
                <?= Html::fileInput($context->uploadName, '', $context->fileOptions) ?>
            </span>
        </span>
    </div>
    
    <div class="fileupload-multi-progress">
        <div class="progress">
            <div class="progress-bar progress-bar-success"></div>
        </div>
    </div>
    
    <div class="input-group fileupload-img-multi-preview multi-img-details ui-sortable">
        <?php foreach ($names as $key => $name) { ?>
        <div class="multi-item">
            <input type="hidden" value="<?= $name ?>" name="<?= $name_ ?>[<?= $key ?>]">
            <img class="img-responsive img-thumbnail" title="<?= $name ?>" src="<?= $webIconUrl.strtolower(substr(strrchr($name, '.'), 1)).'.png';?>">
            <em title="删除这张图片" class="close">×</em>
        </div>
        <?php } ?>
    </div>
    <div class="help-block image-block"><i class="fa fa-info-circle" aria-hidden="true"></i> 多文件上传，不支持图片与非图片混合模式，可拖拽排序</div>
</div>
