<?php
use yii\helpers\Html;
use common\components\aliyunoss\AliyunOss;

$context = $this->context;
$webUrl = Yii::getAlias('@web');

// $pic = ($context->hasModel()) ? Html::getInputName($context->model, $context->attribute) : $context->name;
// $value = ($context->hasModel()) ? Html::getAttributeValue($context->model, $context->attribute) : $context->value;
?>
<div class="image-main-upload">
    <?php 
    if ($context->hasModel()) {
        echo Html::activeTextInput($context->model, $context->attribute, $context->options);
    } else {
        echo Html::textInput($context->name, $context->value, $context->options);
    }
    ?>
    
    <span class="fileinput-button">
        <span class="gray-btn">上传</span>
        <?= Html::fileInput($context->uploadName, '', $context->fileOptions) ?>
    </span>
    
    <!-- <div class="progress-bar"><div class="success"></div></div> -->
    
    <div class="preview clearfix">
        <?php if(empty($pic)) { ?>
        <a href="javascript:;">
            <img class="thumbnail" src="<?= $webUrl ?>/images/nopic.jpg">
            <em title="删除这张图片" class="closebtn">×</em>
        </a>
        <?php } else { ?>
        <a href="javascript:;">
            <img class="thumbnail" title="<?= $pic ?>" src="<?= Yii::$app->aliyunoss->getObjectUrl($pic, true, AliyunOss::OSS_STYLE_NAME180X180) ?>">
            <em title="删除这张图片" class="closebtn">×</em>
        </a>
        <?php } ?>
    </div>
    <span class="cnote" style="margin-left: 0;">注意：如果加载时间会比较长，建议图片压缩到1M以内。</span>
</div>