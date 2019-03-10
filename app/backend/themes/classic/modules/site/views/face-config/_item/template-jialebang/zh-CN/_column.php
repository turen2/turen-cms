<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use app\models\cms\Column;
use common\helpers\BuildHelper;
use common\models\cms\Flag;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

//获取数据
$models = Column::find()->current()->orderBy(['orderid' => SORT_DESC])->all();
$models = BuildHelper::reBuildModelKeys($models, 'id');//重构模型数组索引
$nexus = BuildHelper::getModelNexus($models, Column::class, 'id', 'parentid');//获取父子关系
$list = BuildHelper::buildList($nexus);
?>

<?php
//-----------------------------------------------
$name = 'config_face_banjia_cn_home_baike_column_id';
$value = isset($config[$name])?$config[$name]:null;
$flagName = 'config_face_banjia_cn_home_baike_column_flag';
$flagValue = isset($config[$flagName])?$config[$flagName]:null;
$columnArray = [];
$selectOptions = ['id' => $name, 'encode' => false, 'options' => []];
$options = [];
foreach ($list as $id => $item) {
    if(Column::COLUMN_TYPE_ARTICLE != $models[$id]->type) {
        $options[$id] = ['disabled' => true];
    }
    //按照新的关系，重新排序
    $columnArray[$id] = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $item['level']-1).(empty($item['level']-1)?'':'|-').($models[$id]->cname);
}
$selectOptions['options'] = $options;
?>
<tr>
    <td class="first-column">首页百科推荐</td>
    <td class="second-column" width="33%">
        <?= Html::dropDownList($name, $value, ArrayHelper::merge([null => '请选择一个配置'], $columnArray), $selectOptions) ?>
        <?= Html::dropDownList($flagName, $flagValue, ArrayHelper::merge([null => '所有标记'], Flag::FlagList(Column::COLUMN_TYPE_ARTICLE, true))) ?>
    </td>
    <td style="border-bottom: 1px dashed #efefef;">
        Yii::$app->params['<?=$name?>']<br />
        Yii::$app->params['<?=$flagName?>']
    </td>
</tr>

<?php
//-----------------------------------------------
$name = 'config_face_banjia_cn_home_news_column_id';
$value = isset($config[$name])?$config[$name]:null;
$flagName = 'config_face_banjia_cn_home_news_column_flag';
$flagValue = isset($config[$flagName])?$config[$flagName]:null;
$columnArray = [];
$selectOptions = ['id' => $name, 'encode' => false, 'options' => []];
$options = [];
foreach ($list as $id => $item) {
    if(Column::COLUMN_TYPE_ARTICLE != $models[$id]->type) {
        $options[$id] = ['disabled' => true];
    }
    //按照新的关系，重新排序
    $columnArray[$id] = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $item['level']-1).(empty($item['level']-1)?'':'|-').($models[$id]->cname);
}
$selectOptions['options'] = $options;
?>
<tr>
    <td class="first-column">首页行业动态推荐</td>
    <td class="second-column" width="33%">
        <?= Html::dropDownList($name, $value, ArrayHelper::merge([null => '请选择一个配置'], $columnArray), $selectOptions) ?>
        <?= Html::dropDownList($flagName, $flagValue, ArrayHelper::merge([null => '所有标记'], Flag::FlagList(Column::COLUMN_TYPE_ARTICLE, true))) ?>
    </td>
    <td style="border-bottom: 1px dashed #efefef;">
        Yii::$app->params['<?=$name?>']<br />
        Yii::$app->params['<?=$flagName?>']
    </td>
</tr>

