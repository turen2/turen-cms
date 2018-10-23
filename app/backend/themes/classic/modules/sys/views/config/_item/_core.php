<?php 
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\sys\Template;

$config = ArrayHelper::index($config, 'varname');

return;
?>

<tr>
	<td class="first-column"><?= $config['config_template_id']['varinfo']; ?></td>
	<td class="second-column" width="33%">
		<?= Html::dropDownList($config['config_template_id']['varname'], $config['config_template_id']['varvalue'], ArrayHelper::map(Template::find()->all(), 'temp_id', 'temp_name'), ['id' => $config['config_template_id']['varname']]) ?>
		<span class="cnote">切换模板后，请刷新整个页面</span>
	</td>
	<td style="border-bottom: 1px dashed #efefef;">
		Yii::$app->params['<?php echo $config['config_template_id']['varname']; ?>']
	</td>
</tr>