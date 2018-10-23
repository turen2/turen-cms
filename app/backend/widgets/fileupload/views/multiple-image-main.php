<?php
use yii\helpers\Html;
use common\components\aliyunoss\AliyunOss;

$context = $this->context;

$pic_ = ($context->hasModel()) ? Html::getInputName($context->model, $context->attribute) : $context->name;
?>

<div class="multiple-image-main-upload">
    <?= Html::hiddenInput('nothing', '批量上传文件', $context->options)//只显示  ?>
    <fieldset>
    	<legend>列表</legend>
    	<div class="head">最多可以上传<strong>20</strong>张图片<span class="fileinput-button"><span>开始上传</span><?= Html::fileInput($context->uploadName, '', $context->fileOptions) ?></span></div>
    	
    	<!-- <div class="progress-bar"><div class="success"></div></div> -->
    	
    	<div class="pic-box">
        	<ul class="preview ui-sortable clearfix">
                <?php foreach ($pics as $key => $pic) { ?>
                <li class="item">
                	<a href="javascript:;">
                        <input class="pic" type="hidden" value="<?= $pic['pic'] ?>" name="<?= $pic_ ?>[<?= $key ?>][pic]" />
                        <img class="thumbnail" title="<?= $pic['txt'] ?>" src="<?= Yii::$app->aliyunoss->getObjectUrl($pic['pic'], true, AliyunOss::OSS_STYLE_NAME180X180) ?>">
                        <em title="删除这张图片" class="closebtn">×</em>
                    </a>
                    <span class="img-name">
                    	<input class="txt" type="text" value="<?= $pic['txt'] ?>" name="<?= $pic_ ?>[<?= $key ?>][txt]" />
                	</span>
                </li>
                <?php } ?>
            </ul>
            <span class="cnote" style="margin-left: 0;">注意：可直接用鼠标在图片上拖拽进行排序</span>
        </div>
    </fieldset>
</div>