<?php
//-----------------------------------------------
$name = 'config_face_banjia_cn_home_help_column_id';
$value = isset($config[$name])?$config[$name]:null;
$flagName = 'config_face_banjia_cn_home_help_column_flag';
$flagValue = isset($config[$flagName])?$config[$flagName]:null;
$columnArray = [];
$selectOptions = ['id' => $name, 'encode' => false, 'options' => []];
$options = [];
foreach ($list as $id => $item) {
    if(Column::COLUMN_TYPE_ARTICLE != $models[$id]->type) {
        $options[$id] = ['disabled' => true];
    }
    //按照新的关系，重新排序
    $columnArray[$id] = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $item['level']-1).(empty($item['level']-1)?'':'|-').($models[$id]->cname);
}
$selectOptions['options'] = $options;
?>
<tr>
    <td class="first-column">首页帮助中心推荐</td>
    <td class="second-column" width="33%">
        <?= Html::dropDownList($name, $value, ArrayHelper::merge([null => '请选择一个配置'], $columnArray), $selectOptions) ?>
        <?= Html::dropDownList($flagName, $flagValue, ArrayHelper::merge([null => '所有标记'], Flag::FlagList(Column::COLUMN_TYPE_ARTICLE, true))) ?>
    </td>
    <td style="border-bottom: 1px dashed #efefef;">
        Yii::$app->params['<?=$name?>']<br />
        Yii::$app->params['<?=$flagName?>']
    </td>
</tr>

<?php
//-----------------------------------------------
$name = 'config_face_banjia_cn_home_case_column_id';
$value = isset($config[$name])?$config[$name]:null;
$flagName = 'config_face_banjia_cn_home_case_column_flag';
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
?>
<tr>
    <td class="first-column">首页案例推荐</td>
    <td class="second-column" width="33%">
        <?= Html::dropDownList($name, $value, ArrayHelper::merge([null => '请选择一个配置'], $columnArray), $selectOptions) ?>
        <?= Html::dropDownList($flagName, $flagValue, ArrayHelper::merge([null => '所有标记'], Flag::FlagList(Column::COLUMN_TYPE_PHOTO, true))) ?>
    </td>
    <td style="border-bottom: 1px dashed #efefef;">
        Yii::$app->params['<?=$name?>']<br />
        Yii::$app->params['<?=$flagName?>']
    </td>
</tr>

<?php
//-----------------------------------------------
$name = 'config_face_banjia_cn_baike_column_id';
$value = isset($config[$name])?$config[$name]:null;
$flagName = 'config_face_banjia_cn_baike_column_flag';
$flagValue = isset($config[$flagName])?$config[$flagName]:null;
$columnArray = [];
$selectOptions = ['id' => $name, 'encode' => false, 'options' => []];
$options = [];
foreach ($list as $id => $item) {
    if(Column::COLUMN_TYPE_ARTICLE != $models[$id]->type) {
        $options[$id] = ['disabled' => true];
    }
    //按照新的关系，重新排序
    $columnArray[$id] = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $item['level']-1).(empty($item['level']-1)?'':'|-').($models[$id]->cname);
}
$selectOptions['options'] = $options;
?>
<tr>
    <td class="first-column">系统搬家百科列表</td>
    <td class="second-column" width="33%">
        <?= Html::dropDownList($name, $value, ArrayHelper::merge([null => '请选择一个配置'], $columnArray), $selectOptions) ?>
        <?= Html::dropDownList($flagName, $flagValue, ArrayHelper::merge([null => '所有标记'], Flag::FlagList(Column::COLUMN_TYPE_ARTICLE, true))) ?>
    </td>
    <td style="border-bottom: 1px dashed #efefef;">
        Yii::$app->params['<?=$name?>']<br />
        Yii::$app->params['<?=$flagName?>']
    </td>
</tr>

<?php
//-----------------------------------------------
$name = 'config_face_banjia_cn_news_column_id';
$value = isset($config[$name])?$config[$name]:null;
$flagName = 'config_face_banjia_cn_news_column_flag';
$flagValue = isset($config[$flagName])?$config[$flagName]:null;
$columnArray = [];
$selectOptions = ['id' => $name, 'encode' => false, 'options' => []];
$options = [];
foreach ($list as $id => $item) {
    if(Column::COLUMN_TYPE_ARTICLE != $models[$id]->type) {
        $options[$id] = ['disabled' => true];
    }
    //按照新的关系，重新排序
    $columnArray[$id] = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $item['level']-1).(empty($item['level']-1)?'':'|-').($models[$id]->cname);
}
$selectOptions['options'] = $options;
?>
<tr>
    <td class="first-column">系统行业动态列表</td>
    <td class="second-column" width="33%">
        <?= Html::dropDownList($name, $value, ArrayHelper::merge([null => '请选择一个配置'], $columnArray), $selectOptions) ?>
        <?= Html::dropDownList($flagName, $flagValue, ArrayHelper::merge([null => '所有标记'], Flag::FlagList(Column::COLUMN_TYPE_ARTICLE, true))) ?>
    </td>
    <td style="border-bottom: 1px dashed #efefef;">
        Yii::$app->params['<?=$name?>']<br />
        Yii::$app->params['<?=$flagName?>']
    </td>
