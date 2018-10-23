<?php
use yii\helpers\Html;

$context = $this->context;
$webUrl = Yii::getAlias('@web/images/');
$webIconUrl = Yii::getAlias('@web/images/icon/');
?>
<div class="fileupload-buttonbar">
    <div class="input-group">
        <?php 
        if ($context->hasModel()) {
            echo Html::activeTextInput($context->model, $context->attribute, $context->options);
        } else {
            echo Html::textInput($context->name, $context->value, $context->options);
        }
        ?>
        <span class="input-group-btn">
            <span class="btn btn-primary fileinput-button">
                <span>添加文件</span>
                <?= Html::fileInput($context->uploadName, '', $context->fileOptions) ?>
            </span>
        </span>
    </div>
    
    <div class="fileupload-progress">
        <div class="progress">
            <div class="progress-bar progress-bar-success"></div>
        </div>
    </div>
    
    <div class="input-group fileupload-img-preview" style="margin-top: 10px">
        <?php if(empty($name)) { ?>
        <a href="javascript:;">
            <img class="img-responsive img-thumbnail" src="<?= $webUrl?>nopic.jpg">
            <em title="删除这张图片" class="close">×</em>
        </a>
        <?php } else { ?>
        <a href="javascript:;">
            <img class="img-responsive img-thumbnail" title="<?= $name ?>" src="<?= $webIconUrl.(substr(strrchr($name, '.'), 1)).'.png' ?>">
            <em title="删除这张图片" class="close">×</em>
        </a>
        <?php } ?>
    </div>
</div>




        