<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\helpers\BuildHelper;
use backend\models\ext\AdType;
use backend\models\cms\Column;
use backend\models\cms\Flag;

//广告位下拉
$adTypeModels = AdType::find()->current()->orderBy(['orderid' => SORT_DESC])->all();
$adTypeModels = BuildHelper::reBuildModelKeys($adTypeModels, 'id');//重构模型数组索引
$nexus = BuildHelper::getModelNexus($adTypeModels, AdType::class, 'id', 'parentid');//获取父子关系
$adTypeList = BuildHelper::buildList($nexus);
$adTypeArray = [];
foreach ($adTypeList as $id => $item) {
    //按照新的关系，重新排序
    $adTypeArray[$id] = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $item['level']-1).(empty($item['level']-1)?'':'|-').($adTypeModels[$id]->typename);
}

//栏目数据
$columnModels = Column::find()->current()->orderBy(['orderid' => SORT_DESC])->all();
$columnModels = BuildHelper::reBuildModelKeys($columnModels, 'id');//重构模型数组索引
$nexus = BuildHelper::getModelNexus($columnModels, Column::class, 'id', 'parentid');//获取父子关系
$columnList = BuildHelper::buildList($nexus);
?>

<?php
//-----------------------------------------------
$name = 'config_face_cn_home_main_ad_type_id';
$value = isset($config[$name])?$config[$name]:null;
?>
<tr>
    <td class="first-column">首页主幻灯片广告位</td>
    <td class="second-column" width="33%">
        <?= Html::dropDownList($name, $value, ArrayHelper::merge([null => '请选择一个配置'], $adTypeArray), ['id' => $name, 'encode' => false]) ?>
    </td>
    <td style="border-bottom: 1px dashed #efefef;">
        Yii::$app->params['<?=$name?>']
    </td>
</tr>

<?php
//-----------------------------------------------
$name = 'config_face_cn_home_service_column_id';
$value = isset($config[$name])?$config[$name]:null;
$flagName = 'config_face_cn_home_service_column_flag';
$flagValue = isset($config[$flagName])?$config[$flagName]:null;
$columnArray = [];
$selectOptions = ['id' => $name, 'encode' => false, 'options' => []];
$options = [];
foreach ($columnList as $id => $item) {
    if(Column::COLUMN_TYPE_PRODUCT != $columnModels[$id]->type) {
        $options[$id] = ['disabled' => true];
    }
    //按照新的关系，重新排序
    $columnArray[$id] = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $item['level']-1).(empty($item['level']-1)?'':'|-').($columnModels[$id]->cname);
}
$selectOptions['options'] = $options;
$selectOptions['onchange'] = "turen.com.linkedFlagList(this, ['".$flagName."']);";
?>
<tr>
    <td class="first-column">首页精选业务推荐</td>
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
$name = 'config_face_cn_home_case_slide_column_id';
$value = isset($config[$name])?$config[$name]:null;
$flagName = 'config_face_cn_home_case_slide_column_flag';
$flagValue = isset($config[$flagName])?$config[$flagName]:null;
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
$selectOptions['onchange'] = "turen.com.linkedFlagList(this, ['".$flagName."']);";
?>
<tr>
    <td class="first-column">首页现场案例幻灯片</td>
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
$name = 'config_face_cn_home_case_column_id';
$value = isset($config[$name])?$config[$name]:null;
$flagName = 'config_face_cn_home_case_column_flag';
$flagValue = isset($config[$flagName])?$config[$flagName]:null;
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
$selectOptions['onchange'] = "turen.com.linkedFlagList(this, ['".$flagName."']);";
?>
<tr>
    <td class="first-column">首页现场案例推荐</td>
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
$name = 'config_face_cn_home_company_column_id';
$value = isset($config[$name])?$config[$name]:null;
$flagName = 'config_face_cn_home_company_column_flag';
$flagValue = isset($config[$flagName])?$config[$flagName]:null;
$columnArray = [];
$selectOptions = ['id' => $name, 'encode' => false, 'options' => []];
$options = [];
foreach ($columnList as $id => $item) {
    if(Column::COLUMN_TYPE_ARTICLE != $columnModels[$id]->type) {
        $options[$id] = ['disabled' => true];
    }
    //按照新的关系，重新排序
    $columnArray[$id] = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $item['level']-1).(empty($item['level']-1)?'':'|-').($columnModels[$id]->cname);
}
$selectOptions['options'] = $options;
$selectOptions['onchange'] = "turen.com.linkedFlagList(this, ['".$flagName."']);";
?>
<tr>
    <td class="first-column">首页公司新闻推荐</td>
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
$name = 'config_face_cn_home_news_column_id';
$value = isset($config[$name])?$config[$name]:null;
$flagName = 'config_face_cn_home_news_column_flag';
$flagValue = isset($config[$flagName])?$config[$flagName]:null;
$columnArray = [];
$selectOptions = ['id' => $name, 'encode' => false, 'options' => []];
$options = [];
foreach ($columnList as $id => $item) {
    if(Column::COLUMN_TYPE_ARTICLE != $columnModels[$id]->type) {
        $options[$id] = ['disabled' => true];
    }
    //按照新的关系，重新排序
    $columnArray[$id] = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $item['level']-1).(empty($item['level']-1)?'':'|-').($columnModels[$id]->cname);
}
$selectOptions['options'] = $options;
$selectOptions['onchange'] = "turen.com.linkedFlagList(this, ['".$flagName."']);";
?>
<tr>
    <td class="first-column">首页行业动态推荐</td>
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
$name = 'config_face_cn_home_help_column_id';
$value = isset($config[$name])?$config[$name]:null;
$flagName = 'config_face_cn_home_help_column_flag';
$flagValue = isset($config[$flagName])?$config[$flagName]:null;
$columnArray = [];
$selectOptions = ['id' => $name, 'encode' => false, 'options' => []];
$options = [];
foreach ($columnList as $id => $item) {
    if(Column::COLUMN_TYPE_ARTICLE != $columnModels[$id]->type) {
        $options[$id] = ['disabled' => true];
    }
    //按照新的关系，重新排序
    $columnArray[$id] = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $item['level']-1).(empty($item['level']-1)?'':'|-').($columnModels[$id]->cname);
}
$selectOptions['options'] = $options;
$selectOptions['onchange'] = "turen.com.linkedFlagList(this, ['".$flagName."']);";
?>
<tr>
    <td class="first-column">首页帮助中心推荐</td>
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
$name = 'config_face_cn_home_conment_ad_type_id';
$value = isset($config[$name])?$config[$name]:null;
?>
<tr>
    <td class="first-column">首页用户好评广告位</td>
    <td class="second-column" width="33%">
        <?= Html::dropDownList($name, $value, ArrayHelper::merge([null => '请选择一个配置'], $adTypeArray), ['id' => $name, 'encode' => false]) ?>
    </td>
    <td style="border-bottom: 1px dashed #efefef;">
        Yii::$app->params['<?=$name?>']
    </td>
</tr>

<?php
//-----------------------------------------------
$name = 'config_face_cn_home_service_company_ad_type_id';
$value = isset($config[$name])?$config[$name]:null;
?>
<tr>
    <td class="first-column">首页重要合作客户</td>
    <td class="second-column" width="33%">
        <?= Html::dropDownList($name, $value, ArrayHelper::merge([null => '请选择一个配置'], $adTypeArray), ['id' => $name, 'encode' => false]) ?>
    </td>
    <td style="border-bottom: 1px dashed #efefef;">
        Yii::$app->params['<?=$name?>']
    </td>
</tr>

