<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use backend\models\ext\Nav;

$navArray = ArrayHelper::map(Nav::find()->current()->where(['parentid' => Nav::TOP_ID])->orderBy(['orderid' => SORT_DESC])->asArray()->all(), 'id', 'menuname');
?>

<?php
//-----------------------------------------------
$name = 'config_face_cn_main_nav_id';
$value = isset($config[$name])?$config[$name]:null;
?>
<tr>
    <td class="first-column">主菜单</td>
    <td class="second-column" width="33%">
        <?= Html::dropDownList($name, $value, ArrayHelper::merge([null => '请选择一个配置'], $navArray), ['id' => $name]) ?>
    </td>
    <td style="border-bottom: 1px dashed #efefef;">
        Yii::$app->params['<?=$name?>']
    </td>
</tr>

<?php
//-----------------------------------------------
$name = 'config_face_cn_bottom_nav_id';
$value = isset($config[$name])?$config[$name]:null;
?>
<tr>
    <td class="first-column">底部菜单</td>
    <td class="second-column" width="33%">
        <?= Html::dropDownList($name, $value, ArrayHelper::merge([null => '请选择一个配置'], $navArray), ['id' => $name]) ?>
    </td>
    <td style="border-bottom: 1px dashed #efefef;">
        Yii::$app->params['<?=$name?>']
    </td>
</tr>


