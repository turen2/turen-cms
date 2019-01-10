<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use app\models\cms\Column;
use common\helpers\BuildHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

//获取数据
$models = Column::find()->current()->orderBy(['orderid' => SORT_DESC])->all();
$models = BuildHelper::reBuildModelKeys($models, 'id');//重构模型数组索引
$nexus = BuildHelper::getModelNexus($models, Column::class, 'id', 'parentid');//获取父子关系
$list = BuildHelper::buildList($nexus);
$columnArray = [];
foreach ($list as $id => $item) {
    //按照新的关系，重新排序
    $columnArray[$id] = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $item['level']-1).(empty($item['level']-1)?'':'|-').($models[$id]->cname);
}
?>

<?php
//-----------------------------------------------
$name = 'config_face_banjia_cn_baike_column_id';
$value = isset($config[$name])?$config[$name]:null;
?>
<tr>
    <td class="first-column">搬家站搬家百科列表</td>
    <td class="second-column" width="33%">
        <?= Html::dropDownList($name, $value, ArrayHelper::merge([null => '请选择一个配置'], $columnArray), ['id' => $name, 'encode' => false]) ?>
    </td>
    <td style="border-bottom: 1px dashed #efefef;">
        Yii::$app->params['<?=$name?>']
    </td>
</tr>

<?php
//-----------------------------------------------
$name = 'config_face_banjia_cn_news_column_id';
$value = isset($config[$name])?$config[$name]:null;
?>
<tr>
    <td class="first-column">搬家站行业动态列表</td>
    <td class="second-column" width="33%">
        <?= Html::dropDownList($name, $value, ArrayHelper::merge([null => '请选择一个配置'], $columnArray), ['id' => $name, 'encode' => false]) ?>
    </td>
    <td style="border-bottom: 1px dashed #efefef;">
        Yii::$app->params['<?=$name?>']
    </td>
</tr>

<?php
//-----------------------------------------------
$name = 'config_face_banjia_cn_service_column_id';
$value = isset($config[$name])?$config[$name]:null;
?>
<tr>
    <td class="first-column">搬家站服务范围列表</td>
    <td class="second-column" width="33%">
        <?= Html::dropDownList($name, $value, ArrayHelper::merge([null => '请选择一个配置'], $columnArray), ['id' => $name, 'encode' => false]) ?>
    </td>
    <td style="border-bottom: 1px dashed #efefef;">
        Yii::$app->params['<?=$name?>']
    </td>
</tr>

<?php
//-----------------------------------------------
$name = 'config_face_banjia_cn_case_column_id';
$value = isset($config[$name])?$config[$name]:null;
?>
<tr>
    <td class="first-column">搬家站案例展示列表</td>
    <td class="second-column" width="33%">
        <?= Html::dropDownList($name, $value, ArrayHelper::merge([null => '请选择一个配置'], $columnArray), ['id' => $name, 'encode' => false]) ?>
    </td>
    <td style="border-bottom: 1px dashed #efefef;">
        Yii::$app->params['<?=$name?>']
    </td>
</tr>