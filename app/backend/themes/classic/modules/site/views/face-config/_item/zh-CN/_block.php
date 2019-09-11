<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use app\models\cms\Block;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$blockArray =  ArrayHelper::map(Block::find()->current()->orderBy(['updated_at' => SORT_DESC])->asArray()->all(), 'id', 'title');
?>

<?php
//-----------------------------------------------
$name = 'config_face_cn_left_top_block_id';
$value = isset($config[$name])?$config[$name]:null;
?>
<tr>
    <td class="first-column">系统左上角公告</td>
    <td class="second-column" width="33%">
        <?= Html::dropDownList($name, $value, ArrayHelper::merge([null => '请选择一个配置'], $blockArray), ['id' => $name]) ?>
    </td>
    <td style="border-bottom: 1px dashed #efefef;">
        Yii::$app->params['<?=$name?>']
    </td>
</tr>

<?php
//-----------------------------------------------
$name = 'config_face_cn_left_bottom_block_id';
$value = isset($config[$name])?$config[$name]:null;
?>
<tr>
    <td class="first-column">系统左下角关于我们</td>
    <td class="second-column" width="33%">
        <?= Html::dropDownList($name, $value, ArrayHelper::merge([null => '请选择一个配置'], $blockArray), ['id' => $name]) ?>
    </td>
    <td style="border-bottom: 1px dashed #efefef;">
        Yii::$app->params['<?=$name?>']
    </td>
</tr>