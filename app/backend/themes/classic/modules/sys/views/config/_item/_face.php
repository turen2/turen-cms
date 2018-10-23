<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\widgets\fileupload\JQueryFileUploadWidget;
use yii\web\JsExpression;

$config = ArrayHelper::index($config, 'varname');
?>

<tr>
	<td class="first-column"><?= $config['config_frontend_logo']['varinfo']; ?></td>
	<td class="second-column" width="33%">
		<?= JQueryFileUploadWidget::widget([
		    'name' => $config['config_frontend_logo']['varname'],
		    'value' => $config['config_frontend_logo']['varvalue'],
            'options' => ['class' => 'input', 'readonly' => true],
            'url' => ['fileupload', 'param' => 'value'],
            'uploadName' => 'logourl',
            'fileOptions' => [
                'accept' => '*',//选择文件时的windows过滤器
                'multiple' => false,//单图
                'isImage' => true,//图片文件
            ],//单图
            'clientOptions' => [
                'acceptFileTypes' => new JsExpression('/(\.|\/)(gif|jpe?g|png|ai|txt|xls|xlsx|docx|doc|pdf|zip|rar|tar)$/i'),//限制上传的后缀名
            ],
        ]) ?>
		<span class="cnote">切换模板后，请刷新整个页面</span>
	</td>
	<td style="border-bottom: 1px dashed #efefef;">
		Yii::$app->params['<?php echo $config['config_frontend_logo']['varname']; ?>']
	</td>
</tr>

<tr>
	<td class="first-column"><?= $config['config_backend_logo']['varinfo']; ?></td>
	<td class="second-column" width="33%">
		<?= JQueryFileUploadWidget::widget([
		    'name' => $config['config_backend_logo']['varname'],
		    'value' => $config['config_backend_logo']['varvalue'],
            'options' => ['class' => 'input', 'readonly' => true],
            'url' => ['fileupload', 'param' => 'value'],
            'uploadName' => 'logourl',
            'fileOptions' => [
                'accept' => '*',//选择文件时的windows过滤器
                'multiple' => false,//单图
                'isImage' => true,//图片文件
            ],//单图
            'clientOptions' => [
                'acceptFileTypes' => new JsExpression('/(\.|\/)(gif|jpe?g|png|ai|txt|xls|xlsx|docx|doc|pdf|zip|rar|tar)$/i'),//限制上传的后缀名
            ],
        ]) ?>
		<span class="cnote">切换模板后，请刷新整个页面</span>
	</td>
	<td style="border-bottom: 1px dashed #efefef;">
		Yii::$app->params['<?php echo $config['config_backend_logo']['varname']; ?>']
	</td>
</tr>