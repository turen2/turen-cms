<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\helpers\BuildHelper;
use backend\models\cms\Column;
use backend\models\cms\Flag;

//栏目数据
$columnModels = Column::find()->current()->orderBy(['orderid' => SORT_DESC])->all();
$columnModels = BuildHelper::reBuildModelKeys($columnModels, 'id');//重构模型数组索引
$nexus = BuildHelper::getModelNexus($columnModels, Column::class, 'id', 'parentid');//获取父子关系
$columnList = BuildHelper::buildList($nexus);
?>

<?php
//-----------------------------------------------
$name = 'config_face_cn_case_column_id';
$value = isset($config[$name])?$config[$name]:null;
$columnArray = [];
$selectOptions = ['id' => $name, 'encode' => false, 'options' => []];
$options = [];
foreach ($columnList as $id => $item) {
    if(Column::COLUMN_TYPE_PHOTO != $columnModels[$id]->type) {
        $options[$id] = ['disabled' => true];
    }
    //按照新的关系，重新排序
    $columnArray[$id] = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $item['level']-1).(empty($item['level']-1)?'':'|-').($columnModels[$id]->cname);
}
$selectOptions['options'] = $options;
$selectOptions['onchange'] = "turen.com.linkedFlagList(this, ['case1', 'case2', 'case3']);";
?>
<tr>
    <td class="first-column">案例展示模块栏目</td>
    <td class="second-column" width="33%">
        <?= Html::dropDownList($name, $value, ArrayHelper::merge([null => '请选择一个配置'], $columnArray), $selectOptions) ?>
    </td>
    <td style="border-bottom: 1px dashed #efefef;">
        Yii::$app->params['<?=$name?>']
    </td>
</tr>

<?php
//-----------------------------------------------
$flagName = 'config_face_cn_case_column_seemore_flag';
$flagValue = isset($config[$flagName])?$config[$flagName]:null;
?>
<tr>
    <td class="first-column">案例展示 - 看了还看标记</td>
    <td class="second-column" width="33%">
        <?= Html::dropDownList($flagName, $flagValue, ArrayHelper::merge([null => '所有标记'], Flag::ColumnFlagList($value, true)), ['id' => 'case1']) ?>
    </td>
    <td style="border-bottom: 1px dashed #efefef;">
        Yii::$app->params['<?=$flagName?>']
    </td>
</tr>

<?php
//-----------------------------------------------
$flagName = 'config_face_cn_case_column_related_flag';
$flagValue = isset($config[$flagName])?$config[$flagName]:null;
?>
<tr>
    <td class="first-column">案例展示 - 相关阅读标记</td>
    <td class="second-column" width="33%">
        <?= Html::dropDownList($flagName, $flagValue, ArrayHelper::merge([null => '所有标记'], Flag::ColumnFlagList($value, true)), ['id' => 'case2']) ?>
    </td>
    <td style="border-bottom: 1px dashed #efefef;">
        Yii::$app->params['<?=$flagName?>']
    </td>
</tr>

<?php
//-----------------------------------------------
$flagName = 'config_face_cn_case_column_sidebox_flag';
$flagValue = isset($config[$flagName])?$config[$flagName]:null;
?>
<tr>
    <td class="first-column">案例展示 - 侧边栏推荐标记</td>
    <td class="second-column" width="33%">
        <?= Html::dropDownList($flagName, $flagValue, ArrayHelper::merge([null => '所有标记'], Flag::ColumnFlagList($value, true)), ['id' => 'case3']) ?>
    </td>
    <td style="border-bottom: 1px dashed #efefef;">
        Yii::$app->params['<?=$flagName?>']
    </td>
</tr>