</tr>

<?php
//-----------------------------------------------
$name = 'config_face_banjia_cn_service_column_id';
$value = isset($config[$name])?$config[$name]:null;
$flagName = 'config_face_banjia_cn_service_column_flag';
$flagValue = isset($config[$flagName])?$config[$flagName]:null;
$columnArray = [];
$selectOptions = ['id' => $name, 'encode' => false, 'options' => []];
$options = [];
foreach ($list as $id => $item) {
    if(Column::COLUMN_TYPE_PRODUCT != $models[$id]->type) {
        $options[$id] = ['disabled' => true];
    }
    //按照新的关系，重新排序
    $columnArray[$id] = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $item['level']-1).(empty($item['level']-1)?'':'|-').($models[$id]->cname);
}
$selectOptions['options'] = $options;
?>
<tr>
    <td class="first-column">系统服务范围列表</td>
    <td class="second-column" width="33%">
        <?= Html::dropDownList($name, $value, ArrayHelper::merge([null => '请选择一个配置'], $columnArray), $selectOptions) ?>
        <?= Html::dropDownList($flagName, $flagValue, ArrayHelper::merge([null => '所有标记'], Flag::FlagList(Column::COLUMN_TYPE_PRODUCT, true))) ?>
    </td>
    <td style="border-bottom: 1px dashed #efefef;">
        Yii::$app->params['<?=$name?>']<br />
        Yii::$app->params['<?=$flagName?>']
    </td>
</tr>

<?php
//-----------------------------------------------
$name = 'config_face_banjia_cn_case_column_id';
$value = isset($config[$name])?$config[$name]:null;
$flagName = 'config_face_banjia_cn_case_column_flag';
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
?>
<tr>
    <td class="first-column">系统案例展示列表</td>
    <td class="second-column" width="33%">
        <?= Html::dropDownList($name, $value, ArrayHelper::merge([null => '请选择一个配置'], $columnArray), $selectOptions) ?>
        <?= Html::dropDownList($flagName, $flagValue, ArrayHelper::merge([null => '所有标记'], Flag::FlagList(Column::COLUMN_TYPE_PHOTO, true))) ?>
    </td>
    <td style="border-bottom: 1px dashed #efefef;">
        Yii::$app->params['<?=$name?>']<br />
        Yii::$app->params['<?=$flagName?>']
    </td>
</tr>

<?php
//-----------------------------------------------
$name = 'config_face_banjia_cn_about_us_column_id';
$value = isset($config[$name])?$config[$name]:null;
$flagName = 'config_face_banjia_cn_about_us_column_flag';
$flagValue = isset($config[$flagName])?$config[$flagName]:null;
$columnArray = [];
$selectOptions = ['id' => $name, 'encode' => false, 'options' => []];
$options = [];
foreach ($list as $id => $item) {
    if(Column::COLUMN_TYPE_INFO != $models[$id]->type) {
        $options[$id] = ['disabled' => true];
    }
    //按照新的关系，重新排序
    $columnArray[$id] = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $item['level']-1).(empty($item['level']-1)?'':'|-').($models[$id]->cname);
}
$selectOptions['options'] = $options;
?>
<tr>
    <td class="first-column">搬家关于我们</td>
    <td class="second-column" width="33%">
        <?= Html::dropDownList($name, $value, ArrayHelper::merge([null => '请选择一个配置'], $columnArray), $selectOptions) ?>
        <?= Html::dropDownList($flagName, $flagValue, ArrayHelper::merge([null => '所有标记'], Flag::FlagList(Column::COLUMN_TYPE_INFO, true))) ?>
    </td>
    <td style="border-bottom: 1px dashed #efefef;">
        Yii::$app->params['<?=$name?>']<br />
        Yii::$app->params['<?=$flagName?>']
    </td>
</tr>