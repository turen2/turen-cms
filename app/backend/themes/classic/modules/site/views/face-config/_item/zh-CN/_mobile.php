<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use backend\models\cms\Column;
use backend\models\cms\Flag;
use backend\models\ext\Nav;
use backend\models\cms\Block;
use common\helpers\BuildHelper;

$models = Column::find()->current()->orderBy(['orderid' => SORT_DESC])->all();
$models = BuildHelper::reBuildModelKeys($models, 'id');//重构模型数组索引
$nexus = BuildHelper::getModelNexus($models, Column::class, 'id', 'parentid');//获取父子关系
$list = BuildHelper::buildList($nexus);

$navArray = ArrayHelper::map(Nav::find()->current()->where(['parentid' => Nav::TOP_ID])->orderBy(['orderid' => SORT_DESC])->asArray()->all(), 'id', 'menuname');
$blockArray =  ArrayHelper::map(Block::find()->current()->orderBy(['updated_at' => SORT_DESC])->asArray()->all(), 'id', 'title');
?>

<?php
//-----------------------------------------------
$name = 'config_face_mobile_cn_home_chexing_slide_column_id';
$value = isset($config[$name])?$config[$name]:null;
$flagName = 'config_face_mobile_cn_home_chexing_slide_column_flag';
$flagValue = isset($config[$flagName])?$config[$flagName]:null;
$columnArray = [];
$selectOptions = ['id' => $name, 'encode' => false, 'options' => []];
$options = [];
foreach ($list as $id => $item) {
    if(Column::COLUMN_TYPE_PHOTO != $models[$id]->type) {
        $options[$id] = ['disabled' => true];
    }
    //按照新的关系，重新排序
    $columnArray[$id] = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $item['level']-1).(empty($item['level']-1)?'':'|-').($models[$id]->cname);
}
$selectOptions['options'] = $options;
$selectOptions['onchange'] = "turen.com.linkedFlagList(this, ['".$flagName."']);";
?>
<tr>
    <td class="first-column">移动首页车型展示</td>
    <td class="second-column" width="33%">
        <?= Html::dropDownList($name, $value, ArrayHelper::merge([null => '请选择一个配置'], $columnArray), $selectOptions) ?>
        <?= Html::dropDownList($flagName, $flagValue, ArrayHelper::merge([null => '所有标记'], Flag::ColumnFlagList($value, true)), ['id' => $flagName]) ?>
    </td>
    <td style="border-bottom: 1px dashed #efefef;">
        Yii::$app->params['<?=$name?>']<br />
        Yii::$app->params['<?=$flagName?>']
    </td>
</tr>

<?php
//-----------------------------------------------
$name = 'config_face_mobile_cn_main_nav_id';
$value = isset($config[$name])?$config[$name]:null;
?>
<tr>
    <td class="first-column">移动主菜单</td>
    <td class="second-column" width="33%">
        <?= Html::dropDownList($name, $value, ArrayHelper::merge([null => '请选择一个配置'], $navArray), ['id' => $name]) ?>
    </td>
    <td style="border-bottom: 1px dashed #efefef;">
        Yii::$app->params['<?=$name?>']
    </td>
</tr>

<?php
//-----------------------------------------------
$name = 'config_face_mobile_cn_bottom_nav_id';
$value = isset($config[$name])?$config[$name]:null;
?>
<tr>
    <td class="first-column">移动底部菜单</td>
    <td class="second-column" width="33%">
        <?= Html::dropDownList($name, $value, ArrayHelper::merge([null => '请选择一个配置'], $navArray), ['id' => $name]) ?>
    </td>
    <td style="border-bottom: 1px dashed #efefef;">
        Yii::$app->params['<?=$name?>']
    </td>
</tr>

<?php
//-----------------------------------------------
$name = 'config_face_mobile_cn_about_nav_id';
$value = isset($config[$name])?$config[$name]:null;
?>
<tr>
    <td class="first-column">移动关于我们菜单</td>
    <td class="second-column" width="33%">
        <?= Html::dropDownList($name, $value, ArrayHelper::merge([null => '请选择一个配置'], $navArray), ['id' => $name]) ?>
    </td>
    <td style="border-bottom: 1px dashed #efefef;">
        Yii::$app->params['<?=$name?>']
    </td>
</tr>

<?php
//-----------------------------------------------
$name = 'config_face_mobile_cn_bottom_block_id';
$value = isset($config[$name])?$config[$name]:null;
?>
<tr>
    <td class="first-column">移动底部简述</td>
    <td class="second-column" width="33%">
        <?= Html::dropDownList($name, $value, ArrayHelper::merge([null => '请选择一个配置'], $blockArray), ['id' => $name]) ?>
    </td>
    <td style="border-bottom: 1px dashed #efefef;">
        Yii::$app->params['<?=$name?>']
    </td>
</tr>






